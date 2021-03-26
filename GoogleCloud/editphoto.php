<!DOCTYPE html>
<html><body>
<div style="margin:auto 20%">
<?php

$servername = "localhost";
$dbname = "class3";
$username = "root";
$password = "ePsgRnHHRK3V6A";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//$sql = "SELECT id, date, time, hummidity, tempC, tempF, reading_time FROM SensorData ORDER BY id DESC";
$sql = "SELECT id, img, date, time FROM photo ORDER BY id";

echo '<h2 align="center">จัดการรูปภาพ</h2><br>';
echo '<center><a href="/class3-dashboard.php"><button type="button">Dashboard</button></a></center>';
echo '<table border="0" align="center" cellspacing="5" cellpadding="5">
      <tr> 
        <th>ID</th> 
        <th>Date</th> 
        <th>Time</th> 
        <th>Name</th> 
        <th>Photo</th> 
        <th>Edit</th> 
      </tr>';
$number = 0; 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_id = $row["id"];
        $row_date = $row["date"];
        $row_time = $row["time"];
        $row_img = $row["img"];
        $number++;
        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));
      
        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 4 hours"));
      
        echo '
             <tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_date . '</td> 
                <td>' . $row_time . '</td> 
                <td>' . $row_img . '</td> 
                <td><a href="photo/'.$row_img.'" target="_blank" ><img src="photo/'.$row_img.'" alt="'.$row_img.'" width="100" height="100"></a></td> 
                <td><a href="/deletephoto.php?id='.$row_id.'"><button type="button">DELETE</button></a></td> 
             </tr>';
    }
    echo "รูปทั้งหมด ".$number;
    $result->free();
}

$conn->close();
?> 
</table>
</div>
</body>
</html>