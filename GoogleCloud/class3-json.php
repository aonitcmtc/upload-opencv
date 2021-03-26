<?php
$servername = "localhost";
// REPLACE with your Database name
$dbname = "class3";
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

$sql = "SELECT id, camera, view, person, time FROM person ORDER BY id DESC LIMIT 1";


//echo $last;

if ($result = $conn->query($sql)) {
    while($row = $result->fetch_array()){
        $data->row_id = $row["id"];
        $data->row_camera = $row["camera"];
        $data->row_view = $row["view"];
        $data->row_person = $row["person"];
        $data->row_time = $row["time"];
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