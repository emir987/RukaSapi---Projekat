<?php
session_start();
$response = array();

$userID = 0;

if (isset($_SESSION['id'])){
    $userID = $_SESSION['id'];
}
require_once "../config/connect.php";


$latitude = (float)$_POST['lat'];
$longitude = (float)$_POST['lng'];

$query = "SELECT *, (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians( latitude )))) AS distance 
FROM sitters, users
WHERE sitters.idUser = users.id
HAVING distance < 10";


$result = $connect->query($query);

if ($result->num_rows > 0) {

    $response["sitters"] = array();

    while ($row = $result->fetch_assoc()) {

        $sitter = array();

        $sitterID = $row["idSitter"];
        $sitter["id"] = $sitterID;
        $sitter["name"] = $row["name"];
        $sitter["surname"] = $row["surname"];
        $sitter["email"] = $row["email"];
        $sitter["phone"] = $row["phone"];
        $sitter["address"] = $row["address"];
        $sitter["price"] = $row["price"];
        $sitter["image"] = $row["photo"];
        $sitter["distance"] = $row["distance"];
        $sitter["mainMessage"] = $row["mainMessage"];

        $reviews = "SELECT message, stars FROM sitter_rating WHERE id_sitter = '$sitterID'";
        $reviewResult = $connect->query($reviews);
        $sitter['allReviews'] = array();
        $starsSum = 0;
        $reviewsCount = 0;
        while($rowReview = $reviewResult->fetch_assoc()){
            
            $starsSum += (int)$rowReview['stars'];
            $reviewsCount++;
            $eachReview = substr($rowReview['message'], 0,85);

            array_push($sitter['allReviews'], $eachReview);
        }

        $sitter['reviews'] = $reviewsCount;
        $sitter['starsSum'] = $starsSum;

        $countFavQuery = "SELECT COUNT(*) as favs FROM favoritesitter WHERE sitterID = '$sitterID'";
        $countFavResult = $connect->query($countFavQuery);
        $rowSitter = $countFavResult->fetch_assoc();
        $sitter['favs'] = $rowSitter['favs'];

        $countQuery = "SELECT * from favoriteSitter WHERE sitterID = '$sitterID' and userID = '$userID'";
        $countResult = $connect->query($countQuery);

        if ($countResult->num_rows >0){
            $sitter["favorite"] = 'yes';
        }else{
            $sitter["favorite"] = 'no';
        }


        // push single product into final response array
        array_push($response["sitters"], $sitter);
    }

    $response["success"] = "1";
    if ($userID == 0) {
        $response['logged'] = '0';
    }else{
        $response['logged'] = '1';
    }
    
    echo json_encode($response);

} else {
    $response["sitters"] = [];
    $response["success"] = "0";
    $response["message"] = "No sitters found";

    echo json_encode($response);
}