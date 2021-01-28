<!DOCTYPE html>
<html>
<head>
	<title>Class3 Detec_person</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
<!-- Top  -->
<div class="jumbotron bg-dark text-white" height="320" >
  <h1 class="text-center" >Project Object Detection At Class3 Computer engineering</h1>
  <p>Study in Rajamangala University of Technology Lanna </p>
  <!-- Show time -->
  <div class="col-md-3">
    <div class="card bg-secondary text-white">
    <h3 class="card-title text-center">
      <div class="d-flex flex-wrap justify-content-center mt-2">
        <a><span class="badge hours"></span></a> :
        <a><span class="badge min"></span></a> :
        <a><span class="badge sec"></span></a>
      </div>
    </h3>
    </div>
  </div>
</div>

<div class="container text-center ">
  <div class="row">
    <div class="col-sm-6">
      <h3>Camera1</h3>
      <video controls class="rounded"" width="540" height="380" src="http://192.168.13.112:30002/videostream.cgi?rate=0&user=admin&pwd=605232060"></video>
    </div>
    <div class="col-sm-6">
      <h3>Camera2</h3>
      <img class="rounded"" width="540" height="380" src="http://192.168.13.112:30002/videostream.cgi?rate=0&user=admin&pwd=605232060">
    </div>
  </div>
  <div class="row" style="margin-top: 20px;">
    <div class="col-md-6 offset-md-3">
      <h3>Camera3</h3>
      <img class="rounded"" width="540" height="380" src="http://192.168.13.112:30002/videostream.cgi?rate=0&user=admin&pwd=605232060">
    </div>
  </div>

  <div class="row" style="margin-top: 20px;">
    <div class="col-md-2">
      <h3>Last</h3>
      <p>Last a Picture</p>
    </div>
  </div>
  <div class="row style=" style="margin-bottom: 80px;">
    <div class="col-sm-4">
      <img src="img/detec.png" class="rounded" width="352" height="248">
    </div>
    <div class="col-sm-4">
      <img src="img/detec.png" class="rounded" width="352" height="248">
    </div>
    <div class="col-sm-4">
      <img src="img/detec.png" class="rounded" width="352" height="248">
    </div>
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
});</script>


</body>
</html>
