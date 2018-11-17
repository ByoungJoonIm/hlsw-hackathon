<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018-11-17
 * Time: 오후 4:36
 */

include_once "database.php";

session_start();

$conn = dbConnection("52.231.71.254", "danglingelse", "xxxxx", "danglingelse");

$title = $_POST["title"];
$week = $_POST["week"];
$deadline = date("Y-m-d\TH:i:s", strtotime($_POST["deadline"]));
$text = $_POST["text"];
$file = $_POST["file"];
$sub_id = $_POST["sub_id"];

$result = addAssignment($conn, $title, $text, $deadline, $sub_id, $week);

if(!$result) { ?>
	<script>
		alert('과제 업로드에 실패했습니다!<?php echo mysqli_error($conn);?>');
		location.replace('assignmentList.php?sub_id=<?php echo $sub_id; ?>');
	</script>
<?php }else{ ?>
	<script>
        alert('과제 업로드했습니다!');
        location.replace("stdAssignment.php?ass_id=<?php echo $result; ?>")
	</script>
<?php } ?>
