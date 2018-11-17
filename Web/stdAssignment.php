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
        <p>제목 : Test Assignment</p>
        <p>제출마감일 : 2018-11-05 오후 11:59</p>
        <p>내용 : Assignment Text test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance test long stance </p>
        <p>첨부파일 : result.png</p>
        <p>
            코드작성<br>
            <textarea rows="10" cols="100">
#include <stdio.h>
int main(){
 return 0;
 }
            </textarea>
        </p>
        <p>실행결과 : abcdefghijklmnopqrstuvwxyz</p>
        <p><button>코드 실행</button> <button>제출</button></p>
    </div>
	

</body>
</html>
