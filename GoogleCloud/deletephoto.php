<?php
 $id = $_GET["id"];
 echo "DELETE_ID :".$id;

$servername = "localhost";
$dbname = "class3";
$username = "root";
$password = "ePsgRnHHRK3V6A";


$db = mysqli_connect($servername, $username, $password, $dbname); 
mysqli_set_charset($db, "utf8");

    $find = "SELECT * FROM photo WHERE id = $id";
    $s_name = mysqli_query($db, $find);
    $row = mysqli_fetch_assoc($s_name);
    $name = $row['img'];

    unlink("photo/".$name);
    echo "<br>name: ".$name."<br>";

    $sql = "DELETE FROM photo WHERE id = $id";
    $result = mysqli_query($db, $sql);


    if($result){
        header("location:editphoto.php");
        exit(0);
    }else{
        echo "No Update and error".mysqli_error($db);
    }
?>