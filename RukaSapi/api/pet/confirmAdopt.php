<?php

$response = array();

require_once "../config/connect.php";



$id = $_POST["id"];
$petID = $_POST['petID'];


$result = $connect->query("DELETE FROM adopt_request WHERE petID = '$petID' AND id != $id");

$updateStatus = $connect->query("UPDATE pet SET status = 'udomljen' WHERE id = '$petID';");

if ($result && $updateStatus) {
    // check for empty result

    $response["success"] = 1;
    $response["message"] = "Successfuly deleted";

    echo json_encode($response);
} else {
    // no product found
    $response["success"] = 0;
    $response["message"] = "No product found";

    echo json_encode($response);
}

?>