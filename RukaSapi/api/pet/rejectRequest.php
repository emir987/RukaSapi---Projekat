
<?php
require_once "../config/connect.php";
$response = array();

$id = $_POST['id'];
$petName = $_POST['petName'];
$breed = $_POST['breed'];
$to_email = $_POST['email'];

$subject = "Udomljavanje ljubimaca";
$body = "Nažalost Vaš zahtjev za udomljavanje ljubimca $petName rase $breed je odbijen.";
$headers = "From: emir.kosuta@gmail.com";



if (mail($to_email, $subject , $body)) {
    $result = $connect->query("DELETE FROM adopt_request WHERE id = '$id'");

    $response["success"] = 1;
    $response["message"] = "Email successfully sent to $to_email";
} else {
    $response["success"] = 0;
    $response["message"] = "Email sending failed";
}
echo json_encode($response);

