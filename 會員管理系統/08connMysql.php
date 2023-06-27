<?php 
	//資料庫主機設定
  	$db_host = "localhost";
	$db_username = "108321015";
	$db_password = "pwd1015";
	//連線伺服器
	$db_link = mysqli_connect($db_host, $db_username, $db_password) or die("資料連結失敗！");
	//設定字元集與連線校對
	mysqli_set_charset($db_link, 'utf8mb4');
	mysqli_select_db($db_link, $db_username);//選擇連線資料庫名稱

	
?>