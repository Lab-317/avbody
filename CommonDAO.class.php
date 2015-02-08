<?
class CommonDAO{
    private $dbh;
    function __construct() {
          $this->dbh = new connexion();
    }
    function getMaxPage(){
         $dataPerPage = 12;
         $sth = $this->dbh->prepare("SELECT count(*)/? as num FROM av_fileinfo file ");
         $sth->bindParam(1, $dataPerPage, PDO::PARAM_INT);
         $sth->execute();
         $res = $sth->fetch();
	 return ceil($res['num']);
    }
    function getAVListByPageNum($pageNum){
	$dataPerPage = 12; 
	$sth = $this->dbh->prepare("SELECT * FROM av_fileinfo file LEFT join av_information info  on file.av_fileid = info.av_id order by file.upday DESC,file.av_fileid DESC LIMIT ?,?");
	 $start = ($pageNum-1)*$dataPerPage;
     $sth->bindParam(1, $start, PDO::PARAM_INT);
	 $sth->bindParam(2, $dataPerPage, PDO::PARAM_INT);
	 $sth->execute();
         $res = $sth->fetchAll();
         return $res;
    }	
    function getAVList(){
    	$sth = $this->dbh->prepare("SELECT * FROM av_fileinfo file LEFT join av_information info  on file.av_fileid = info.av_id order by file.upday DESC");
		$sth->execute(); 
		$res = $sth->fetchAll();
		return $res;
    }
    function getReviewByUID($uid){
	$sth = $this->dbh->prepare("SELECT COUNT( * ) as num  FROM  `review` WHERE u_id = ?  ");
        $sth->execute(array($uid));
        $res = $sth->fetch();
        return $res;
    }
    function getDownloadByUID($uid){
        $sth = $this->dbh->prepare("SELECT count(*) as download FROM `downloadlog` WHERE `uid` = ?");
        $sth->execute(array($uid));
        $res = $sth->fetch();
        return $res;
    }
    function addDownload($uid,$avid){//�O��U��
		$sth = $this->dbh->prepare("INSERT INTO downloadlog VALUES(?,?,NOW())");
		$sth->execute(array($uid,$avid));
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
			$sth = $this->dbh->prepare("UPDATE av_information SET name = ? where av_id=?");
			$sth->execute(array($name,$id));
			return "success";
		}
		else{
			$sth = $this->dbh->prepare("INSERT INTO av_information (av_id, name, scoreavg) VALUES (?, ?, '0')");
			$sth->execute(array($id,$name));
			return "success";
		}
	}
	
	function getTopDownloadList(){
		$sth = $this->dbh->prepare("SELECT av_id, name, scoreavg, minetotal, downloadtotal,photo_path
		FROM  av_fileinfo file LEFT join av_information 
		on av_fileid = av_id
		ORDER BY downloadtotal DESC 
		LIMIT 20");
		$sth->execute(); 
		$res = $sth->fetchAll();
		return $res;		
	}
	
	function getTopScoreList(){
		$sth = $this->dbh->prepare("SELECT av_id, name, scoreavg, minetotal, downloadtotal,photo_path
		FROM  av_fileinfo file LEFT join av_information
		on av_fileid = av_id  
		ORDER BY scoreavg DESC 
		LIMIT 20");
		$sth->execute(); 
		$res = $sth->fetchAll();
		return $res;		
	}
	
	function getTopMineList(){
		$sth = $this->dbh->prepare("SELECT av_id, name, scoreavg, minetotal, downloadtotal,photo_path
		FROM  av_fileinfo file LEFT join av_information 
		on av_fileid = av_id
		ORDER BY minetotal DESC 
		LIMIT 20");
		$sth->execute(); 
		$res = $sth->fetchAll();
		return $res;		
	}
	
	function getTopEnduranceList(){
		$sth = $this->dbh->prepare("SELECT name, score
		FROM  user where score >0 
		ORDER BY score DESC 
		LIMIT 20");
		$sth->execute(); 
		$res = $sth->fetchAll();
		return $res;		
	}
	
	function getDailyVideo(){
		$sth = $this->dbh->prepare("SELECT av_id as avid, name as avname, photo_path as avphoto From av_information right join av_fileinfo on av_fileid = av_id where downloadtotal < 2 and photo_path is not null Order by RAND() Limit 1");
		$sth->execute();
		$res = $sth->fetch();
		return $res;
	}
}
?>
