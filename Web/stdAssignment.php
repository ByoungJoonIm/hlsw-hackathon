<?php
include_once "database.php";

session_start();

$conn = dbConnection("52.231.71.254", "danglingelse", "xxxxx", "danglingelse");
$ass_id = $_GET['ass_id'];

$ass = getAssignment($conn, $ass_id);
$id = $_SESSION["id"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Assignment Write Page</title>
	<link rel="stylesheet" href="ass_style2.css">
</head>
<!-- 학생 과제 제출 페이지 : 제목, 내용, 제출마감일, 첨부파일, 코드작성란 -->
<body>
    <div>
        <p>제목 : <?php echo $ass['title']; ?></p>
        <p>주차 : <?php echo $ass['week']; ?></p>
        <p>제출마감일 : <?php echo date("Y-m-d\TH:i:s", $ass['deadline']); ?></p>
        <p>내용 : <?php echo $ass['text']; ?> </p>
        <?php if(!isProfessor($conn, $id)){ ?>
        <p>
            코드작성<br>
            <textarea rows="10" cols="100">
#include <stdio.h>

int main(){
    return 0;
}
            </textarea>
        </p>
        <p>실행결과 : </p>
        <p><button class="button" >코드 실행</button> <button class="button" >제출</button></p>
        <?php }else{ ?>
        <p><button class="button">제출정보</button></p>
        <?php }?>
    </div>

</body>
</html>
