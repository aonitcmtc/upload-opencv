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

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['date', 'Hummidity', 'Temp'],


        <?php
                $sql = "SELECT id, date,time, hummidity, tempC ,tempF FROM tree ORDER BY id DESC LIMIT 100";
                $last = "SELECT id, hummidity, tempC ,tempF ,sensor FROM tree ORDER BY id DESC";
                if ($result = $conn->query($last)) {
                if($row = $result->fetch_assoc()){
                   $status = $row['sensor'];
                   $f = $row['tempF'];
                   $c = $row['tempC'];
                   $h = $row['hummidity'];
                   $TC = floatval($c);
                   $TF = floatval($f);
                   $humm = floatval($h);
                }}
                if ($result = $conn->query($sql)) {
                    while($row = $result->fetch_assoc()){
                       $date = $row['date'];
                       $time = $row['time'];
                       $tempf = $row['tempF'];
                       $tempc = $row['tempC'];
                       $humi = $row['hummidity'];
                       $temp = floatval($tempc);
                       $fa = floatval($tempf);
                       $hum = floatval($humi);
    
            ?>
            ['<?php echo $date,'|',$time;?>', <?php echo $hum;?> , <?php echo $temp;?>],
            <?php
                    } }
            ?>
    
            ]);
    
            var options = {
              title: 'Baby Tree',
              curveType: 'function',
              legend: { position: 'bottom' }
            };
    
            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
    
            chart.draw(data, options);
          }
        </script>
</head>
  <body>
    <div class="container bg-dark">
        <div class="row pt-3" style="height: 82px;">
           <div class="col-md-6 offset-md-3"">
                <h2 style="text-align:center; color:#BDB9B9;">Dashboard</h2>
           </div>
        </div>

        <div class="row" style="height: 280px;">

         <div class="col-md-4">
            <div class="card text-center h-100 card-info bg-warning">
                <div class="card-block">
                    <h4 class="card-title">Temperature</h4>
                    <h2><i class="fa fa-thermometer-full fa-3x"></i></h2>
                </div>
                <div class="row p-2 no-gutters rounded">
                    <div class="col-6 rounded">
                        <div class="card card-block text-danger rounded-0 border-left-0 border-right-0 border-top-0 border-bottom-0 bg-warning">
                            <h3><?php echo $TC  ?></h3>
                            <span class="small text-uppercase">Celsius</span>
                        </div>
                    </div>
                    <div class="col-6 rounded">
                        <div class="card card-block text-danger rounded-0 border-right-0 border-top-0 border-bottom-0 bg-warning">
                            <h3><?php echo $TF ?></h3>
                            <span class="small text-uppercase">Fahrenheit</span>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card text-center h-100 card-info bg-primary">
                <div class="card-block">
                    <h4 class="card-title">Hummidity</h4>
                    <h2><i class="fa fa-snowflake fa-3x"></i></h2>
                </div>
                <div class="row p-2 no-gutters rounded">
                     <div class="col-md-6 offset-md-3">
                        <div class="card card-block text-danger rounded-0 border-left-0 border-right-0 border-top-0 border-bottom-0 bg-primary">
                            <h3><?php echo $humm  ?></h3>
                            <span class="small text-uppercase">Percent</span>
                        </div>
                    </div>
                </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card text-center h-100 card-info bg-success">
                <div class="card-block">
                    <h4 class="card-title">Status</h4>
                    <h2><i class="fa fa-plug fa-3x"></i></h2>
                </div>
                <div class="row p-2 no-gutters rounded">
                     <div class="col-md-6 offset-md-3"">
                        <div class="card card-block text-danger rounded-0 border-left-0 border-right-0 border-top-0 border-bottom-0 bg-success">
                            <h3><?php echo $status  ?></h3>
                        </div>
                    </div>
                </div>
            </div>
          </div>

        <!-- Div Row -->
        </div>

        <div class="row justify-content-md-center" style="margin: 20px auto;">
             <div class="col-md-4">
                  <div class="card text-white">
                       <div class="bg-danger text-center">
                            <h2 class="d-flex flex-wrap justify-content-center mt-2">
                                 <a><span class="badge hours"></span></a> :
                                 <a><span class="badge min"></span></a> :
                                 <a><span class="badge sec"></span></a>
                            </h2>
                       </div>
                  </div>
             </div>
        </div>
              <!-- grap humidity & temperature -->
              <div class="col-md-8 offset-md-2" id="curve_chart" style="width: 720px; height: 480px"></div>

<div class="row" style="margin: 20px auto;">

<?php
$tb = "SELECT id, date, time, hummidity, tempC ,tempF ,sensor FROM tree ORDER BY id DESC LIMIT 50";

echo '<h2 style="text-align: center; color:white;">Table data  </h2><br>';
echo '<table class="table table-dark">
<tr> 
<th>#</td> 
<th>Date</td> 
<th>Time</td> 
<th>Hummidity</td> 
<th>TempC</td>
<th>TempF</td> 
<th>Status</td> 
</tr>';
$num = 0 ;
if ($result = $conn->query($tb)) {
while ($row = $result->fetch_assoc()) {
    $row_id = $row["id"];
    $row_date = $row["date"];
    $row_time = $row["time"];
    $row_hum = $row["hummidity"];
    $row_tempC = $row["tempC"]; 
    $row_tempF = $row["tempF"]; 
    $row_sensor = $row["sensor"];
    $num = $num + 1;
    echo '<tr> 
        <td>' . $num . '</td> 
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


</div>

</div>
<script>
    $(document).ready(function() {
        setInterval( function() {
        var hours = new Date().getHours();
            $(".hours").html(( hours < 10 ? "0" : "" ) + hours);
        }, 1000);
        setInterval( function() {
        var minutes = new Date().getMinutes();
            $(".min").html(( minutes < 10 ? "0" : "" ) + minutes);
        },1000);
        setInterval( function() {
        var seconds = new Date().getSeconds();
            $(".sec").html(( seconds < 10 ? "0" : "" ) + seconds);
        },1000);
    });
    </script>


  </body>
</html>