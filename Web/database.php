<?php
/**
 * Created by PhpStorm.
 * User: lee-app
 * Date: 2018-11-16
 * Time: 오후 11:18
 */

// host = 52.231.69.134:3306, id = root, password = danglingelse, database = danglingelse
function dbConnection($host, $id, $password, $database){
	$conn = mysqli_connect($host, $id, $password, $database);
	return $conn;
}

function getSubjectList($conn, $id){
	$query = "SELECT * FROM subject WHERE sub_id IN (SELECT sub_id FROM lecture WHERE id = '{$id}')";
	$query_result = mysqli_query($conn, $query);
	$result = array();
	while($row = mysqli_fetch_array($query_result, MYSQLI_ASSOC)) {
		array_push($result, $row);
	}
	return $result;
}

function getAssignmentList($conn, $sub_id){
	if($sub_id != -1) $query = "SELECT * FROM assignment WHERE sub_id = '{$sub_id}'";
	else $query = "SELECT * FROM assignment";
	$query_result = mysqli_query($conn, $query);
	$result = array();
	while($row = mysqli_fetch_array($query_result, MYSQLI_ASSOC)) {
		array_push($result, $row);
	}
	return $result;
}

function getAssignment($conn, $ass_id){
	$query = "SELECT * FROM assignment WHERE ass_id = '{$ass_id}'";
	$query_result = mysqli_query($conn, $query);
	$result = array();
	while($row = mysqli_fetch_array($query_result, MYSQLI_ASSOC)) {
		array_push($result, $row);
	}
	return $result;
}

function addAssignment($conn, $title, $text, $deadline, $sub_id, $week){
	$ass_id = count(getAssignmentList($conn, -1));
	$query = "INSERT INTO assignment VALUES('{$ass_id}', '{$title}', '{$text}', '{$deadline}', '{$sub_id}', '{$week}')";
	$query_result = mysqli_query($conn, $query);
	return $query_result;
}

function updateAssignment($conn, $ass_id, $title, $text, $deadline){
	$query = "UPDATE assignment SET title = '{$title}', text = '{$text}', deadline = '{$deadline}' WHERE ass_id = '{$ass_id}'";
	$query_result = mysqli_query($conn, $query);
	return $query_result;
}

function getStdAssignment($conn, $ass_id, $id){
	$query = "SELECT * FROM std_assignment WHERE ass_number = '{$ass_id}' AND std_id = '{$id}'";
	$query_result = mysqli_query($conn, $query);
	$result = array();
	while($row = mysqli_fetch_array($query_result, MYSQLI_ASSOC)) {
		array_push($result, $row);
	}
	return $result;
}

function addStdAssignment($conn, $ass_id, $id, $text, $sub_date){
	$query = "INSERT INTO std_assignment VALUES('{$ass_id}', '{$id}', '{$text}', '{$sub_date}')";
	$query_result = mysqli_query($conn, $query);
	return $query_result;
}

function updateStdAssignment($conn, $ass_id, $std_id, $text, $sub_date){
	$query = "UPDATE std_assignment SET text = '{$text}', sub_date = '{$sub_date}' WHERE ass_id = '{$ass_id}' AND std_id = '{$std_id}'";
	$query_result = mysqli_query($conn, $query);
	return $query_result;
}

function login($conn, $id, $password){
	$query = "SELECT * FROM user WHERE id = '{$id}' AND password = '{$password}'";
	$query_result = mysqli_query($conn, $query);
	$result = array();
	while($row = mysqli_fetch_array($query_result, MYSQLI_ASSOC)) {
		array_push($result, $row);
	}
	return count($result);
}

function getName($conn, $id){
	$query = "SELECT * FROM professor, student WHERE std_id = '{$id}' OR pro_id = '{$id}'";
	$query_result = mysqli_query($conn, $query);
	$result = array();
	while($row = mysqli_fetch_array($query_result, MYSQLI_ASSOC)) {
		array_push($result, $row);
	}
	if(count($result) == 1) return $result[0]["name"];
	else return 'None';
}

function getSemester($conn, $id){
	$query = "SELECT * FROM student WHERE std_id = '{$id}'";
	$query_result = mysqli_query($conn, $query);
	$result = array();
	while($row = mysqli_fetch_array($query_result, MYSQLI_ASSOC)) {
		array_push($result, $row);
	}
	if(count($result) == 1) return $result[0]["cur_semester"];
	else return 'None';
}

function getSubjectName($conn, $sub_id){
	$query = "SELECT * FROM subject WHERE sub_id = '{$sub_id}'";
	$query_result = mysqli_query($conn, $query);
	$result = array();
	while($row = mysqli_fetch_array($query_result, MYSQLI_ASSOC)) {
		array_push($result, $row);
	}
	if(count($result) == 1) return $result[0]["title"];
	else return 'None';
}

function isProfessor($conn, $id){
	$query = "SELECT * FROM professor WHERE pro_id = '{$id}'";
	$query_result = mysqli_query($conn, $query);
	$result = array();
	while($row = mysqli_fetch_array($query_result, MYSQLI_ASSOC)) {
		array_push($result, $row);
	}
	if(count($result) == 1) return true;
	else return false;
}