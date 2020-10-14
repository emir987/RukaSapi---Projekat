<?php
$response = array();
require_once "../config/connect.php";


$queryGetFaq = "SELECT * FROM faq";

$resultFaq = $connect->query($queryGetFaq);

if ($resultFaq->num_rows > 0) {

    $faqs = array();
    
    while ($row = $resultFaq->fetch_assoc()) {

        $faq = new stdClass();

        $faq->id = $row['id'];
        $faq->pitanje = $row['pitanje'];
        $faq->odgovor = $row['odgovor'];

        array_push($faqs, $faq);
    }

    

    $response["success"] = 1;
    $response["message"] = "Success";
    $response["faqs"] = $faqs;
    echo json_encode($response);

} else {
    $response["success"] = 0;
    $response["message"] = "No changes found";

    echo json_encode($response);
}