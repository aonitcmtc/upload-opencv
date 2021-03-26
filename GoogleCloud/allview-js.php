<!DOCTYPE html>
<html><body>
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

$sql = "SELECT id, c1v1, c2v1, c3v1, c1v2, c2v2, c3v2, sum, date, time FROM allview ORDER BY id DESC";
$array = array();
$name = array();

if ($result = $conn->query($sql)) {
    if ($row = $result->fetch_assoc()) {
       // $name['id'] = $row["id"];
       // $name['view1'] = $row["c1v1"];
       // $name['view2'] = $row["c2v1"];
       // $name['view3'] = $row["c3v1"];
       // $name['view4'] = $row["c1v2"];
       // $name['view5'] = $row["c2v2"]; 
       // $name['view6'] = $row["c3v2"]; 
        $name['sum1'] = (int)$row["sum"]; 
       // $name['date'] = $row["date"];
       // $name['time'] = $row["time"];

        $date_now = (string)date("Y-m-d") ;
        $time_now = (string)date("H:i") ;
        $tr = substr($row["time"], 0, 5); // returns "abcdef"
        $tw = substr($row["time"], 3, -3)+1; // returns "abcdef"
        $nm = substr($time_now, 3, 4);
        //echo $nm,"|",$time_now;
        if($tr < 10){
          if($date_now == $row["date"] && $tr == $time_now || $tw == $nm){
              $name['last1'] = 1;
          }
          else{
              $name['last1'] = 0;
          }
        }
        else{
          if($date_now == $row["date"] && $tr == $time_now || $tw == $nm){
              $name['last1'] = 1;
          }
          else{
              $name['last1'] = 0;
          }
        array_push($array,$name);
        }
                // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));
        $myJson = json_encode($array);
        echo $myJson;

        //$obj = json_decode($myJson);
        //echo $obj->{'last'};
        //$x = $obj->{'last'};
        //echo '+++ : '.$x; 
        // 12345
        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 4 hours
    }

    $result->free();
}

$conn->close();
?> 
</table>
</body>
</html>