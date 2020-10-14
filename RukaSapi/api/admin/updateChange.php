<?php
require_once "../config/connect.php";

$response = array();

$id_cap = $_POST['id_cap'];


$from = $_POST['from'];

$to = $_POST['toTime'];

$startDate = $_POST['startDate'];


$resultID = $connect->query("SELECT request_id FROM change_appointment_pending WHERE id = '$id_cap'")->fetch_assoc();

$id = $resultID["request_id"];
    
$isOk = $connect->query("UPDATE request SET fromTime = $from, toTime = $to, strartDate = '$startDate' WHERE id = '$id'");

if ($isOk == 1) {
    $response["success"] = 1;
} else {
    $response["success"] = 0;
}
echo json_encode($response);