<?php
$servername = "localhost";
$dbname = "ESP-DB-Test";
$username = "root";
$password = "ePsgRnHHRK3V6A";

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$api_key= $sensor = $location = $value1 = $value2 = $value3 = "";

//date_default_timezone_set('Asia/Bangkok');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $sensor = test_input($_POST["sensor"]);
        $location = test_input($_POST["location"]);
        $value1 = test_input($_POST["value1"]);
        $value2 = test_input($_POST["value2"]);
        $value3 = test_input($_POST["value3"]);
        $reading_time = date("Y-m-d H:i:s");
        //echo "Date" . reading_time ;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "INSERT INTO SensorData (sensor, location, value1, value2, value3, reading_time)
        VALUES ('" . $sensor . "', '" . $location . "', '" . $value1 . "', '" . $value2 . "', '" . $value3 . "', '" . $reading_time . "')"; 
 
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
    //echo "Date" . date(" Y-m-d ") . "<br>";
    //echo "Time" . date(" H:i:s ") . "<br>";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}