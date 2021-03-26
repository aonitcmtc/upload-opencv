<?php
$servername = "localhost";
$dbname = "Embedded";
$username = "root";
$password = "ePsgRnHHRK3V6A";

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$api_key = $date = $time = $hummidity = $tempC = $tempF = $sensor;

//date_default_timezone_set('Asia/Bangkok');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $row_date = date("Y/m/d");
        $row_time = date("H:i:s");
        $row_hum = test_input($_POST["hummidity"]);
        $row_tempC = test_input($_POST["tempC"]);
        $row_tempF = test_input($_POST["tempF"]);
        $row_sensor = test_input($_POST["sensor"]);
        //echo "Date" . reading_time ;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "INSERT INTO tree (date, time, hummidity, tempC, tempF, sensor)
        VALUES ('" . $row_date . "', '" . $row_time . "', '" . $row_hum . "', '" . $row_tempC . "', '" . $row_tempF . "', '" . $row_sensor . "')"; 
 
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
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