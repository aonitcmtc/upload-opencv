<?php
error_reporting(0); 
?> 
<?php
$msg = ""; 
$db = mysqli_connect("localhost", "root", "ePsgRnHHRK3V6A", "class3");

$check = "SELECT * FROM photo ORDER BY id DESC";
if ($result = $db->query($check)) {
    while ($row = $result->fetch_assoc()) {
$num++;
    }
    echo $num;
}
// If upload button is clicked ...
// if (isset($_POST['upload']))  
if ($_SERVER["REQUEST_METHOD"] == "POST"){ 

    $date = date(" Y-m-d ") ;
    $time = date(" H:i:s ") ;

        $filename = $_FILES["uploadfile"]["name"]; 
        $tempname = $_FILES["uploadfile"]["tmp_name"];   
                $path = "photo/".$filename; 

                $sql = "INSERT INTO photo (img,date,time) VALUES ('$filename','$date','$time')"; 

                // Execute query
                if($filename != ""){ 
                mysqli_query($db, $sql); 
                }
                // Now let's move the uploaded image into the folder: image 
                //if(strlen($filename)){
                //    $new_name = $filename.".".$ext;
                //    move_uploaded_file($tempname,$path);
                //}
                if (move_uploaded_file($tempname, $path)) { 
                        $msg = "Image uploaded successfully"; 
                }else{ 
                        $msg = "Failed to upload image"; 
                }


//check img <= 1000 picture
$all = "SELECT * FROM photo ORDER BY id DESC";
$num = 0;
if ($result = $db->query($all)) {
    while ($row = $result->fetch_assoc()) {
$num++;

if( $num > 1000 ){
    $name = $row['img'];
    $delete_id = $row['id'];
    //echo $name;

    unlink("photo/".$name);
    echo "<br>name: ".$name."<br>";

    $sql = "DELETE FROM photo WHERE id = $delete_id";
    $result = mysqli_query($db, $sql);
}
//echo $num.'<br>';
    }
}
//========end=========

        echo $msg." : ".$tempname." + ".$filename;
} 
//$result = mysqli_query($db, "SELECT * FROM photo"); 
?> 