<?
require_once("config.php");

$userDAO = new UserDAO();
$commonDAO = new CommonDAO();
$smarty = new Smarty();
$smarty->template_dir = '/tpl';
session_start();
$action=$_GET['action'];
switch($action){
	case"login":
		$account = $_POST['account'];	
		$password = md5($_POST['password']);
		$isUser = $userDAO->checkUser($account,$password);
		if($isUser==1){
			$user = $userDAO->finduserByAccount($account);
			$_SESSION['uid'] = $user['uid'];
			$_SESSION['name'] = $user['name'];
			$_SESSION['score'] = $user['score'];
			$_SESSION['DVshowed'] = 0;
			header( 'Location: ListController.php?action=getAVList&page=1' ) ;
		}
		else{
			$smarty->display('index.tpl');
		}
	break;
	case"signup":
		$username = $_POST['account'];
		$password = md5($_POST['password']);
		$email = $_POST['email'];
		$user = $userDAO->signup($username,$password,$email);
		echo "sucess";
	break;
	case"checkemail":
	break;	
	case"downloadList":
		$uid = $_SESSION['uid'];
		$type = $_GET['type'];
		if($type == 1){
			$list = $userDAO->getUserDownloadRanked($uid);
		}else if($type == 2){
			$list = $userDAO->getUserDownloadUnRank($uid);
		}else{
			$list = $userDAO->getUserDownloadList($uid);
		}
		$smarty->assign("info",$list);
		$smarty->display('view.tpl');
		break;
	case"logout":
		session_unset();
		
		$smarty->display('index.tpl'); 
	break;
	default:
		if(!isset($_SESSION['uid']))
		{
			$smarty->display('index.tpl');
		}
		break;
}

?>
                                               