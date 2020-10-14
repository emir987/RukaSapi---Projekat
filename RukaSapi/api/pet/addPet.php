<?php

$response = array();


foreach ($_FILES as $key => $value) {

    $target_dir = 'C:\/xampp\/htdocs\/RukaSapi\/slike\/';
    $target_file = $target_dir . basename($_FILES["$key"]["name"]);

    move_uploaded_file($value["tmp_name"], $target_file);

            // $uploadOk = 1;
            // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // // Check if image file is a actual image or fake image
            // $check = getimagesize($value["tmp_name"]);
            // if($check !== false) {
            //     $uploadOk = 1;
            //     move_uploaded_file($value["tmp_name"], $target_file);
            // } else {
            //     $uploadOk = 0;
            // }
    }
      


if (isset($_POST['name']) && isset($_POST['breed']) && isset($_POST['color'])
    && isset($_POST['weight']) && isset($_POST['height']) && isset($_POST['age'])
    && isset($_POST['ownerID']) && isset($_POST['description'])
    && isset($_POST['category']) && isset($_POST['gender'])) {

    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $color = $_POST['color'];
    $growth = $_POST['growth'];
    $hairLength = $_POST['hair_length'];
    $weight = $_POST['weight'];
    if ($weight < 5) $filterWeight = 'XS';
    elseif ($weight < 10) $filterWeight = 'S';
    elseif ($weight < 20) $filterWeight = 'M';
    elseif ($weight < 30) $filterWeight = 'L';
    elseif ($weight > 30) $filterWeight = 'XL';
    $height = $_POST['height'];
    $age = $_POST['age'];
    $ownerID = $_POST['ownerID'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $gender = $_POST['gender'];

    $errorResponse = new stdClass();
    $isOk = true;
    $errorResponse->nameMessage = "";
    $errorResponse->breedMessage = "";
    $errorResponse->colorMessage = "";
    $errorResponse->weightMessage = "";
    $errorResponse->heightMessage = "";
    $errorResponse->descriptionMessage = "";
    $errorResponse->categoryMessage = "";


    if (empty($breed)) {
        $isOk = false;
        $errorResponse->breedMessage = "Unesite rasu";
    }

    if (empty($color)) {
        $isOk = false;
        $errorResponse->colorMessage = "Unesite boju dlake";
    }

    if (empty($weight)) {
        $isOk = false;
        $errorResponse->weightMessage = "Unesite tezinu";
    }

    if (empty($height)) {
        $isOk = false;
        $errorResponse->heightMessage = "Unesite visinu";
    }

    if (empty($description)) {
        $isOk = false;
        $errorResponse->descriptionMessage = "Unesite opis";
    }

    if (empty($category)) {
        $isOk = false;
        $errorResponse->categoryMessage = "Odaberite kategoriju";
    }

    if ($isOk) {

        foreach ($_FILES as $key => $value) {

            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["$value"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["$value"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
        }
        

        require_once "../config/connect.php";

        $datetime = date_create()->format('Y-m-d H:i:s');

        if (isset($_POST['no-name'])) {
            $name = "Bez imena";
        }

        $query = "INSERT INTO pet(name, breed, color, weight, height, age, ownerID, description, category, date, filterWeight, gender, growth, hairLength, status)
                VALUES('$name', '$breed', '$color', '$weight', '$height', '$age', '$ownerID', '$description', '$category', '$datetime', '$filterWeight', '$gender', '$growth', '$hairLength', 'aktivan')";

        $result = $connect->query($query);

        $queryPetID = "SELECT id FROM pet ORDER BY id DESC LIMIT 1";
        $resultPet = $connect->query($queryPetID);
        $idRow = $resultPet->fetch_assoc();
        $idPet =  $idRow["id"];

        foreach ($_FILES as $key => $value) {
            $name = $value["name"];
            $queryImage = "INSERT INTO pet_images(petID, image)
                VALUES('$idPet', '$name')";
            $connect->query($queryImage);
        }
        if ($result) {
            
            // successfully inserted into database
            $response["success"] = "1";
            $response["message"] = "Product successfully created.";

            //insert new pet for each user
            $query = "INSERT INTO newpets (petID, userID) 
                    SELECT $idPet, id FROM users";

            $connect->query($query);

            //ukoliko nema imena unesi 3 random predloga za glasanje
            if (isset($_POST['no-name'])) {

                if ($_POST['gender'] == 'musko') {
                    $maleNames = array('Simba', 'Micko', 'Kiki', 'Frodo', 'Snupi', 'Mob', 'Loki', 'Han', 'Kasper', 'Bambi', 'Beni', 'Bendzi', 'Cezar', 'Dragon', 'Donat', 'Laki', 'Lex', 'Max', 'Zak');
                    for ($i=0; $i < 3; $i++) { 
                        $random_key=array_rand($maleNames);
                        $rand_name = $maleNames[$random_key];
                        unset($maleNames[$random_key]);
                        $upit = $connect->prepare("INSERT INTO new_name (petID, choose, name) VALUES (?, ?, ?)");
                        $upit->bind_param("iis", $idPet, $i, $rand_name);
                        $result1 = $upit->execute();
                        $upit->close();
                    }
                }else{
                    $femaleNames = array("Rilei", "Sasa", "Leksi", "Ema", "Megi", "Lala", "Ani", "Emili", "Gara", "Elis", "Lejdi", "Ani", "Deksi", "Kona", "Ela", "Mona", "Dona", "Penelopa", "Mona");
                    for ($i=0; $i < 3; $i++) { 
                        $random_key=array_rand($femaleNames);
                        $rand_name = $femaleNames[$random_key];
                        unset($femaleNames[$random_key]);
                        $upit = $connect->prepare("INSERT INTO new_name (petID, choose, name) VALUES (?, ?, ?)");
                        $upit->bind_param("iis", $idPet, $i, $rand_name);
                        $result2 = $upit->execute();
                        $upit->close();
                    }
                }
            }

            echo json_encode($response);

        } else {

            // failed to insert row
            $response["success"] = "0";
            $response["message"] = "Oops! An error occurred.";

            echo json_encode($response);
        }

    } else {
        // required field is empty
        $response["success"] = "0";
        $response["errorMessage"] = $errorResponse;
        $response["message"] = "Required field(s) is empty";

        echo json_encode($response);

    }
} else {
    // required field is missing
    $response["success"] = "0";
    $response["message"] = "Required field(s) is missing";

    echo json_encode($response);
}