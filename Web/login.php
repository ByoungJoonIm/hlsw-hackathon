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

include_once "database.php";

$id = $_POST["id"];
$password = $_POST["password"];

$conn = dbConnection("52.231.69.134", "root", "1234", "danglingelse");

if(!$conn) echo "<script>alert('connection failed!'); location.href('/');</script>";
else echo "<script>alert('connection success!'); location.href('/');</script>";