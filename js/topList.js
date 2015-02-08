$(function() {
	
	var scWidth=screen.availWidth*0.3;
	var scHeight=screen.availHeight*0.2;
//	var imageWidth=screen.availWidth*0.7
//	var imageHeight=screen.availHeight*0.7
	var i=1;
	
	$('#imageDialog').dialog({
		autoOpen: false,
		width:scWidth,
		height:scHeight,
	}),
	$('#name').mouseout(function(e){
		hiddenImage();
	})
});
function showImage(path){
	$('#imageDialog').html("<img src='" + path + "'></img>");
	$('#imageDialog').dialog({position:[path.pageX,path.pageY]});
	$('#imageDialog').dialog('open');
	return false;
}

function hiddenImage(){
	$('#imageDialog').dialog('close');
	return false;
}