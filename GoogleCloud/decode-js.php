<?php

$x = '{"Peter":"65","Harry":80,"John":78,"Clark":90}';
$obj = json_decode($x);
echo $x.'<br>';

$url="35.187.244.60/test1.php";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
$json = curl_exec($ch);
curl_close($ch); 
echo $json.'<br>';


echo 'Decoder : ';
$dec = json_decode($json);
echo $dec->last;

?>