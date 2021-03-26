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

$sql = "SELECT id, c1v1, c2v1, c3v1, c1v2, c2v2, c3v2, sum, date, time FROM allview ORDER BY id DESC";

echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <td>ID</td> 
        <td>View1</td>
        <td>View2</td>
        <td>View3</td> 
        <td>View4</td> 
        <td>View5</td> 
        <td>View6</td> 
        <td>All_view</td>
        <td>Date</td>  
        <td>Time</td> 
      </tr>';
 
if ($result = $conn->query($sql)) {
        while ($row = $result->fetch_assoc()) {
        $row_id = $row["id"];
        $row_v1 = $row["c1v1"];
        $row_v2 = $row["c2v1"];
        $row_v3 = $row["c3v1"];
        $row_v4 = $row["c1v2"];
        $row_v5 = $row["c2v2"]; 
        $row_v6 = $row["c3v2"]; 
        $row_sum = $row["sum"]; 
        $row_date = $row["date"];
        $row_time = $row["time"];
        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));
      
        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 4 hours"));
      
        echo '<tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_v1 . '</td> 
                <td>' . $row_v2 . '</td>
                <td>' . $row_v3 . '</td>
                <td>' . $row_v4 . '</td> 
                <td>' . $row_v5 . '</td> 
                <td>' . $row_v6 . '</td>  
                <td>' . $row_sum . '</td> 
                <td>' . $row_date . '</td> 
                <td>' . $row_time . '</td> 
              </tr>';
    }

    $result->free();
}

$conn->close();
?> 
</table>
</body>
</html>