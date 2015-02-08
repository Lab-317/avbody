/**
 * @author DinoLai
 */
	//score function related starRating.js
	$(document).ready(function() {  
		var avid = $("para1").attr("value");
		var scoreavg = $("para2").attr("value");
		var userScore = $("para3").attr("value");
			
		
		$("#self"+userScore).attr("checked", "checked");
		if(scoreavg>=5)
			scoreavg=5;
		scoreavg=parseInt(scoreavg);
		$("#"+scoreavg).attr("checked", "checked");
	    applingStar(avid,scoreavg);
		$('.star2').rating();
		$('.star2').rating('disable');
		
		$(".tagDelBtn").css('visibility','hidden');
		$(".tagDelBtn").mouseout(function(){
			hiddenDelBtnn();
		}),
		$(".tagDelBtn").mouseover(function(e){
			clearTimeout(timeoutHDB);
			showDelBtn(e);
		}),
		$(".tagDelBtn").click(function(e){
			clearTimeout(timeoutHDB);
			showDelBtn(e);
		}),
		$(".tagName").mouseover(function(e){
			showDelBtn(e);
		}),
		$(".tagName").mouseout(function(){
			timeoutHDB = setTimeout("hiddenDelBtnn()",1000);	
		})
	}); 
	//End score function
	
	//imageDialog's global var
	var dl_Path=null;
	var av_name=null;
	//changeName's global var
	var orName = null;
	var chObj = null;
	var chField = null;
	var mineTotal = 0;
	
	//showBackground function
	function showBackground(avid){
		document.getElementById("name"+avid).style.background = "yellow";
	}
	
	//hiddenBackground function
	function hiddenBackground(avid){
		document.getElementById("name"+avid).style.background = "";
	}
	
	// changeName's functions
	function setDivId(avid){
		orName = "name"+avid;
		chObj = "changeObj"+avid;
		chField = "changeField"+avid;
	}
	
    function showChageField(){
		document.getElementById(chObj).style.display = "block";
		document.getElementById(chField).value = document.getElementById(orName).innerHTML;
//		document.listForm.changeName.text = ortext.innerHTML;
		document.getElementById(orName).style.display = "none";
    }
	
	function hiddenChangeField(){
		document.getElementById(chObj).style.display = "none";
		document.getElementById(orName).style.display = "block";
	}
	
	function updateName(avid){
		var loadingImg = "loading"+avid;
		document.getElementById(loadingImg).style.visibility = "visible";
		document.getElementById(loadingImg).innerHTML="<img src = css/images/mozilla_blu.gif></img>";
		var av_name = document.getElementById(chField).value;
		$.ajax({
			type: "POST",
			url: "AvinfoController.php?action=updateName",
			data: 	"avid=" + avid + 
					"&av_name=" + av_name,
			success: function(){
				document.getElementById(orName).innerHTML = av_name;
				document.getElementById(chField).value = "";
				document.getElementById(loadingImg).style.visibility = "hidden";
				hiddenChangeField(avid);
			}
		});
	}
	//End changeName
	
	//imageDialog's functions
	$(function() {
		
		var scWidth=screen.availWidth*0.8;
		var scHeight=screen.availHeight*0.7;
//		var imageWidth=screen.availWidth*0.7
//		var imageHeight=screen.availHeight*0.7
		var i=1;
		
		$('#imageDialog').dialog({
			autoOpen: false,
			width:scWidth,
			height:scHeight,
			modal:true,
			closeOnEscape: false,
			buttons:{
				Download:function(){
					window.location = getPath();
				}
			}
		});
	
//		$('#opener').mouseout(function() {
//			$('#dialog').dialog('close');
//			return false;
//		});
	});
	
	function showImage(path){
//		$('#imageDialog').html("<img src='" + path + "'></img>");
		$('#imageDialog').dialog('open');
//		$('#imageDialog').dialog({title:getName()});
		return false;
	}
	
	function getText(){
		var text=document.getElementById('changeName').val();
		alert(text);
	}
	
	function setPath(path){
		dl_Path=path;
	}
	
	function getPath(){
		return dl_Path;
	}
	
	function setName(name){
		av_name=name;
	}
	
	function getName(){
		return av_name;
	}
	//End imageDialog

	//mine function
	function decideMineFunc(avid){
	var mineVal = $("#paraMine").val();
		if(mineVal==1){
			subtractMine(avid);
		}else{
			plusMine(avid);
		}
	}
	
	function setMinetotal(minetotal){
		mineTotal = parseInt($("#paraMineTotal").val());
	}
	function plusMine(avid){
		$.ajax({
			type: "POST",
			url: "AvinfoController.php?action=setMine",
			data: ({avid:avid}),
			success: function(msg){
				$('#mineFont').html("收回雷");
				mineTotal=mineTotal+1;
				$('#mine').html(mineTotal);
				$("#paraMineTotal").val(mineTotal);
				$("#paraMine").val(1);
		    }
		});
	}
	
	function subtractMine(avid){
		$.ajax({
			type: "POST",
			url: "AvinfoController.php?action=removeMine",
			data: ({avid:avid}),
			success: function(msg){
				$('#mineFont').html("評為雷");
				mineTotal=mineTotal-1;
				$('#mine').html(mineTotal);
				$("#paraMineTotal").val(mineTotal);
				$("#paraMine").val(0);
		    }
		});
	}
	
	//End mine function
	
	//download function
	function recordDownload(avid){
		$.ajax({
			type:"POST",
			url: "AvinfoController.php?action=downloadlog",
			data:({avid:avid}),
			success: function(msg){
				return msg;
			}
		});
	}
	
	//tag function
	var tagArray=[];
	
	function showAddtagtext(){
		$('#showAddtabtn').css('visibility','hidden');
		$('#newtagrow').css('display','block');
	}
	
	function hiddenAddtagtext(){
		$('#newtagrow').css('display','none');
		$('#showAddtabtn').css('visibility','visible');
	}
	
	function hiddenDelBtnn(){
		$('.tagDelBtn').css("visibility","hidden");
	}
	
	function showDelBtn(e) {
		$(e.target).parent().children('.tagDelBtn').css('visibility','visible');
		e.preventDefault();
		return false;
	}
	
	function hiddenDelBtn(e) {
		$(e.target).parent().children('.tagDelBtn').removeClass('show');
		$(e.target).parent().children('.tagDelBtn').addClass('hidden');
		return false;
	}
	
	function addTag(tagArray){
		var lastText = null;
		var newText = null;
		for(var i=0;i<tagArray.length;i++){
			$('#tag').append(
				"<span class=\"tagElement\">"+
				"<a href=\"#\" class=\"tagName\">"+tagArray[i]+"</a>"+
				"<a href=\"#\" class=\"tagDelBtn\">X</a>"+
				"</span>"+
				" "
			);
//			lastText = document.getElementById('tag').innerHTML;
//			newText = "<span class=\"tagElement\"><a href="#" class=\"tagName\">"+tagArray[i]+"</a><a href="#" class=\"tagDelBtn\">X</a></span>";
//			document.getElementById('tag').innerHTML = lastText + newText;
		}
		
		$(".tagDelBtn").mouseout(function(){
			hiddenDelBtnn();
		}),
		$(".tagDelBtn").mouseover(function(e){
			clearTimeout(timeoutHDB);
			showDelBtn(e);
		}),
		$(".tagName").mouseover(function(e){
			showDelBtn(e);
		}),
		$(".tagName").mouseout(function(){
			timeoutHDB = setTimeout("hiddenDelBtnn()",1000);	
		})
	}
	
	function removeTag(tid,avid){
		$.ajax({
			type: "POST",
			url: "AvinfoController.php?action=cancelTag",
			data: ({tid:tid,avid:avid}),
			success: function(msg){
				$("#"+tid).css('display','none');
		    }
		});
	}
	
	function splitTag(){
		var tag=document.getElementById('newtag').value;
		tagArray = tag.split(',');
		return tagArray;
	}
	
	function saveNewtag(avid){
		splitTag();
		$.ajax({
			type: "POST",
			url: "AvinfoController.php?action=setTag",
			data: ({tname:tagArray,avid:avid}),
			success: function(msg){
				addTag(tagArray);
				hiddenAddtagtext();
		    }
		});
	}
	//End tag function
	
	//Comment function
	
	function saveComment(avid){
		var content = document.getElementById('content').value;
		$.ajax({
			type: "POST",
			url: "AvinfoController.php?action=addComment",
			data: ({avid:avid,content:content}),
			success: function(msg){
				document.getElementById('content').value = "";
				location.reload(true);
		    }
		});
	}
	
	function addComment(){
		
	}
	///End comment function
	
	//upload image function
	function uploadImg(path){
		path = path.substr(0,path.lastIndexOf('/'))+'/';
        $.ajaxFileUpload({
            url:'AvinfoController.php?action=uploadImg',
			data:({path:path}),
            secureuri:false,
            fileElementId:'av_img',
            dataType: 'json',
            success: function (data, status){
                if(typeof(data.error) != 'undefined'){
                    if(data.error != ''){
                        //alert(data.error);
						alert(data);
                    }else{
                        alert(data.msg);
                    	//addImgpath(path+document.getElementById('av_img').value);
                    }
                }
            },
            error: function (data, status, e){
                alert(e);
            }
        });
	}
	
	function addImgpath(imgpath){
		$.ajax({
			type: "POST",
			url: "AvinfoController.php?action=setImgpath",
			data: ({imgpath:imgpath,avid:avid}),
			success: function(msg){
				location.reload();
		    }
		});
	}
