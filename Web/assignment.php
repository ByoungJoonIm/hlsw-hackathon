<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
ini_set('register_globals', 'off');

include_once "database.php";

session_start();

$conn = dbConnection("52.231.71.254", "danglingelse", "xxxxx", "danglingelse");
$sub_id = $_GET['sub_id'];

$assignment_list = getAssignmentList($conn, $sub_id);
$ass_count = count($assignment_list);
$id = $_SESSION["id"];
if(!isProfessor($conn, $id)) {
	echo "<script>alert('접근권한이 없습니다!'); location.replace('/');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="ass_style2.css">
    <title>Assignment Page</title>
</head>
<body>
<div>
    <div class="box">
        <form method="POST" action="assignmentSub.php">
            <input type="hidden" name="sub_id" value="<?php echo $sub_id; ?>">
            <p>제목 : <input type="text" name="title" value="Title" required > </p>
            <p>주차 : <?php echo "week" . ($ass_count + 1);?><input type="hidden" name="week" value="<?php echo "week" . ($ass_count + 1);?>" ></p>
            <p>제출마감일 : <input type="datetime-local" name="deadline" value="2018-11-05T23:59" > </p>
            <p>내용 :
                <textarea name="text" rows="10" cols="100"></textarea>
            </p>
            <p>첨부파일 : <input type="file" ></p>
            <p><button class="button" onsubmit="">과제 업로드</button></p>
        </form>
	</div>
</div>
</body>
</html>
