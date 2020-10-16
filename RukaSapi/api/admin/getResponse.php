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

$result = $connect->query("SELECT * FROM request where userID = '$idUser' order by status");


if ($result->num_rows > 0) {

    $response["requests"] = array();

    while ($row = $result->fetch_assoc()) {

        $userID = $row['userID'];
        $sitterID = $row['sitterID'];

        //Request from
        $userSQL = $connect->query("SELECT * FROM sitters INNER JOIN users ON sitters.idUser = users.id AND sitters.idSitter = $sitterID");
        $rowSitter = $userSQL->fetch_assoc();
        $sitter = array();
        $sitter["name"] = $rowSitter["name"];
        $sitter["surname"] = $rowSitter["surname"];
        $sitter["email"] = $rowSitter["email"];
        $sitter["phone"] = $rowSitter["phone"];
        $sitter["photo"] = $rowSitter["photo"];
        $sitter["idSitter"] = $rowSitter["id"];


        //request
        $idRequest = $row['id'];

        $request['id'] = $idRequest;
        $request["sitter"] = $sitter;
        $request["requestMessage"] = $row["message"];
        $request["date"] = $row["currentDate"];      
        $request["start"] = $row['strartDate'];
        $request["from"] = $row['fromTime'];
        $request["to"] = $row['toTime'];
        $request["siterID"] = $row['sitterID'];
        $request["status"] = $row['status'];
        $request["breed"] = $row['breed'];
        $request["rated"] = $row['rated'];
        $sitterID = $row['sitterID'];

        $resultChange = $connect->query("SELECT * FROM change_appointment_pending where request_id = '$idRequest'");


        if ($resultChange->num_rows > 0) {
            $request["change"] = 1;
        }else{
            $request["change"] = 0;
        }
        

        // //Request to
        // $sitterSQL = $connect->query("SELECT * FROM sitters s, users u where idSitter='$sitterID' and u.id = s.idUser");
        // $rowSitter = $sitterSQL->fetch_assoc();
        // $sitter = array();
        // $sitter["idUser"] = $rowSitter["idUser"];


        // $sitter["surname"] = $rowSitter["surname"];
        // $sitter["name"] = $rowSitter["name"];
        // $sitter["userID"] = $rowSitter["id"];
        // $request["sitter"] = $sitter;

        //push single comment into comments array
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