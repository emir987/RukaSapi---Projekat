<?php
require_once "../config/connect.php";

$response = array();

$response["selects"] = $_POST['selects'];

$selects = json_decode($_POST['selects']);

$id = $_POST['idRequest'];
$to_time = $_POST['to_time'];
$from_time = $_POST['from_time'];
$date = $_POST['date'];

$resultEmail = $connect->query("SELECT email FROM request INNER JOIN users ON request.userID = users.id AND request.id = $id")->fetch_assoc();

$to_email = $resultEmail["email"];
$subject = "RUKA ŠAPI - Promjena zahtjeva za šetnju ljubimca";
$body = "Poštovani,\n\nNažalost Vaš zahtjev za šetnju ljubimca koji je zakazan za $date je odbijen.\nŠetač je slobodan na datum $date od $from_time do $to_time, ukoliko Vam odgovara potvrdite u aplikaciji.\nhttp://localhost/rukasapi/termini.php\n\nSrdačan pozdrav";

if (mail($to_email, $subject , $body)) {
    
    $connect->query("INSERT INTO change_appointment_pending (request_id, start_date)
                                VALUES ('$id', '$date')");

    $result = $connect->query("SELECT max(id) as id from change_appointment_pending")->fetch_assoc();

    $id_cap = $result["id"];

    foreach ($selects as $value) {
        $connect->query("INSERT INTO change_pending_times (id_cap, from_time, to_time)
                        VALUES ('$id_cap', '$value->from', '$value->to')");
    }

    $response["success"] = 1;
    $response["message"] = "Email successfully sent to $to_email";
} else {
    $response["success"] = 0;
    $response["message"] = "Email sending failed";
}
echo json_encode($response);