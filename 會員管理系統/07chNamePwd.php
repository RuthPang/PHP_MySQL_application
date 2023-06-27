<?php
	include "08connMysql.php"; 
	session_start();
	$msg="";

	if(isset($_SESSION['id'])){
		$id=$_SESSION['id'];
		$stmt=mysqli_prepare($db_link, "SELECT * FROM `member` WHERE `ID`=?");
		mysqli_stmt_bind_param($stmt, 'i', $id); 
		mysqli_stmt_execute($stmt);
		$result=mysqli_stmt_get_result($stmt);
		$row=mysqli_fetch_assoc($result);
		if(!$row){
			mysqli_stmt_close($stmt);
			mysqli_close($db_link);	
			header("login.html");
		}
	}

	if(isset($_SESSION['action'])){
		if($_SESSION['action']=="change" && isset($_GET['pid'])) 
		//action=change, pid=1, pid=0 為 改密碼、改帳號名稱
			$pid=$_GET['pid'];
		else if($_SESSION['action']=="check1" && isset($_POST['pwdOld']) //修改密碼
			&& isset($_POST['pwdNew1']) && isset($_POST['pwdNew2'])){
			$pwdOld=$_POST['pwdOld'];
			$pwdNew1=$_POST['pwdNew1'];
			$pwdNew2=$_POST['pwdNew2'];
		}
		else if($_SESSION['action']=="check2" && isset($_POST['uidNew'])){ //修改帳號名稱
			$uidNew=$_POST['uidNew'];
		}
		else{ //其餘情況導向登入畫面
			mysqli_stmt_close($stmt);
			mysqli_close($db_link);	
			header("login.html");
		}
	}
	else{ //其餘情況導向登入畫面
		mysqli_stmt_close($stmt);
		mysqli_close($db_link);	
		header("login.html");
	}


//變更密碼
	if(isset($pwdOld) && isset($pwdNew1) && isset($pwdNew2)){ 
		if(password_verify($pwdOld, $row['Password'])){
			if($pwdNew1 == $pwdNew2){
				$pwdNew=password_hash($pwdNew1, PASSWORD_DEFAULT);
				$sql_query="UPDATE `member` SET";
				$sql_query.="`Password`='".$pwdNew."'";
				$sql_query .= "WHERE `ID`=".$id;	
				mysqli_query($db_link, $sql_query);
				$msg="密碼變更完成";
				$_SESSION['action']="read"; //改密碼成功，可進入瀏覽畫面
				// $_SESSION['id']=$id;
				mysqli_stmt_close($stmt);
				mysqli_close($db_link);	
				header("Location:05readInfo.php");
			}
			else{
				$_SESSION['action']="change"; //其餘錯誤情況報錯
				$msg="兩次密碼不一致</br><a href=\"07chNamePwd.php?pid=1\">點我重新設置</a>";
			}
		}
		else{
			$_SESSION['action']="change";
			$msg="密碼錯誤!</br><a href=\"07chNamePwd.php?pid=1\">點我重新設置</a>";
		}
	}

//變更名稱
	if(isset($uidNew)){
		$stmt2=mysqli_prepare($db_link, "SELECT * FROM `member` WHERE `Username`=?");
		mysqli_stmt_bind_param($stmt2, 's', $uidNew); 
		mysqli_stmt_execute($stmt2);
		$result2=mysqli_stmt_get_result($stmt2);
		$row2=mysqli_fetch_assoc($result2);
		if($row2){
			$_SESSION['action']="change";
			$msg="帳號名稱已存在!請重新設置</br><a href=\"07chNamePwd.php?pid=0\">點我重新設置</a>";
		}
		else{
			$sql_query="UPDATE `member` SET";
			$sql_query.="`Username`='".$uidNew."'";
			$sql_query .= "WHERE `ID`=".$id;	
			mysqli_query($db_link, $sql_query);
			$msg="名稱變更完成";
			$_SESSION['action']="read";
			// $_SESSION['id']=$id;
			mysqli_stmt_close($stmt);
			mysqli_close($db_link);	
			header("Location:05readInfo.php");
		}
	}
	
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>變更帳號名稱、密碼</title>
		<link href="style.css" rel="stylesheet" type="text/css"/>	
	</head>
	<body>
		<div id="cont">
			<h2>變更帳號名稱、密碼</h2>	
			<?php 
				if(isset($pid)){
					if($pid){ //提供改密碼表單
						$msg="<form id=\"f1\" action=\"07chNamePwd.php\" method=\"post\">
						<table cellpadding=\"5\">
							<tr><td>舊密碼: </td><td><input type=\"password\" name=\"pwdOld\" required></td></tr>
							<tr><td>新密碼: </td><td><input type=\"password\" name=\"pwdNew1\" required></td></tr>
							<tr><td>新密碼確認: </td><td><input type=\"password\" name=\"pwdNew2\" required></td></tr>
						<table>
						</br><input class=\"btn\" type=\"submit\" value=\"確認\">";
						$_SESSION['action']="check1";
					}
					else{ //提供改帳號名稱表單
						$msg="<form id=\"f1\" action=\"07chNamePwd.php\" method=\"post\">
						<table cellpadding=\"5\">
							<tr><td>舊帳號名稱: </td><td>{$row['Username']}</td></tr>
							<tr><td>新帳號名稱: </td><td><input type=\"text\" name=\"uidNew\" required></td></tr>
						<table>
						</br><input class=\"btn\" type=\"submit\" value=\"確認\">";
						$_SESSION['action']="check2";
					}
				
				}					
				
				echo $msg;
				mysqli_stmt_close($stmt);
				mysqli_close($db_link);
				
			?>
		</div>
	</body>
</html>