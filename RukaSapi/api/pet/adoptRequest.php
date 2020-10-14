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



$result = $connect->query("SELECT * FROM pet where ownerID = '$idUser'");


if ($result->num_rows > 0) {
    

    $response["requests"] = array();

    while ($row = $result->fetch_assoc()) {
        
        $petID = $row['id'];  

        //Request from
        $requestSQL = $connect->query("SELECT pet.breed as breed, pet.status as status, pet.id as petID, adopt_request.id as id, pet.status as status, pet.name as petName, message, fam_num, living, adopt_request.date, email, users.name as userName, surname, phone, address, zip, photo 
                                        FROM adopt_request 
                                        INNER JOIN users 
                                        ON users.id = adopt_request.userID AND petID='$petID'
                                        INNER JOIN pet ON pet.id = adopt_request.petID AND status like 'aktivan'");

        if ($requestSQL->num_rows > 0) {

            $request = array();
            $rowRequest = $requestSQL->fetch_assoc();
            $request["message"] = $rowRequest["message"];
            $request["id"] = $rowRequest["id"];
            $request["petID"] = $rowRequest["petID"];
            $request["breed"] = $rowRequest["breed"];
            $request["fam_num"] = $rowRequest["fam_num"];
            $request["living"] = $rowRequest["living"];
            $request["date"] = $rowRequest["date"];
            $request["petName"] = $rowRequest["petName"];
            $request["status"] = $rowRequest["status"];


            //request user
            $user = array();
            $user['email'] = $rowRequest['email'];
            $user['userName'] = $rowRequest['userName'];
            $user['surname'] = $rowRequest['surname'];
            $user['phone'] = $rowRequest['phone'];
            $user['address'] = $rowRequest['address'];
            $user['zip'] = $rowRequest['zip'];
            $user['photo'] = $rowRequest['photo'];
            $request["user"] = $user;

        //push single comment into comments array
            array_push($response["requests"], $request);
        }
    }

    $response["success"] = "1";
    echo json_encode($response);

} else {
    $response["success"] = "0";
    $response["message"] = "No pets found";

    echo json_encode($response);
}
?>