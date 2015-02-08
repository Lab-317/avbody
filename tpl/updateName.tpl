<html meta http-equiv="Content-Type" content="text/html"; charset=utf-8">
<head></head>
<body>
<form action="index.php?action=updateName" method="POST" id="photoupload" enctype="multipart/form-data">
	原始片名:{$name}
	<br>
	片名<input type="text" name="av_name">
	<br>
	<input type="hidden" name="avid" value={$avid}>
	<input type="submit" value="送出">
</body>
</html>
