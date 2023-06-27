<?php
	include "08connMysql.php";
	session_start();
	session_unset(); //清空session變數

	if(isset($_POST['uid']) && isset($_POST['pwd'])){
		$uid=$_POST['uid'];
		$pwd=$_POST['pwd'];

		$stmt=mysqli_prepare($db_link, "SELECT * FROM `member` WHERE `Username`=?");
		mysqli_stmt_bind_param($stmt, 's', $uid); 
		mysqli_stmt_execute($stmt);
		$result=mysqli_stmt_get_result($stmt);
		$row=mysqli_fetch_assoc($result);
		if($row){
			$msg="帳號已存在!請重新註冊";
		}
		else{ 
			$pwdh=password_hash($pwd,  PASSWORD_DEFAULT);
			$sqlCmd = "INSERT INTO `member` (`Username`, `Password`) VALUES ('$uid', '$pwdh')";
			$result2 = mysqli_query($db_link,$sqlCmd);
			if (!$result2) 
				die("Query Fail!".mysqli_error($db_link));
			else{
				$stmt=mysqli_prepare($db_link, "SELECT * FROM `member` WHERE `Username`=?");
				mysqli_stmt_bind_param($stmt, 's', $uid); 
				mysqli_stmt_execute($stmt);
				$result=mysqli_stmt_get_result($stmt);
				$row=mysqli_fetch_assoc($result);
				$msg="帳號建立完成";
				$_SESSION['action']="write";
				$_SESSION['id']=$row['ID'];
			} 
				
		}
		mysqli_stmt_close($stmt);
		mysqli_close($db_link);
	}

	

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>會員帳號註冊</title>
		<link href="style-3.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<div id="cont">
			<?php 
				if(isset($msg)){
				 	if($msg == "帳號已存在!請重新註冊"){
						$msg.="</br><a href=\"03register.html\">重新註冊</a>";
					}
					else if($msg == "帳號建立完成"){
						$msg.="</br><a href=\"06writeInfo.php\">點我繼續註冊</a>";
					}
					echo $msg;
				}	
			?>
		</div>
	</body>
</html>

