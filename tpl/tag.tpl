<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
{literal}
<style>
.tag_1{
	font-size:10px;
}
.tag_2{
	font-size:12px;
}
.tag_3{
	font-size:14px;
}
.tag_4{
	font-size:16px;
}
.tag_5{
	font-size:18px;
}
.tag_6{
	font-size:30px;
}
.tag_7{
	font-size:32px;
	color:red;
}
.tag_8{
	font-size:34px;
}
.tag_9{
	font-size:36px;
}
.tag_10{
	font-size:38px;
	
}
</style>
{/literal}
</head>
<body>
<h1 align="center">Tag Cloud</h1>
<div align="center" width="400">
{foreach from=$AllTag item=tag}
	<a class="tag_{math equation="round((((x - y)/z)+3.5)*1.4)" x=$tag.count y=$Tagavg z=$Tagvar}" href="AvinfoController.php?action=getAVByTag&tagid={$tag.t_id}">{$tag.t_name}</a>
{/foreach}
</div>
</body>
</html>
