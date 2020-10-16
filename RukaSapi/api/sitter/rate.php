<?php
session_start();
require_once "../config/connect.php";

$response = array();

$stars = (int)$_POST['star'];
$message = $_POST['message'];
$sitter_id = (int)$_POST['sitter_id'];
$request_id = (int)$_POST['request_id'];
$datetime = date_create()->format('Y-m-d H:i:s');

if (isset($_SESSION['id'])){
    $idUser = (int)$_SESSION['id'];
}

$upit = $connect->prepare("INSERT INTO sitter_rating (id_sitter, message, stars, id_user, date) VALUES (?, ?, ?, ?, ?)");
$upit->bind_param("isiis", $sitter_id, $message, $stars, $idUser, $datetime);
$result = $upit->execute();
$upit->close();

$connect->query("UPDATE request SET rated = 1 WHERE id = $request_id;");

if ($result) {
    $response["success"] = "1";
} else {
    $response["success"] = "0";
}
echo json_encode($response);