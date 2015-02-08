<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="css/index.css">
<link type="text/css" href="development-bundle/themes/base/jquery.ui.all.css" rel="stylesheet" />
<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="js/jquery-ui-1.8.custom.min.js" type="text/javascript"></script>
<title>AVBODY</title>
</head>
<form name="index" action="UserController.php?action=login" method="POST" enctype="multipart/form-data">
{literal}
<script type="text/javascript">
$(function() {
	var account = $('#account');
	var password = $('#password');
	var email = $('#email');
	
	function register(){
		$.ajax({
			type: "POST",
			url: "UserController.php?action=signup",
			data: 	"account=" + account.val() + 
					"&password=" + password.val()+
					"&email=" + email.val(),
			success: function(msg){
				alert(msg);
				$('#rgstrDialog').dialog('close');
			}
		});
	}
	
	$('#rgstrDialog').dialog({
		autoOpen: false,
		modal:true,
		resizable:false,
		
		buttons:{
			submit:function(){
				register();
			}
		},
		close: function() {
			account.val('').removeClass('ui-state-error');
			password.val('').removeClass('ui-state-error');
		}
	});
});
	function showRgstrDialog(){
		$('#rgstrDialog').dialog('open');
	}	
</script>
{/literal}
<body>
	<table>
	<tr>
		<td>帳號<input type="text" name="account"></td>
	</tr>
	<tr>
		<td>密碼<input type="password" name="password"></td>
	</tr>
	<tr>
		<td>
			<input type="submit" name="submit" value="確認">
			<input type="button" name="register" value="註冊" onclick="showRgstrDialog();">
		</td>
	</tr>
	<tr>
		<td>
			<p class="warning">無法登入者請mail至avbodycloud@gmail.com，請註明身份及推薦人(帳號)。<br>
			密碼皆經過md5加密處理，管理者無法得知，請放心使用。<br>
		</td>
	</tr>
	</table>
	<div id="rgstrDialog" title="register">
	<p class="validateTips"></p>
	<form>
	<fieldset>
		<label for="account">帳號</label>
		<input type="text" name="account" id="account" class="text ui-widget-content ui-corner-all" />
		<label for="password">密碼</label>
		<input type="password" name="password" id="password" value="" class="text ui-widget-content ui-corner-all" />
		<label for="email">電子信箱</label>
		<input type="text" name="email" id="email" class="text ui-widget-content ui-corner-all" />
	</fieldset>
	</form>
</div>
</body>
</html>
