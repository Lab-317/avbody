<?
class UserDAO{
    private $dbh;
    function __construct() {
          $this->dbh = new connexion();
    }
    function checkUser($account,$password){
		//echo $password;
	    $sth = $this->dbh->prepare("SELECT count(*) as count FROM user where name = ? AND password = ? AND status = 1");
		$sth->execute(array($account,$password));
		$res = $sth->fetch();
		return $res['count'];
    }
	function signup($username,$password,$email){
	   	$sth = $this->dbh->prepare("INSERT INTO user(name,password,email) VALUES(?,?,?)");
		$sth->execute(array($username,$password,$email));
    }
    function addEmail($email){
    	$sth = $this->dbh->prepare("UPDATE user SET email = ? where name = ?");
    	$sth->execute(array($email,$username));
    }
	function getUserDownloadList($uid){
		$sth = $this->dbh->prepare(
		"SELECT * 
		FROM 
		downloadlog inner join av_information on downloadlog.av_fileid = av_information.av_id
		inner join av_fileinfo on downloadlog.av_fileid = av_fileinfo.av_fileid
		left join review ON review.av_id = downloadlog.av_fileid AND review.u_id = downloadlog.uid
		WHERE downloadlog.uid=? 
		ORDER BY downloadlog.downloadTime DESC");
		$sth->execute(array($uid));
		$res = $sth->fetchAll();
		return $res;
	}
	function getUserDownloadUnRank($uid){
		$sth = $this->dbh->prepare(
                "SELECT *
                FROM
                downloadlog inner join av_information on downloadlog.av_fileid = av_information.av_id
                inner join av_fileinfo on downloadlog.av_fileid = av_fileinfo.av_fileid
                left join review ON review.av_id = downloadlog.av_fileid AND review.u_id = downloadlog.uid
                WHERE downloadlog.uid=? AND review.score is null
                ORDER BY downloadlog.downloadTime DESC");
                $sth->execute(array($uid));
                $res = $sth->fetchAll();
                return $res;
	}
	function getUserDownloadRanked($uid){
                $sth = $this->dbh->prepare(
                "SELECT *
                FROM
                downloadlog inner join av_information on downloadlog.av_fileid = av_information.av_id
                inner join av_fileinfo on downloadlog.av_fileid = av_fileinfo.av_fileid
                left join review ON review.av_id = downloadlog.av_fileid AND review.u_id = downloadlog.uid
                WHERE downloadlog.uid=? AND review.score is not null
                ORDER BY downloadlog.downloadTime DESC");
                $sth->execute(array($uid));
                $res = $sth->fetchAll();
                return $res;
        }

	function finduserByAccount($account){
		$sth = $this->dbh->prepare("SELECT * FROM user where name = ?");
		$sth->execute(array($account));
		$res = $sth->fetch();
		return $res;
	}
	function addDownload($uid,$avid){//記錄下載
		$sthDTC = $this->dbh->prepare("SELECT count(uid) as count from downloadlog where uid=? and av_fileid=?");
		$sthDTC->execute(array($uid,$avid));
		$res = $sthDTC->fetch();
		if($res['count']<=0){//判斷是否下載過，無下載過紀錄並增加下載數
			$this->minusScore($uid,1);
			$sth = $this->dbh->prepare("INSERT INTO downloadlog VALUES(?,?,now())");
			$sth->execute(array($uid,$avid));
			$sth2= $this->dbh->prepare("UPDATE av_information SET downloadtotal = downloadtotal+1 where av_id=?");
			$sth2->execute(array($avid));
		}
		return "success";
	}
	function addScore($uid,$score){
		$sth = $this->dbh->prepare("UPDATE user SET score = score + ? WHERE uid = ?");
		$sth->execute(array($score,$uid));		
	}
	function minusScore($uid,$score){
		$sth = $this->dbh->prepare("UPDATE user SET score = score - ? WHERE uid = ?");
                $sth->execute(array($score,$uid));
	}
}
?>
