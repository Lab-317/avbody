<?
require_once("config.php");

$dao = new CommonDAO();
$smarty = new Smarty();
$smarty->template_dir = '/tpl';

$serailArr = $dao->getAllSerial();


$info = $dao->getBasicInfo();

$smarty->assign("info",$info);

$smarty->display('basic.tpl');

?>
