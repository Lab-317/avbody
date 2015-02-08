<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
// display file details
echo "Filename: " . $_FILES['userfile']['name'] . "<br>";
echo "Temporary Name: " . $_FILES['userfile']['tmp_name'] . "<br>";
echo "Size: ". $_FILES['userfile']['size'] . "<br>";
echo "Type: ". $_FILES['userfile']['type'] . "<br>";

// copy file here
if(@copy($_FILES['userfile']['tmp_name'], "D://AppServ//www//test//" . $_FILES['userfile']['name'])){
	echo "<b>File successfully upload</b>";
 }else{
	echo "<b>Error: failed to upload file</b>";
 }
?>
</body>
</html>
