<?php
session_start();
$response = array();

require_once "../config/connect.php";

if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];

}else{
    $response['success'] = "3";
    $response['message'] = "not logged";
    echo json_encode($response);
    return;
}

$datetime = date_create()->format('Y-m-d H:i:s');

$message = $_POST["message"]; 

$family_number = $_POST['fam_num'];

$living = $_POST['living'];

$petID = $_POST['petID'];

$alreadyRequested = $connect->query("SELECT * FROM adopt_request WHERE userID = '$userID' and petID = '$petID'");

if ($alreadyRequested->num_rows > 0 ) {
    $response['success'] = "2";
    $response['message'] = "Already requested";
    echo json_encode($response);
    return;
}


$query = "INSERT INTO adopt_request (userID, petID, message, fam_num, living, date)
            VALUES('$userID', '$petID', '$message', '$family_number', '$living', '$datetime')";

$result = $connect->query($query);

if ($result) {
    $response["success"] = "1";
    $response["errorMessage"] = "haha";
} else {
    $response["success"] = "0";
    $response["errorMessage"] = "hahah";
}
echo json_encode($response);