<?php
error_reporting(0); 
?> 
<?php
$msg = "";

$db = mysqli_connect("localhost", "root", "ePsgRnHHRK3V6A", "class3"); 
mysqli_set_charset($db, "utf8");

if (isset($_POST['upload'])) { 


 $path = "photo/";
            $profile_names = $_FILES['file']['name'];
            $profile_tem = $_FILES['file']['tmp_name'];
            $profile_error = $_FILES['file']['error'];
    
        if(strlen($profile_names)){
        list($txt, $ext) = explode(".", $profile_names);
                    $new_file_names = $profile_names.".".$ext;
    
                    move_uploaded_file($profile_tem,$path.$profile_names);
            $name = $path.$profile_names;

        $sql = "INSERT INTO photo (img) VALUES ('$name')"; 
         mysqli_query($db, $sql);

}
} 
$result = mysqli_query($db, "SELECT * FROM photo"); 

?> 

<!DOCTYPE html> 
<html> 
<head> 
<title>Image Upload</title> 
<link rel="stylesheet" type= "text/css" href ="style.css"/> 
<div id="content"> 

        <form method="POST" action="" enctype="multipart/form-data"> 
        <input type="file" name="file" value=""/> 
        <div> 
                <input type="submit" name="upload">UPLOAD</button> 
        </div> 
        </form> 
</div> 
</body> 
</html>