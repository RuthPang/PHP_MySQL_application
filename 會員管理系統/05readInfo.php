<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>會員帳號管理</title>
		<link href="style-4.css" rel="stylesheet" type="text/css"/>
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
				include "08connMysql.php";
				session_start();
				$msg="";
				if(isset($_SESSION['id']))
					$id=$_SESSION['id'];
				if($_SESSION['action'] == "read"){
					$stmt=mysqli_prepare($db_link, "SELECT * FROM `member` WHERE `ID`=?");
					mysqli_stmt_bind_param($stmt, 'i', $id); 
					mysqli_stmt_execute($stmt);
					$result=mysqli_stmt_get_result($stmt);
					$row=mysqli_fetch_assoc($result);

					$msg="<h2>會員資料</h2>
						<table cellpadding=\"5\">
							<tr><td>帳號: </td><td>{$row['Username']}</td></tr>
							<tr><td>密碼: </td><td>●●●●●●●●</td></tr>
							<tr><td>性別: </td><td>{$row['Sex']}</td></tr>
							<tr><td>出生日期(西元): </td><td>{$row['Birthday']}</td></tr>
							<tr><td>郵件: </td><td>{$row['Mail']}</td></tr>
							<tr><td>手機: </td><td>{$row['Phone']}</td></tr>
							<tr><td>繪畫偏好: </td><td>{$row['Interest']}</td></tr>
							<tr><td>希望課程類型: </td><td>{$row['CourseType']}</td></tr>
						</table>
						</br><input id=\"btn\" type=\"button\" value=\"登出\">  
						<a href=\"06writeInfo.php\">更改會員資料</a>"; 
														
					$_SESSION['action']="write"; //可進入改寫動作
					$_SESSION['id']=$row['ID'];
					mysqli_stmt_close($stmt);
					mysqli_close($db_link);	
				}
		
				echo $msg;											
			?> 
		</div>
	</body>
</html>