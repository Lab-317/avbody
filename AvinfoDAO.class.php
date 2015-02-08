<?
class AvinfoDAO{
    private $dbh;
    private $UserDAO;
    function __construct() {
          $this->dbh = new connexion();
	  $this->UserDAO = new UserDAO();
    }
    function setComment($avid,$uid,$content){
    	$sth = $this->dbh->prepare("INSERT INTO comment (avid,uid,content) values(?,?,?)");
    	$sth ->execute(array($avid,$uid,$content));
    	return "success";
    }

    function getComment($avid){
    	$sth = $this->dbh->prepare("SELECT user.name as name,comment.content as content,comment.commentTime as commentTime FROM user join comment WHERE user.uid = comment.uid and avid = ?");
    	$sth->execute(array($avid));
    	$res = $sth->fetchAll();
    	return $res;
    }
    function addImgpath($imgpath,$avid){
    	$sth = $this->dbh->prepare("UPDATE av_fileinfo SET photo_path=? where av_fileid=?");
    	$sth ->execute(array($imgpath,$avid));
    	return "success";
    }
	function getAVByTagid($tagid){
		$sth = $this->dbh->prepare("SELECT * from tagmap ,av_fileinfo ,av_information  where t_id = ? AND av_fileid = tagmap.av_id AND av_fileid = av_information.av_id");
		$sth ->execute(array($tagid));
		$res = $sth->fetchAll();
		return $res;
	}
	function getAllAVTag(){
		$sth = $this->dbh->prepare("SELECT t.t_name,t.t_id,count(tm_id) as count FROM tagmap m ,tag t where t.t_id = m.t_id  group by t.t_id");
		$sth ->execute(array($avid));
		$res = $sth->fetchAll();
		return $res;
	}
	function getAllAVTagAndRank(){
		$sth = $this->dbh->prepare("SELECT * FROM tag");
                $sth ->execute(array($avid));
                $res = $sth->fetchAll();
                return $res;
	}
	function getAVTag($avid){
		$sth = $this->dbh->prepare("SELECT tag.t_id, t_name  FROM tagmap LEFT join tag on tagmap.t_id = tag.t_id WHERE tagmap.av_id=?");
		$sth ->execute(array($avid));
		$res = $sth->fetchAll();
		return $res;
	}
	
	function deleteTag($avid,$tid){
		$sth = $this->dbh->prepare("DELETE FROM tagmap where av_id=? and t_id=?");
		$sth ->execute(array($avid,$tid));
		return "success";
	}
	
	function addTag($avid,$tname){
		$sth = $this->dbh->prepare("SELECT t_id  as id FROM tag where t_name =?");
		$sth ->execute(array($tname));
		$res = $sth->fetch();
		if($res['id']){
			$this->UserDAO->addScore($_SESSION['uid'],3);
			$sth2 = $this->dbh->prepare("INSERT INTO tagmap (av_id,t_id) VALUES (?,?)");
			$sth2 ->execute(array($avid,$res['id']));
			return "success";
		}
		else{
			$this->UserDAO->addScore($_SESSION['uid'],3);
			$sth2 = $this->dbh->prepare("INSERT INTO tag (t_name) VALUES (?)");
			$sth2 ->execute(array($tname));
			$sth3 = $this->dbh->prepare("SELECT t_id as id FROM tag where t_name =?");
			$sth3 ->execute(array($tname));
			$res3 = $sth3->fetch();
			$sth4 = $this->dbh->prepare("INSERT INTO tagmap (av_id,t_id) VALUES (?,?)");
			$sth4 ->execute(array($avid,$res3['id']));
			return "success";
		}
	}
	
	function getScoredPeopleNum($avid){
        $sth = $this->dbh->prepare("SELECT count(score) as count from review where av_id=? and score>0");
		$sth->execute(array($avid));
		$res = $sth->fetch();
		$number=$res['count'];
		return $number;
    }
    
    function getUserReview($uid,$avid){
        $sth = $this->dbh->prepare("SELECT score as score,mine as mine from review where u_id=? and av_id=?");
		$sth->execute(array($uid,$avid));
		$res = $sth->fetch();
		return $res;
    }
    
