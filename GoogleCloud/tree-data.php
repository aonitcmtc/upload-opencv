<!DOCTYPE html>
<html><body>
<?php
/*
  Rui Santos
  Complete project details at https://RandomNerdTutorials.com/esp32-esp8266-mysql-database-php/
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
*/

$servername = "localhost";
// REPLACE with your Database name
$dbname = "Embedded";
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

//$sql = "SELECT id, date, time, hummidity, tempC, tempF, reading_time FROM SensorData ORDER BY id DESC";
$sql = "SELECT id, date, time, hummidity, tempC, tempF, sensor FROM tree ORDER BY id DESC";

echo '<h2 align="center">Table</h2><br>';
echo '<table align="center" cellspacing="5" cellpadding="5">
      <tr> 
        <td>ID</td> 
        <td>Date</td> 
        <td>Time</td> 
        <td>Hummidity</td> 
        <td>TempC</td>
        <td>TempF</td> 
        <td>Sensor</td> 
      </tr>';
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_id = $row["id"];
        $row_date = $row["date"];
        $row_time = $row["time"];
        $row_hum = $row["hummidity"];
        $row_tempC = $row["tempC"]; 
        $row_tempF = $row["tempF"]; 
        $row_sensor = $row["sensor"];
        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));
      
        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 4 hours"));
      
        echo '<tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_date . '</td> 
                <td>' . $row_time . '</td> 
                <td>' . $row_hum . '</td> 
                <td>' . $row_tempC . '</td>
                <td>' . $row_tempF . '</td> 
                <td>' . $row_sensor . '</td> 
              </tr>';
    }
    $result->free();
}

$conn->close();
?> 
</table>
</body>
</html>