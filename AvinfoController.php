<?
require_once("config.php");

$userDAO = new UserDAO();
$commonDAO = new CommonDAO();
$avinfoDAO = new AvinfoDAO();
$smarty = new Smarty();
$smarty->template_dir = '/tpl';

session_start();

if(!isset($_SESSION['uid'])){
        $smarty->display('index.tpl');
	exit;
}

$action=$_GET['action'];
switch($action){
		case"uploadImg":
			$imgPath = $_POST['path'];
			if(@copy($_FILES['av_img']['tmp_name'], "G://miroko//".$imgPath.$_FILES['av_img']['name'])){
				//echo "<b>File successfully upload</b>";
				echo $_POST['path'];
			}else{
				echo "<b>Error: failed to upload file</b>";
			}
		break;
		case"setImgpath":
			$avid = $_POST['avid'];
			$imgPath = $_POST['imgPath'];
			$avinfoDAO->addImgpath($imgPath,$avid);
			echo "success";
		break;
		case"getInfo":
			$id = $_GET['id'];
			$uid = $_SESSION['uid'];
			$avinfo = $commonDAO->getAVInfoByID($id);
			$scoredPeopleNum=$avinfoDAO->getScoredPeopleNum($id);
			$userReview=$avinfoDAO->getUserReview($uid,$id);
			$avTag = $avinfoDAO->getAVTag($id);
			$comment = $avinfoDAO->getComment($id);
			$smarty->assign("scoredPeopleNum",$scoredPeopleNum);
			$smarty->assign("userReview",$userReview);
			$smarty->assign("av_info",$avinfo);
			$smarty->assign("avTag",$avTag);
			$smarty->assign("comment",$comment);
			$smarty->display('avinfo.tpl');
		break;
		case "setTag":
			$avid = $_POST['avid'];
			$tname = $_POST['tname'];
			foreach($tname as $value){
				$avinfoDAO->addTag($avid,$value);
			}
//			$avinfoDAO->addTag($avid,$tname);
			$_SESSION['score'] = $_SESSION['score'] + 3;
			echo "success";
		break;
		case "cancelTag";
			$avid = $_POST['avid'];
			$tid = $_POST['tid'];
			$avinfoDAO->deleteTag($avid,$tid);
			echo "success";
		break;
		case"setMine":
			$uid = $_SESSION['uid'];
			$avid = $_POST['avid'];
			$avinfoDAO->addMine($uid,$avid);
			$_SESSION['score'] = $_SESSION['score'] + 2;
			echo "success";
		break;
		case "removeMine":
			$uid = $_SESSION['uid'];
			$avid = $_POST['avid'];
			$avinfoDAO->deleteMine($uid,$avid);
			echo "sucess";
		break;
		case"downloadlog":
			$uid = $_SESSION['uid'];
			$avid= $_POST['avid'];
			$userDAO->addDownload($uid,$avid);
			$_SESSION['score'] = $_SESSION['score'] - 1;
			echo $uid;
		break;
		case "checkDownloaded":
			$uid = $_SESSION['uid'];
			$avid = $_POST['avid'];
			$checkDL = $avinfoDAO->checkDownloaded($uid,$avid);
			if($checkDL){
				echo 1;
			}
			else{
				echo 0;
			}
		break;
		case "starRating":
			$uid = $_SESSION['uid'];
			$avid = $_POST['avid'];
			$score = $_POST['score'];
			$_SESSION['score'] = $_SESSION['score'] + 2;
			$avinfoDAO->addStarRating($uid,$avid,$score);
		break;
		case "getAVByTag"://
			$tagid = $_GET['tagid'];
			$info = $avinfoDAO->getAVByTagid($tagid);
			$smarty->assign("info",$info);
			$smarty->display('list.tpl');
			break;
		case "updateName":
			$avid = $_POST['avid'];
			$name = $_POST['av_name'];
			$detail = $avinfoDAO->updateName($avid,$name);
			$_SESSION['score'] = $_SESSION['score'] + 3;
			break;
		case "addComment":
			$uid = $_SESSION['uid'];
			$avid = $_POST['avid'];
			$content = $_POST['content'];
			$setComment = $avinfoDAO->setComment($avid,$uid,$content);
			echo "success";
		break;
		case "showComment":
			$avid = $_POST['avid'];
			$getComment = $avinfoDAO->getComment($avid);
			$smarty->assign("comment",$getComment);
			$smarty->display('avinfo.tpl');
		break;
		case "deleteComment":
			
		break;
}
?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          