<?php
	include "08connMysql.php";
	session_start();
	$msg="";

	if(isset($_SESSION['id']))
		$id=$_SESSION['id'];

	if($_SESSION['action'] == "change"){ //進入改寫資料庫動作
		$stmt=mysqli_prepare($db_link, "SELECT * FROM `member` WHERE `ID`=?");
		mysqli_stmt_bind_param($stmt, 'i', $id); 
		mysqli_stmt_execute($stmt);
		$result=mysqli_stmt_get_result($stmt);
		$row=mysqli_fetch_assoc($result);
		if($row){
			$sql_query="UPDATE `member` SET";
			$sql_query.="`Sex`='".$_POST['sex']."',";
			$sql_query.="`Birthday`='".$_POST['birthday']."',";
			$sql_query.="`Mail`='".$_POST['mail']."',";
			$sql_query.="`Phone`='".$_POST['phone']."',";
			$interest=implode(",", $_POST['paints']);
			$sql_query.="`Interest`='".$interest."',";
			$sql_query.="`CourseType`='".$_POST['course']."'";
			$sql_query .= "WHERE `ID`=".$id;	
			mysqli_query($db_link, $sql_query);
			$msg="資料更改完成";
			$_SESSION['action']="read"; //可進入瀏覽動作
			$_SESSION['id']=$id;
			mysqli_stmt_close($stmt);
			mysqli_close($db_link);	
			header("Location:05readInfo.php"); //直接導向瀏覽畫面	

		}
		
	}

?>	

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>會員帳號管理</title>
		<link href="style-4.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript">
			function handleData(){ //送出表單前，確認checkbox(繪畫偏好)選擇至少一項
				console.log("enter");
				var form_data=new FormData(document.getElementById("f1"));

				if(!form_data.has("paints[]")){
					console.log("false");
					document.getElementById("chk_option_error").style.visibility="visible";
					return false;
				}
				else{
					console.log("true");
					document.getElementById("chk_option_error").style.visibility="hidden";
					return true;
				}
			}
		</script>

	</head>
	<body>
		<div id="cont">
			<?php
				if($_SESSION['action'] == "write"){ //進入表單
					$stmt=mysqli_prepare($db_link, "SELECT * FROM `member` WHERE `ID`=?");
					mysqli_stmt_bind_param($stmt, 'i', $id); 
					mysqli_stmt_execute($stmt);
					$result=mysqli_stmt_get_result($stmt);
					$row=mysqli_fetch_assoc($result);
						
					$msg="<h2>更改會員資料</h2>
	<form onsubmit=\"return handleData()\" id=\"f1\" action=\"06writeInfo.php\" method=\"post\">
		<table cellpadding=\"5\">
			<tr><td>帳號: </td><td>{$row['Username']}</td><td><a href=\"07chNamePwd.php?pid=0\">變更帳號名稱</a></td></tr>
			<tr><td>密碼: </td><td>●●●●●●●●</td><td><a href=\"07chNamePwd.php?pid=1\">變更密碼</a></td></tr>
			<tr><td>性別: </td><td>";
						//名稱、密碼、性別、郵件、繪畫偏好、上課類型欄位不可空白
					if($row['Sex']=="男"){
						$msg.="<label><input type=\"radio\" name=\"sex\" value=\"男\" checked required>男</label>
	      		<label><input type=\"radio\" name=\"sex\" value=\"女\">女</label>";
						}else{
							$msg.="<label><input type=\"radio\" name=\"sex\" value=\"男\" required>男</label>
	      		<label><input type=\"radio\" name=\"sex\" value=\"女\" checked>女</label>";
						}

					$msg.="</td></tr>
			<tr><td>出生日期(西元): </td><td><input type=\"date\" name=\"birthday\" value=\"{$row['Birthday']}\"></td></tr>
			<tr><td>郵件: </td><td><input type=\"text\" name=\"mail\" size=\"20\" maxlength=\"100\" value=\"{$row['Mail']}\" required></td></tr>
			<tr><td>手機: </td><td><input type=\"text\" name=\"phone\" size=\"20\" maxlength=\"50\" value=\"{$row['Phone']}\"></td></tr>
			";

					$arrInterest=explode(",", $row['Interest']); //資料庫提取出來的字串資料切割(Interest)
					if(isset($arrInterest)){
						if(in_array("鉛筆畫", $arrInterest)){
							$msg.="<tr><td>繪畫偏好: </td><td>
				<label><input type=\"checkbox\" name=\"paints[]\" value=\"鉛筆畫\" checked/>鉛筆畫</label>";
						}
						else{
							$msg.="<tr><td>繪畫偏好: </td><td>
				<label><input type=\"checkbox\" name=\"paints[]\" value=\"鉛筆畫\"/>鉛筆畫</label>";
						}
						if(in_array("色鉛筆畫", $arrInterest)){
							$msg.="<label><input type=\"checkbox\" name=\"paints[]\" value=\"色鉛筆畫\" checked/>色鉛筆畫</label>";
						}
						else{
							$msg.="<label><input type=\"checkbox\" name=\"paints[]\" value=\"色鉛筆畫\"/>色鉛筆畫</label>";
						}
						if(in_array("油畫", $arrInterest)){
							$msg.="<label><input type=\"checkbox\" name=\"paints[]\" value=\"油畫\" checked/>油畫</label>";
						}
						else{
							$msg.="<label><input type=\"checkbox\" name=\"paints[]\" value=\"油畫\"/>油畫</label>";
						}
						if(in_array("水彩畫", $arrInterest)){
							$msg.="<label><input type=\"checkbox\" name=\"paints[]\" value=\"水彩畫\" checked/>水彩畫</label></td>";
						}
						else{
							$msg.="<label><input type=\"checkbox\" name=\"paints[]\" value=\"水彩畫\"/>水彩畫</label></td>";
						}							
					}
					//checkbox警示文字
					$msg.="<td style=\"visibility:hidden; color:darkred;\" id=\"chk_option_error\">請選擇至少一項</td></tr>";

					if($row['CourseType']=="線上課程"){
						$msg.="<tr><td>希望課程類型: </td><td><label><input type=\"radio\" name=\"course\" value=\"線上課程\" checked required>線上課程</label>
	      		<label><input type=\"radio\" name=\"course\" value=\"實體互動\">實體互動</label></td></tr>";
					}
					else{
						$msg.="<tr><td>希望課程類型: </td><td><label><input type=\"radio\" name=\"course\" value=\"線上課程\" required>線上課程</label>
	      		<label><input type=\"radio\" name=\"course\" value=\"實體互動\" checked>實體互動</label></td></tr>";
					}

					$msg.="</table></br><input id=\"btn\" type=\"submit\" value=\"完成\"></form>";
			      								      		
					$_SESSION['action']="change"; //可以進入改寫資料庫動作
					$_SESSION['id']=$row['ID'];
					mysqli_stmt_close($stmt);
					mysqli_close($db_link);				
			
				}
							
				echo $msg;
			?>
		    
		</div>
	</body>
</html>
