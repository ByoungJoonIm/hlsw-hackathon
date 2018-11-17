<?php
/**
 * Created by PhpStorm.
 * User: lee-app
 * Date: 2018-11-16
 * Time: 오후 9:25
 */
$ip = $_POST["ip"];
$port = $_POST["port"];
$request_number = $_POST["request_number"];
$subject_id = $_POST["subject_id"];
$assignment_id = $_POST["assignment_id"];

$id = $_POST["id"];
$text = $_POST["text"];

$file_name = "./files/" . $id . ".c";
if(!file_exists("./files/")) mkdir("./files/");
$file = fopen($file_name, "w+");
$result = fwrite($file, $text);
$result = fclose($file);

// file_put_contents ($dir.'/test.txt', 'Hello File');

if($result) {
	$command = "./files/web_sender {$ip} {$port} {$request_number} {$id} {$subject_id} {$assignment_id}";
	$exec_result = exec($command);
	echo $exec_result;
}
else echo "fail make file";