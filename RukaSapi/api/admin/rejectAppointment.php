<?php
require_once "../config/connect.php";
$response = array();
$id = $_POST['id'];
$breed = $_POST['breed'];
$to_email = $_POST['email'];
$date = $_POST['date'];

$subject = "RUKA ŠAPI - Udomljavanje ljubimaca";
$body = "Poštovani,\n\nNažalost Vaš zahtjev za šetnju ljubimca rase $breed koji je zakazan za $date je odbijen.\n\nSrdačan pozdrav";

if (mail($to_email, $subject , $body)) {
    $result = $connect->query("DELETE FROM request WHERE id = '$id'");

    $response["success"] = 1;
    $response["message"] = "Email successfully sent to $to_email";
} else {
    $response["success"] = 0;
    $response["message"] = "Email sending failed";
}
echo json_encode($response);