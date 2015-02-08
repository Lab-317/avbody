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


		case"getInfo":
			$id = $_GET['id'];
			$uid = $_SESSION['uid'];
			$avinfo = $commonDAO->getAVInfoByID($id);
			$scoredPeopleNum=$avinfoDAO->getScoredPeopleNum($id);
			$userReview=$avinfoDAO->getUserReview($uid,$id);
			$avTag = $avinfoDAO->getAVTag($id);
			$smarty->assign("scoredPeopleNum",$scoredPeopleNum);
			$smarty->assign("userReview",$userReview);
			$smarty->assign("av_info",$avinfo);
			$smarty->assign("avTag",$avTag);
			$smarty->display('avinfo.tpl');
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
		case "getAVList":
			$page = $_GET['page'];
			if(!isset($_GET['page'])){
				$page = 1;
			}
            $info = $commonDAO->getAVListByPageNum($page);
            $maxPage = $commonDAO->getMaxPage();
			$review =$commonDAO->getReviewByUID($_SESSION['uid']);
			$download =$commonDAO->getDownloadByUID($_SESSION['uid']);
			$smarty->assign("reviewNum",$review['num']);
			$smarty->assign("downloadNum",$download['download']);
            $smarty->assign("maxPage",$maxPage);
            $smarty->assign("info",$info);
			$smarty->display('list.tpl');
		break;
		case "getAllAVTag":
			$allTag = $avinfoDAO->getAllAVTag();
			//print_r(sizeof($allTag));
			$sum = 0;
			for($i = 0 ; $i<sizeof($allTag);$i++){
				$sum +=$allTag[$i][count];
			}
			$avg = $sum/sizeof($allTag);
			$total = 0;
	                for($i = 0 ; $i<sizeof($allTag);$i++){
				$total += pow(($allTag[$i][count]-$mean),2); 	
                        }
			$var = sqrt($total/(sizeof($allTag)-1));
			$smarty->assign("Tagvar",$var);
			$smarty->assign("Tagavg",$avg);
			$smarty->assign("AllTag",$allTag);
			$smarty->display('tag.tpl');
		break;
		case "getAVByTag"://
			$tagid = $_GET['tagid'];
			$info = $avinfoDAO->getAVByTagid($tagid);
			$smarty->assign("info",$info);
			$smarty->display('list.tpl');
		break;
		case "getTopDownloadList"://取得top download 20名單
            $info = $commonDAO->getTopDownloadList();  
            $smarty->assign("info",$info);
			$smarty->display('topList.tpl');
		break;
		case "getTopScoreList"://取得top Score 20名單
            $info = $commonDAO->getTopScoreList();  
            $smarty->assign("info",$info);
			$smarty->display('topList.tpl');
		break;
		case "getTopMineList"://取得top Score 20名單
            $info = $commonDAO->getTopMineList();  
            $smarty->assign("info",$info);
			$smarty->display('topList.tpl');
		break;
		case "getTopEnduranceList"://取得top endurance 20名單
            $user = $commonDAO->getTopEnduranceList();  
            $smarty->assign("user",$user);
			$smarty->display('topUser.tpl');
		break;
		case "getTopAVDB":
			$smarty->display('topAVDB.tpl');
		break;
		case "getDailyVideo":
			$AV = $commonDAO->getDailyVideo();
			$_SESSION['DVshowed'] = 1;
			$dailyVideo = array(
				array(
					'avid'=>$AV['avid'],
					'avname'=>$AV['avname'],
					'avphotopath'=>$AV['avphoto']
				)
			);
			echo json_encode($dailyVideo);
		break;
}
?>
