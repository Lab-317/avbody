<?php

require_once("config.php");

$dao = new CommonDAO();
$smarty = new Smarty();
$smarty->template_dir = '/tpl';
$action=$_GET['action'];
switch($action){
	case"addPage":
		$smarty->assign("avid",$_GET['avid']);
		$smarty->assign("name",$_GET['name']);
		$smarty->display('updateName.tpl');
	break;
	case"updateName":
		$avid = $_POST['avid'];
		$name = $_POST['av_name'];
		$detail = $dao->updateName($avid,$name);
		$info = $dao->getAVList();
		$smarty->assign("info",$info);
		$smarty->display('view.tpl');
	break;
	default:
		$info = $dao->getAVList();
		$smarty->assign("info",$info);
		$smarty->display('index.tpl');
		break;
}

?>
