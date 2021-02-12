<?php
$servername = "localhost";
$dbname = "class3";
$username = "root";
$password = "ePsgRnHHRK3V6A";

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$api_key= $camera = $view = $person = $time = "";

//date_default_timezone_set('Asia/Bangkok');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $camera = test_input($_POST["camera"]);
        $view = test_input($_POST["view"]);
        $person = test_input($_POST["person"]);
        $time = date("Y-m-d H:i:s");
        //echo "Date" . reading_time ;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "INSERT INTO person (camera, view, person, time)
        VALUES ('" . $camera . "', '" . $view . "', '" . $person . "', '" . $time . "')"; 
 
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        }   //* 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST." . "<br>" ;
    $date = date(" Y-m-d ") ;
    $time = date(" H-i-s ") ;
    echo "Date" . $date . "<br>" ;
    echo "Time" . $time . "<br>" ;
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}