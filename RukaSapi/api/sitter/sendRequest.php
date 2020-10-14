<?php
session_start();
$response = array();

require_once "../config/connect.php";

$datetime = date_create()->format('Y-m-d H:i:s');

$message = $_POST['message'];
$sitterID = $_POST['sitterID'];
$start = $_POST['start'];
$fromTime = $_POST['from'];
$toTime = $_POST['to'];
$breed = $_POST['breed'];

if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];
}

if (isset($_POST['userID'])){
    $userID = $_POST['userID'];
}

$query = "INSERT INTO request (userID, sitterID, message, currentDate, strartDate, fromTime, toTime, breed, status)
            VALUES('$userID', '$sitterID', '$message', '$datetime', '$start', '$fromTime', '$toTime', '$breed', 'Aktivan')";

$result = $connect->query($query);

if ($result) {
    $response["success"] = "1";
    $response["message"] = "Request successfully sent! ";

    echo json_encode($response);

} else {
    $response["success"] = "0";
    $response["message"] = "Oops! An error occurred.";

    echo json_encode($response);
}
