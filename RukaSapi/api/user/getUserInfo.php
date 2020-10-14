<?php
$response = array();
require_once "../config/connect.php";
session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}else{
    $response["success"] = 0;
    $response["message"] = "No logged user";

    echo json_encode($response);
    return;
}

$result = $connect->query("SELECT * FROM users WHERE id = $id");

$result = $result->fetch_assoc();

$user = new stdClass();

$user->email = $result["email"];
$user->phone = $result["phone"];
$user->name = $result["name"];
$user->surname = $result["surname"];
$user->address = $result["address"];
$user->zip = $result["zip"];

$response["success"] = 1;
$response["user"] = $user;

echo json_encode($response);

