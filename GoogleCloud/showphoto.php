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
$day_now = date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>ภาพล่าสุด อาคาร ทค.2 ชั้น3</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php
                $update = "SELECT id, img, date, time FROM photo ORDER BY id DESC";
                if($result = $conn->query($update)) {
                if($row = $result->fetch_assoc()){
                   $tdate = $row['date'];
                   $ttime = $row['time'];
                }}

                $photo = "SELECT id, img, date, time FROM photo ORDER BY id DESC LIMIT 5";
                if($result = $conn->query($photo)) {
                while($row = $result->fetch_assoc()){
                   $tdate = $row['date'];
                   $ttime = $row['time'];
                   $name = $row['img'];
                   $h = substr($name,0,2);

                   if($h == 11){ $name11 = $name; }
                   if($h == 12){ $name12 = $name; }
                   if($h == 21){ $name21 = $name; }
                   if($h == 22){ $name22 = $name; }
                   if($h == 31){ $name31 = $name; }

                }}
?>
</head>
<body>
<div class="jumbotron text-center">
  <h1>ภาพที่บันทึกล่าสุด อาคาร ทค.1 ชั้น3</h1>
  <p>Last updated:<?php echo "  ".$tdate." | ".$ttime;  ?></p> 
</div>
  
<div class="container">
  <div class="row" style="margin:10px auto; height:32px">
        <a href="/class3-dashboard.php">
        <button type="button" class="btn btn-outline-success">Back</button>
        </a>
  </div>
  <div class="row">
    <div class="col-sm-4">
      <h3>ห้อง 301/1</h3>
      <?php
      echo "
        <a href='photo/$name11' target='_blank' >
        <img src='photo/$name11' alt='view1' style='width:360px; height:280px;'>
        </a>
      ";
      ?>
    </div>
    <div class="col-sm-4">
      <h3>ห้อง 301/2</h3>
      <?php
      echo "
        <a href='photo/$name12' target='_blank' >
        <img src='photo/$name12' alt='view1' style='width:360px; height:280px;'>
        </a>
      ";
      ?>
    </div>
    <div class="col-sm-4">
      <h3>ห้อง 302/1</h3>
      <?php
      echo "
        <a href='photo/$name21' target='_blank' >
        <img src='photo/$name21' alt='view1' style='width:360px; height:280px;'>
        </a>
      ";
      ?>
    </div>
  </div>
  <div class="row justify-content-md-center" style="margin:50px auto;">
    <div class="col-sm-4">
      <h3>ห้อง 302/2</h3>
      <?php
      echo "
        <a href='photo/$name22' target='_blank' >
        <img src='photo/$name22' alt='view1' style='width:360px; height:280px;'>
        </a>
      ";
      ?>
    </div>
    <div class="col-sm-4">
      <h3>ระเบียง</h3>
      <?php
      echo "
        <a href='photo/$name31' target='_blank' >
        <img src='photo/$name31' alt='view1' style='width:360px; height:280px;'>
        </a>
      ";
      ?>
    </div>

  </div>
</div>

</body>
</html>