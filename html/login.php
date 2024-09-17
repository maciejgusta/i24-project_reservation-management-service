<?php
session_start();

if (isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    echo "$username $password";
}

$sql_servername = "localhost";
$sql_username = "admin";
$sql_password = "admin";
$sql_db = "jadzia";

$db = new mysqli($sql_servername, $sql_username, $sql_password, $sql_db);

if ($db->connect_error){
    die("Connection failed" . $db->connect_error);
}
echo "Connection OK";