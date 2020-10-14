<?php
session_start();
$response = array();
require_once "../config/connect.php";

if (isset($_POST['id'])) {
    $idUser = $_POST['id'];
}
if (isset($_SESSION['id'])){
    $idUser = $_SESSION['id'];
}

$date = new DateTime("now", new DateTimeZone("America/Detroit"));
$date =  $date->format("Y-m-d");

$connect->query("UPDATE request SET status = 'Zavrsen' WHERE strartDate < '$date'");
       
$getSitter = $connect->query("SELECT * FROM sitters where idUser = '$idUser'");
$getSitterArray = $getSitter->fetch_assoc();
$sitterID = $getSitterArray['idSitter'];

$result = $connect->query("SELECT * FROM request where sitterID = '$sitterID' order by status");


if ($result->num_rows > 0) {
    
    $response["requests"] = array();

    while ($row = $result->fetch_assoc()) {

        $userID = $row['userID'];
        $startDate = $row['strartDate'];

        $userSQL = $connect->query("SELECT * FROM users WHERE id='$userID'");
        $rowUser = $userSQL->fetch_assoc();

        $user = array();
        $user["name"] = $rowUser["name"];
        $user["surname"] = $rowUser["surname"];
        $user["email"] = $rowUser["email"];
        $user["phone"] = $rowUser["phone"];
        $user["userID"] = $rowUser["id"];
        $user["photo"] = $rowUser["photo"];
        

        //request
        $requestID = $row['id'];

        $request['id'] = $requestID;
        $request["customer"] = $user;
        $request["requestMessage"] = $row["message"];
        $request["date"] = $row["currentDate"];      
        $request["start"] = $startDate;
        $request["status"] = $row['status'];
        $request["from"] = $row['fromTime'];
        $request["to"] = $row['toTime'];
        $request["siterID"] = $row['sitterID'];
        $request["breed"] = $row['breed'];
        $sitterID = $row['sitterID'];

        array_push($response["requests"], $request);
    }

    $response["success"] = "1";
    echo json_encode($response);

} else {
    $response["success"] = "0";
    $response["message"] = "No comments found";

    echo json_encode($response);
}
?>