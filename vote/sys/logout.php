<?php
		session_start();
		header ('Content-Type: text/html; charset=big5');
		echo "你已經登出";
		if (@$_SESSION["isLogin_Admin"]=="yes") {
			session_destroy();
			echo "<meta http-equiv=Refresh content=1;url=../index.php>";
			//include("index_admin.php");
		} else if (@$_SESSION["isLogin_User"]=="yes") {
			session_destroy();
			//include("index.php");
			echo "<meta http-equiv=Refresh content=1;url=../index.php>";
		}


		//echo "<p><p><big><b><div align=center><font color=#990000><font color=#990000>尚未登入</font></div></b></p></p>";
		//echo "<meta http-equiv=Refresh content=2;url=../zzzzz/index_admin.php>";
?>

<html>
		<head>
				<meta charset="utf-8"/>
				<title>Log out</title>
		</head>
</html>
