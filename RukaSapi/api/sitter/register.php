<?php
session_start();
$response = array();
$error = false;


$motivation = $_POST['motivation'];
$motivation = strip_tags($motivation);
$motivation = htmlspecialchars($motivation);

$info = $_POST['info'];
$info = strip_tags($info);
$info = htmlspecialchars($info);

$maxWeight = $_POST['maxWeight'];
$maxWeight = strip_tags($maxWeight);
$maxWeight = htmlspecialchars($maxWeight);

$lat = $_POST['lat'];

$lng = $_POST['lng'];

$price = $_POST['price'];
$price = strip_tags($price);
$price = htmlspecialchars($price);
$price = (int)$price;


$response['price'] = $price;
$response['maxw'] = $maxWeight;
$response['info'] = $info;
$response['motiva'] = $motivation;


$errorResponse = new stdClass();

$errorResponse->motivationMessage = "";
$errorResponse->infoMessage = "";
$errorResponse->maxWeightMessage = "";



if (empty($motivation)) {
    $error = true;
    $errorResponse->motivationMessage = "Please input motivation message";
}
if (empty($info)) {
    $error = true;
    $errorResponse->infoMessage = "Please input info";
}

if (empty($maxWeight)) {
    $error = true;
    $errorResponse->maxWeightMessage = "Please input max weight";
}


require_once "../config/connect.php";


if (!$error) {

    $idUser = $_SESSION['id'];
    $idUser = (int)$idUser;
    $datetime = date_create()->format('Y-m-d H:i:s');

    $upit = $connect->prepare("INSERT INTO sitters (petWeightMax, mainMessage, info, price, date, idUser, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $upit->bind_param("sssisidd", $maxWeight,  $motivation, $info, $price, $datetime, $idUser, $lat, $lng);
    $result = $upit->execute();
    $upit->close();

    if ($result) {

        // successfully inserted into database
        $response["success"] = 1;
        $response["error"] = $errorResponse;


    } else {

        // failed to insert row
        $response["success"] = 0;
        $errorResponse->databaseError = "Oops! An error occurred.";
        $response["error"] = $errorResponse;

    }

} else {

    $response["error"] = $errorResponse;
    $response["success"] = 0;


}

echo json_encode($response);

