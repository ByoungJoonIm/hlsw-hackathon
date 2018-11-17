<?php
/**
 * Created by PhpStorm.
 * User: lee-app
 * Date: 2018-11-16
 * Time: 오후 10:46
 */

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
ini_set('register_globals', 'off');

session_start();

include_once "database.php";

$id = $_POST["id"];
$password = $_POST["password"];

$conn = dbConnection("52.231.71.254", "danglingelse", "xxxxx", "danglingelse");

if(!$conn){
	echo "<script>alert('connection failed!'); location.replace('/');</script>";
}

if(login($conn, $id, $password)){
	$_SESSION["id"] = $id;
	echo "<script>alert('login success!'); location.replace('/subjectList.html');</script>";
}else{
	echo "<script>alert('login failed!'); location.replace('/');</script>";
}