    function checkDownloaded($uid,$avid){
    	$sth = $this->dbh->prepare("SELECT count(*) as count FROM downloadlog where uid = ? and av_fileid = ?");
    	$sth->execute(array($uid,$avid));
    	$res = $sth->fetch();
    	return $res['count'];
    }
    
	function addStarRating($uid,$avid,$score){
		$sth = $this->dbh->prepare("SELECT count(score) as count from review where u_id=? and av_id=?");
		$sth->execute(array($uid,$avid));
		$res = $sth->fetch();
		if ($res['count']<=0 ) //未評過分
		{
			$this->UserDAO->addScore($uid,2);
			$sth2= $this->dbh->prepare("INSERT INTO review (u_id,av_id,score) VALUES (?,?,?)");
			$sth2->execute(array($uid,$avid,$score));
		}
		else{ //若已評過分(修改評分)
			$sth2 = $this->dbh->prepare("UPDATE review SET score = ? where av_id=?");
			$sth2->execute(array($score,$avid));
		}
		$sth3 = $this->dbh->prepare("SELECT count(score) as count from review where av_id=? and score>0");
		$sth3->execute(array($avid));
		$res = $sth3->fetch();
		$number=$res['count'];		
		
		if($number>1){
			$sth4= $this->dbh->prepare("UPDATE av_information SET scoreavg =((scoreavg*($number-1))+?)/$number where av_id=?");
			$sth4->bindParam(1, $score, PDO::PARAM_INT);
	    	$sth4->bindParam(2, $avid, PDO::PARAM_INT);
			$sth4->execute();
			return "success";
		}
		else{
			$sth4= $this->dbh->prepare("UPDATE av_information SET scoreavg=? where av_id=?");
			$sth4->bindParam(1, $score, PDO::PARAM_INT);
	    	$sth4->bindParam(2, $avid, PDO::PARAM_INT);
			$sth4->execute();
			return "success";
		}
	}
	
	function addMine($uid,$avid){
		$sth = $this->dbh->prepare("SELECT count(mine) as count from review where u_id=? and av_id=?");
		$sth->execute(array($uid,$avid));
		$res = $sth->fetch();
		if ($res['count']<=0 ) //未評過雷
		{
			$this->UserDAO->addScore($uid,2);
			$sth2= $this->dbh->prepare("INSERT INTO review (u_id,av_id,mine) VALUES (?,?,1)");
			$sth2->execute(array($uid,$avid));
		}
		else{
			$sth3 = $this->dbh->prepare("UPDATE review SET mine=1 where u_id=? and av_id=?");
			$sth3->execute(array($uid,$avid));
		}
		$sth4= $this->dbh->prepare("UPDATE av_information SET minetotal = minetotal+1 where av_id=?");
		$sth4->execute(array($avid));
		return "success";
	}
	
	function deleteMine($uid,$avid){
		$sth = $this->dbh->prepare("UPDATE review SET mine=0 where u_id=? and av_id=?");
		$sth->execute(array($uid,$avid));
		$sth2 = $this->dbh->prepare("UPDATE av_information SET minetotal = minetotal-1 where av_id=?");
		$sth2->execute(array($avid));
		return "success";
	}
	function getAVInfoByID($id){
		$sth = $this->dbh->prepare("SELECT * FROM av_fileinfo file LEFT join av_information info  on file.av_fileid = info.av_id WHERE file.av_fileid = ? ");
		$sth->execute(array($id)); 
		$res = $sth->fetch();
		return $res;		
	}
	
	function updateName($id,$name){
		$sth = $this->dbh->prepare("SELECT av_id FROM av_information where av_id=$id");
		$sth->execute(); 
		$res = $sth->fetchAll();
		if(sizeof($res) !=0){
			$this->UserDAO->addScore($_SESSION['uid'],3);
			$sth = $this->dbh->prepare("UPDATE av_information SET name = ? where av_id=?");
			$sth->execute(array($name,$id));
			return "success";
		}
		else{
			$this->UserDAO->addScore($_SESSION['uid'],3);
			$sth = $this->dbh->prepare("INSERT INTO av_information (av_id, name, scoreavg) VALUES (?, ?, '0')");
			$sth->execute(array($id,$name));
			return "success";
		}
	}
}
?>
