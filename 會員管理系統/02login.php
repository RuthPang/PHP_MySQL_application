<?php 
	include "08connMysql.php"; // $db_link
	session_start(); //啟動session
	session_unset(); //清空session變數
	$msg="";

	if(isset($_POST['uid']) && isset($_POST['pwd'])){
		$uid = $_POST['uid'];
		$pwd = $_POST['pwd'];
		$stmt=mysqli_prepare($db_link, "SELECT * FROM `member` WHERE `Username`=?");
		mysqli_stmt_bind_param($stmt, 's', $uid); 
		mysqli_stmt_execute($stmt);
		$result=mysqli_stmt_get_result($stmt);
		$row=mysqli_fetch_assoc($result);

		if ($row) { //驗證密碼
			if (password_verify($pwd, $row['Password'])){
				$msg = "親愛的 ".$row['Username']." , 歡迎回來!";
				$_SESSION['action']="read"; //可進入瀏覽動作
				$_SESSION['id']=$row['ID'];
			}
			else{ //密碼錯誤
				$msg = "帳號或密碼錯誤";
			}
		}
		else //帳號不存在
		  $msg = "帳號或密碼錯誤";
		mysqli_stmt_close($stmt);
		mysqli_close($db_link);
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>會員帳號登入</title>
		<link href="style-2.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript">
			window.onload=function(){
				document.getElementById("btn").onclick=function(){
					window.location.assign("01login.html");
				}
			}
		</script>
	</head>
	<body>
		<div id="cont">
			<?php 					
				if($msg == "帳號或密碼錯誤"){
					$msg.="</br><input id=\"btn\" type=\"button\" value=\"重新登入\">
								</br><a href=\"03register.html\">還沒有帳戶?點這裡註冊</a>";
				}
				else{
					$msg.="</br><a href=\"05readInfo.php\">瀏覽、更改會員資料</a>
								</br><input id=\"btn\" type=\"button\" value=\"登出\">";
				}
				echo $msg;
			?>
		</div>
	</body>
</html>