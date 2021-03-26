<?php
$servername = "localhost";
$dbname = "class3";
$username = "root";
$password = "ePsgRnHHRK3V6A";

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$api_key= $c1v1 = $c2v1 = $c3v1 = $c1v2 = $c2v2 = $c3v2 = $sum = "";

//date_default_timezone_set('Asia/Bangkok');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $v1 = test_input($_POST["c1v1"]);
        $v2 = test_input($_POST["c2v1"]);
        $v3 = test_input($_POST["c3v1"]);
        $v4 = test_input($_POST["c1v2"]);
        $v5 = test_input($_POST["c2v2"]);
        $v6 = test_input($_POST["c3v2"]);
        $r_sum = test_input($_POST["sum"]);
        $r_date = date("Y-m-d");
        $r_time = date("H:i:s");
        //echo "Date" . reading_time ;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "INSERT INTO allview (c1v1, c2v1, c3v1, c1v2, c2v2, c3v2, sum, date, time)
        VALUES ('" . $v1 . "', '" . $v2 . "', '" . $v3 . "', '" . $v4 . "', '" . $v5 . "', '" . $v6 . "', '" . $r_sum . "', '" . $r_date . "', '" . $r_time . "' )"; 
 
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