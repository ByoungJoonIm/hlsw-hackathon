<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
ini_set('register_globals', 'off');

include_once "database.php";

session_start();

$conn = dbConnection("52.231.71.254", "danglingelse", "xxxxx", "danglingelse");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="ass_style.css">
    <title>Subject LIst Page</title>
	<style trpe="text/css"> a:hover{color:#8A0886;} </style>

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

$subject_list = getSubjectList($conn, $id);
	?>
    <div class="box">
        <p align="center"><?php echo getName( $conn, $id ); ?>님 환영합니다.</p>
        <p align="center">학번 : <?php echo $id; ?> / 학년
            : <?php echo (int) ( ( getSemester( $conn, $id ) + 1 ) / 2 ) ?></p>
    </div>
    <br><br>
    <table class="blueone">
        <tr>
            <th>과목</th>
            <th>최근 과제</th>
        </tr>
    <?php
        foreach($subject_list as $sub) {
            $assignment_list = getAssignmentList($conn, $sub['sub_id']);

        ?>
        <tr>
            <td><a href="/assignmentList.php?sub_id=<?php echo $sub["sub_id"]?>"
                   class="no-uline"><?php echo "[{$sub['year']}-{$sub['semester']}-{$sub['class']}] {$sub['title']}"?></a></td>
            <?php
                if(count($assignment_list) != 0) {
                $last_assignment = $assignment_list[count($assignment_list) - 1];
            ?>
            <td><a href="stdAssignment.php?ass_id=<?php echo $last_assignment['ass_num']; ?>"
                   class="no-uline"><?php echo "[{$last_assignment['week']}] {$last_assignment['title']}"; ?></a></td>
	        <?php }?>
        </tr>
    <?php } ?>
    </table>
	<?php
}
?>
</body>
</html>
