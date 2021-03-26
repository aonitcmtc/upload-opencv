<?php
$servername = "localhost";
// REPLACE with your Database name
$dbname = "ESP-DB-Test";
// REPLACE with Database user
$username = "root";
// REPLACE with Database user password
$password = "ePsgRnHHRK3V6A";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, sensor, location, value1, value2, value3, reading_time FROM SensorData ORDER BY id DESC";


//echo $last;

if ($result = $conn->query($sql)) {
    if ($row = $result->fetch_array()) {
        $data->row_id = $row["id"];
        $data->row_sensor = $row["sensor"];
        $data->row_location = $row["location"];
        $data->row_value1 = $row["value1"];
        $data->row_value2 = $row["value2"]; 
        $data->row_value3 = $row["value3"]; 
        $data->row_reading_time = $row["reading_time"];
        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));

        $myJson = json_encode($data);

        echo $myJson;
        //echo '<tr> 
          //      <td>' . $row_id . '</td> 
            //    <td>' . $row_sensor . '</td> 
              //  <td>' . $row_location . '</td> 
               // <td>' . $row_value1 . '</td> 
               // <td>' . $row_value2 . '</td>
               // <td>' . $row_value3 . '</td> 
               // <td>' . $row_reading_time . '</td> 
             // </tr>';
    }
    $result->free();
}

$conn->close();
?>