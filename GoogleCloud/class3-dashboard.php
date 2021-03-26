<?php

$servername = "localhost";
$dbname = "class3";
$username = "root";
$password = "ePsgRnHHRK3V6A";

$datec=0;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$day_now = date("Y-m-d");
error_reporting(~E_NOTICE);

$dayt= $_GET['day'];

$d= substr($dayt,0,2);
$m= substr($dayt,3,2);
$y= substr($dayt,6,4);

$dd= substr($dayt,13,2);
$mm= substr($dayt,16,2);
$yy= substr($dayt,19,4);

$day1 = $y.'-'.$d.'-'.$m;
$day2 = $yy.'-'.$dd.'-'.$mm;


?>

<style>

select {
    text-align: center;
    text-align-last: center;
    -moz-text-align-last: center;
}
</style>
<html>
  <head>
  <title>Class3 Dashboard</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
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
          ['date|time', 'จำนวนคนที่ตรวจพบ'],


        <?php
    
      $sql_list = $conn->query("SELECT id, sum, date, time FROM allview WHERE date BETWEEN '$day1' AND '$day2'");
      $numm = $sql_list->num_rows;
      if($numm){

        $sql = "SELECT id, sum, date, time FROM allview WHERE date BETWEEN '$day1' AND '$day2' ORDER BY id ";
    

      }else{
        $sql = "SELECT id, sum, date, time FROM allview  ORDER BY id DESC LIMIT 60";
      }

                 
                $last = "SELECT id, c1v1, c2v1, c3v1, c1v2, c2v2, c3v2, sum, date, time FROM allview ORDER BY id DESC";
                if ($result = $conn->query($last)) {
                if($row = $result->fetch_assoc()){
                   $lastview = $row['sum'];
                   $v1 = $row['c1v1'];
                   $v2 = $row['c2v1'];
                   $v3 = $row['c3v1'];
                   $v4 = $row['c1v2'];
                   $v5 = $row['c2v2'];
                   $v6 = $row['c3v2'];
                }}
                if ($result = $conn->query($sql)) {
                    $num = 0;
                  while($roww = $result->fetch_assoc()){
                     $num = $num + 1;
                     $date = $roww['date'];
                     $time = $roww['time'];
                     $all = $roww['sum'];
          ?>
    <?php if($date == $datec) { ?>
  
  
          ['<?php echo $date.' | '.$time;?>', <?php echo $all;?>]
    <?php }else{   $datec =  $date ; ?>
  
      ['<?php echo $date.' | '.$time;?>', <?php echo $all;?>]
  
      <?php }?>
    ,
          <?php
                  } } 
          ?>
  
          ]);
  
          var options = {
            title: 'จำนวน(คน)',
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
        <div class="row pt-3 text-white" style="height: 82px;">
           <div class="col-md-6 offset-md-3"">
                <h2 style="text-align:center;">Dashboard</h2>
        </div>
    </div>

        <div class="row" style="margin: 20px auto;">
                <div class="col-md-4" >
                <a href="/userphoto.php">
                <button style="margin:20px 120px;"type="button" class="btn btn-outline-danger">Admin</button>
                </a>
                </div>
                <div class="col-md-4" >
                        <div class="card bg-danger text-white">
                                <h2 class="card-title text-center">
                                        <div class="d-flex flex-wrap justify-content-center mt-2">
                                        <a><span class="badge hours"></span></a> :
                                        <a><span class="badge min"></span></a> :
                                        <a><span class="badge sec"></span></a>
                                        </div>
                                </h2>
                        </div>
                </div>
                <div class="col-md-4">
                <a href="/showphoto.php">
                <button style="margin:20px 120px;"type="button" class="btn btn-outline-danger">LIVE VIEW</button>
                </a>
                </div>
        </div>

        <div class="row" style="height: 256px; margin:auto;">

          <div class="col-md-4">

          </div>

          <div class="col-md-4">
            <div class="card text-center h-100 card-info bg-success">
                <div class="card-block" style="margin:24px auto;">
                    <h4 class="card-title">จำนวนบุคคลทั้งหมด</h4>
                    <h2><i class="fa fa-users fa-2x"></i></h2>
                </div>
                <div class="row p-2 no-gutters rounded">
                     <div class="col-md-6 offset-md-3">
                        <div class="card card-block text-danger rounded-0 border-left-0 border-right-0 border-top-0 border-bottom-0 bg-success">
                            <h3><?php echo $lastview  ?></h3>
                            <span class="small text-uppercase">Person</span>
                        </div>
                    </div>
                </div>
            </div>
          </div>

          <div class="col-md-4">

          </div>

        </div>

        <div class="row justify-content-md-center text-white" style="margin: 20px auto;">
                <h3>ตรวจพบในแต่ละห้อง</h3>
        </div>

        <div class="row" style="height: 256px; margin: 28px auto;">

         <div class="col-md-4">
            <div class="card text-center h-100 card-info bg-warning">
                <div class="card-block" style="margin:24px auto;">
                    <h4 class="card-title">Room 301</h4>
                    <h2><i class="fa fa-camera-retro fa-2x"></i></h2>
                </div>
                <div class="row p-2 no-gutters rounded">
                    <div class="col-6 rounded">
                        <div class="card card-block text-danger rounded-0 border-left-0 border-right-0 border-top-0 border-bottom-0 bg-warning">
                            <h3><?php echo $v1  ?></h3>
                            <span class="small text-uppercase">Person</span>
                            <span class="small text-uppercase">View 1</span>
                        </div>
                    </div>
                    <div class="col-6 rounded">
                        <div class="card card-block text-danger rounded-0 border-right-0 border-top-0 border-bottom-0 bg-warning">
                            <h3><?php echo $v4 ?></h3>
                            <span class="small text-uppercase">Person</span>
                            <span class="small text-uppercase">View 2</span>
                        </div>
                    </div>
                </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card text-center h-100 card-info bg-info">
                <div class="card-block" style="margin:24px auto;">
                    <h4 class="card-title">Room 302</h4>
                    <h2><i class="fa fa-camera-retro fa-2x"></i></h2>
                </div>
                <div class="row p-2 no-gutters rounded">
                    <div class="col-6 rounded">
                        <div class="card card-block text-danger rounded-0 border-left-0 border-right-0 border-top-0 border-bottom-0 bg-info">
                            <h3><?php echo $v2  ?></h3>
                            <span class="small text-uppercase">Person</span>
                            <span class="small text-uppercase">View 1</span>
                        </div>
                    </div>
                    <div class="col-6 rounded">
                        <div class="card card-block text-danger rounded-0 border-right-0 border-top-0 border-bottom-0 bg-info">
                            <h3><?php echo $v5 ?></h3>
                            <span class="small text-uppercase">Person</span>
                            <span class="small text-uppercase">View 2</span>
                        </div>
                    </div>
                </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card text-center h-100 card-info bg-primary">
                <div class="card-block" style="margin:24px auto;">
                    <h4 class="card-title">Outside</h4>
                    <h2><i class="fa fa-camera-retro fa-2x"></i></h2>
                </div>
                <div class="row p-2 no-gutters rounded">
                     <div class="col-md-6 offset-md-3">
                        <div class="card card-block text-danger rounded-0 border-left-0 border-right-0 border-top-0 border-bottom-0 bg-primary">
                            <h3><?php echo $v3  ?></h3>
                            <span class="small text-uppercase">Person</span>
                        </div>
                    </div>
                </div>
            </div>
          </div>

        </div>
       
        <div class="row justify-content-md-center text-white" style="margin: 20px auto;">
                <h4>เลือกข้อมูล</h4>
       </div>
       
        <div class="row justify-content-md-center" >
        <div class="form-group">
        <form>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                   
                    <input type="text" class="form-control float-right" id="reservation" name="day">
                    <button type="submit" class="btn btn-success" ><span class="glyphicon glyphicon-search" aria-hidden="true"></span> ค้นหา</button>
                   
                  </div>
                  <!-- /.input group -->
                </div>
                </form>
        </div>

        <div class="row justify-content-md-center text-white" style="margin:0">
                <h5>ตั้งแต่ <?php echo $day1." ถึง ".$day2;  ?></h5>
        </div>
      
        <div class="row justify-content-md-center text-white" style="margin: 20px auto;"> 
                <h3>กราฟแสดงจำนวนบุคคลที่ระบบตรวจพบ</h3>
        </div>

        <br>
      <!-- grap humidity & temperature -->
      <div class="col-12 col-md-12" id="curve_chart" style="width: 1720px; height: 580px"></div>
    <!-- </div> -->


        <div class="row justify-content-md-center" style="margin: 20px auto;">

        <?php
        $tb = "SELECT id, c1v1, c2v1, c3v1, c1v2, c2v2, c3v2, sum, date, time FROM allview WHERE date BETWEEN '$day1' AND '$day2' ORDER BY id DESC";

        echo '<h2 style="color:white;">ตารางแสดงการตรวจจับของระบบ</h2><br>';
        echo '<table class="table table-dark">
      <tr> 
      <th>#</td> 
      <th>Date</td> 
      <th>Time</td> 
      <th>Room 301/1</td> 
      <th>Room 301/2</td>
      <th>Room 302/1</td> 
      <th>Room 302/2</td> 
      <th>Out Side</td> 
      <th>All View</td>
    </tr>';
    $num = 0 ;
  if ($result = $conn->query($tb)) {
      while ($row = $result->fetch_assoc()) {
          $row_id = $row["id"];
          $row_date = $row["date"];
          $row_time = $row["time"];
          $row_v11 = $row["c1v1"];
          $row_v22 = $row["c1v2"]; 
          $row_v33 = $row["c2v1"]; 
          $row_v44 = $row["c2v2"];
          $row_v55 = $row["c3v1"];
          $row_sum = $row["sum"];
          $num = $num + 1;
          echo '<tr> 
              <td>' . $num . '</td> 
              <td>' . $row_date . '</td> 
              <td>' . $row_time . '</td> 
              <td>' . $row_v11 . '</td> 
              <td>' . $row_v22 . '</td>
              <td>' . $row_v33 . '</td> 
              <td>' . $row_v44 . '</td>
              <td>' . $row_v55 . '</td>
              <td>' . $row_sum . '</td>  
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
<script src="plugins/jquery/jquery.min.js"></script>

<script src="plugins/select2/js/select2.full.min.js"></script>

<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>


<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
    }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>


  </body>
</html>