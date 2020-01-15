<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "MilkTeaShop";
	$db = new mysqli($servername, $username, $password, $database);

	/*====================Log in==========================*/
	
	function get_login($uname, $pass){
	global $db;
	$sql = "SELECT * FROM User";
	$result = $db->query($sql)->fetch_all();
	$check = false;

	for ($i = 0; $i < count($result); $i++) {
		if ($result[$i][1] == $uname && $result[$i][2] == $pass) {
			if ($result[$i][4] == "admin") {
				$check = true;
				header("location:indexAdmin.php");
				break;
			} else {
				header("location:indexUser.php");
				$_SESSION["user"] = $uname;
				$_SESSION["pass"] = $pass;
				break;
			}
		}
	}
		if ($check == false) {
			?>
			<script>
				alert("Login Fail");
			</script>
			<?php
		}
	}
	function IdUser(){
		global $db;
		$sql = "SELECT id from User where username='".$_SESSION["user"]."' and password='".$_SESSION["pass"]."'";
		$result = $db->query($sql)->fetch_all();
		return $result[0][0];
	}
	function a(){
		global $db;
		$sql = "SELECT * from user where idUser=".IdUser();
		$result = $db->query($sql)->fetch_all();
		var_dump($result);
	}
?>