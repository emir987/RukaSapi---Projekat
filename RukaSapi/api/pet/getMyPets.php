<?php
session_start();
$userID = $_SESSION['id'];
require_once "../config/connect.php";

$response = array();

$query = "SELECT * FROM pet WHERE ownerID = '$userID'";

$result = $connect->query($query);

if ($result->num_rows > 0) {

    $response["pets"] = array();

    while ($row = $result->fetch_assoc()) {

        $pet = array();
        $id = $row["id"];
        $pet["id"] = $row["id"];
        $pet["name"] = $row["name"];
        $pet["date"] = $row['date'];
        $pet["status"] = $row['status'];

        $imagesQuery = "SELECT * from pet_images WHERE petID = '$id'";
        $imagesResult = $connect->query($imagesQuery)->fetch_assoc();
        
        $pet["image"] = $imagesResult["image"];
        
        // push single pet into final response array
        array_push($response["pets"], $pet);
    }
    $response["success"] = 1;
} else {
    $response["success"] = 0;
    $response["message"] = "No pets found";
}
echo json_encode($response);
