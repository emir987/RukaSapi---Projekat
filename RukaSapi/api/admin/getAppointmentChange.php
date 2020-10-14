<?php
session_start();
$response = array();
require_once "../config/connect.php";

if (isset($_SESSION['id'])){
    $idUser = $_SESSION['id'];
}

$idUser = $_SESSION['id'];
$idRequest = $_POST['idRequest'];


$queryGetChange = "SELECT * FROM change_appointment_pending WHERE request_id = '$idRequest'";

$resultChanges = $connect->query($queryGetChange);

if ($resultChanges->num_rows > 0) {

    $row = $resultChanges->fetch_assoc();

    $response["startDate"] = $row['start_date'];
    $id_cap = $row["id"];
    $response["id_cap"] = $row["id"];

    $query = "SELECT * FROM change_pending_times where id_cap = '$id_cap'";
    $resultTimes = $connect->query($query);

    $times = array();
    while ($row1 = $resultTimes->fetch_assoc()) {
        $time = new stdClass();
        $time->fromTime = $row1["from_time"];
        $time->toTime = $row1["to_time"];
        array_push($times, $time);
    }

    $response["times"] = $times;

    $response["success"] = 1;
    $response["message"] = "Success";
    echo json_encode($response);

} else {
    $response["success"] = 0;
    $response["message"] = "No changes found";

    echo json_encode($response);
}