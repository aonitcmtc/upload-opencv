<?php

$servername = "localhost";
$dbname = "class3";
$username = "root";
$password = "ePsgRnHHRK3V6A";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    $sql = "SELECT * FROM user ORDER BY id DESC";
    $find = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($find);
    $name = $row['user'];
    $pass = $row['password'];

if (isset($_POST['send'])) { 
 $userlogin = $_POST['user'];
 $passlogin = $_POST['pass'];
// echo $passlogin;

    if ($result = $conn->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $row_user = $row["user"];
            $row_pass = $row["password"];
            //echo $row_name;
            if($userlogin == $row_user && $passlogin == $row_pass ){
                header( "location: /editphoto.php" );
                exit(0);
            }else{
            echo "Username or Password ERROR!";
            }

        }
    }

}

?>
<!DOCTYPE html>
<html>
<head>
        <title>User_admin</title>

        <script language="javascript">

        function checknull(){
        var username = document.getElementById("user").value;
        var password = document.getElementById("pass").value;
        if( username == "" ){
                alert("กรอก Username");
        }
        else if( password == "" ){
                alert("กรอก Password");
        }
}

        </script>

</head>
<body>
<div style="margin:auto 30%">

<h2>User to Admin page</h2><br>

<form method="POST" action="" enctype="multipart/form-data"">

  <label for="user">User:</label><br>
  <input type="text" id="user" name="user" value=""><br>
  <label for="pass">Password:</label><br>
  <input type="password" id="pass" name="pass" value=""><br><br>
  <button onclick="checknull()" type="submit" name="send">SingIn</button>&nbsp;&nbsp;&nbsp;
<a href="/class3-dashboard.php">
  <button type="button" name="send">Back</button>
</a>
</form> 

</div>
</body>
</html>