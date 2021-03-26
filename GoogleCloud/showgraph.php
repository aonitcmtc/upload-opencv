<?php

$servername = "localhost";
$dbname = "Embedded";
$username = "root";
$password = "ePsgRnHHRK3V6A";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>

<html>
  <head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['date', 'Hummidity', 'Temp'],


        <?php
                $sql = "SELECT id, date,time, hummidity, tempC FROM tree ORDER BY id ASC";
                if ($result = $conn->query($sql)) {
                while($row = $result->fetch_assoc()){
                   $date = $row['date'];
                   $time = $row['time'];
                   $tempc = $row['tempC'];
                   $humi = $row['hummidity'];
                   $temp = floatval($tempc);
                   $hum = floatval($humi);

        ?>
        ['<?php echo $date,'|',$time;?>', <?php echo $hum;?> , <?php echo $temp;?>],
        <?php
                } }
        ?>

        ]);

        var options = {
          title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
   <center>
    <div class="col align-self-center" id="curve_chart" style="width: 1440px; height: 720px"></div>

    <div style="width: 300px; border: 8px outset red;  text-align: center;" ">
    <?php
    $date = date(" Y-m-d ") ;
    $time = date(" H:i:s ") ;
    echo "Date " . $date;
    echo $time . "<br>" ;
    //echo "Date" . date(" Y-m-d ") . "<br>";
    //echo "Time" . date(" H:i:s ") . "<br>";
    ?>
   </div>

  </center>
  </body>
</html>