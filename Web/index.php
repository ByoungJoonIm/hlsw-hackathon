<?php
include_once "database.php";

session_start();

$conn = dbConnection("52.231.71.254", "danglingelse", "xxxxx", "danglingelse");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
<?php if(!isset($_SESSION["id"])){ ?>
<h2 align="center">Login</h2>
<div class="wrapper">
	<form id="login_form" action="login.php" method="POST" FONT face="impact">
    <div class="wrap-input">
        <input name="id" class="input-block-level" type="text" placeholder="id" required></input>
    </div>
	<br>
    <div class="wrap-input">
        <input name="password" class="input-block-level" type="text" placeholder="password" required></input>
    </div>
	<br>
		<button class="button" onsubmit="" >login</button>
	</form>
</div>
<?php } else {
    $id = $_SESSION["id"];
    ?>
    <div class="box">
        <p><?php echo getName($conn, $id); ?>님 환영합니다.</p>
        <p>학번 : <?php echo $id; ?> / 학년 : <?php echo (int)((getSemester($conn, $id) + 1) / 2)?></p>
    </div>
<?php
}
?>
</body>
</html>