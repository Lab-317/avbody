
//score待做

function submitStarRating(avid,score){
	//alert(score);
	var result;
	$.post("AvinfoController.php?action=starRating", { avid: avid, score: score },
			function(data){
				var scoredPeopleNum = $("para4").attr("value");
				//alert('scoredPeopleNum:'+scoredPeopleNum);
				var scoreOri = $("#test").html();
				//alert(scoreOri);
				var tmp=parseInt(scoreOri)*parseInt(scoredPeopleNum)+score;
				if(scoredPeopleNum>1)
					result=Math.round(parseInt(tmp)/parseInt(scoredPeopleNum+1));
				else
					result=score;
				//alert('test:'+result);
				$("#test").html(result);
				$('.star2').rating('enable');
				$('.star2').rating('select',result-1);
				$('.star2').rating('disable');
			
	  });
	//
	//	$.ajax({
	//		type: "POST",
	//		url: "AvinfoController.php?action=starRating",
	//		data: ({avid:avid,score:score}),
	//		success: function(msg){
	//	    }
	//	});
}
function applingStar(avid,scoveravg)
{
	
	$('.submit-star').rating( {
		
	callback : function(value, link) {		
		//var avid=document.getElementById('star').name;
		//alert(avid);
		var score;
		switch (value) {
		case '極差':
			score = 1;
			break;
		case '差':
			score = 2;
			break;
		case '普通':
			score = 3;
			break;
		case '佳':
			score = 4;
			break;
		case '極佳':
			score = 5;
			break;
		default:
			score=0;
			break;
		}
		
		$.post("AvinfoController.php?action=checkDownloaded", { avid: avid},function(data){
			//alert(data);
			if(data==0){
				alert("未載先評，偷吃步");
				$('.submit-star').removeClass('star-rating-hover');
				$('.submit-star').removeClass('star-rating-on');
			}
			else{
				var answer = confirm("確認將此片評為"+score+"顆星?");
				if(answer)
				submitStarRating(avid,score);
			}
		});
	}});
	//alert("applyStar:"+scoveravg);
	
}