<?
require_once("config.php");

$dao = new CommonDAO();
$smarty = new Smarty();
$smarty->template_dir = '/tpl';

		$info = $dao->getAVList();
		$smarty->assign("info",$info);
		$smarty->display('list.tpl');
?>
