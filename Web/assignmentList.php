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
    <title>Assignment List Page</title>
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
	$sub_id = $_GET['sub_id'];
	$assignment_list = getAssignmentList($conn, $sub_id);
	?>
    <div class="box">
        <p><?php echo getName( $conn, $id ); ?>님 환영합니다.</p>
        <p>학번 : <?php echo $id; ?> / 학년
            : <?php echo (int) ( ( getSemester( $conn, $id ) + 1 ) / 2 ) ?></p>
    </div>
    <h3>&nbsp;&nbsp;&nbsp;과목명 : <?php echo getSubjectName($conn, $sub_id); ?></h3>
    <br><br>
    <table class="blueone">
        <tr> <th>주차</th> <th>제목</th> <th>제출마감일</th> </tr>
		<?php foreach($assignment_list as $ass) { ?>
            <tr> <td>[<?php echo $ass['week']; ?>]</td> <td><a href="stdAssignment.php?ass_id=<?php echo $ass['ass_num']; ?>" class="no-uline"><?php echo $ass['title']; ?></a></td> <td><?php echo date("Y-m-d\TH:i:s", $ass['deadline']); ?></td> </tr>
		<?php } ?>
        <!-- Test Data
        <tr> <td>[week02]</td> <td><a href="#" class="no-uline">Test2 Assignment</a></td> <td>2018-11-11</td> </tr>
        <tr> <td>[week03]</td> <td><a href="#" class="no-uline">Test3 Assignment</a></td> <td>2018-11-18</td> </tr>
        <tr> <td>[week04]</td> <td><a href="#" class="no-uline">Test4 Assignment</a></td> <td>2018-11-25</td> </tr>
        <tr> <td>[week05]</td> <td><a href="#" class="no-uline">Test5 Assignment</a></td> <td>2018-12-01</td> </tr>
        -->
    </table>
	<?php
}
    if(isProfessor($conn, $id)){
        ?>
            <button class="button" type="submit" onclick="location.replace('assignment.php?sub_id=<?php echo $sub_id; ?>')">과제 추가</button>
        <?php
    }
?>
</body>
</html>
