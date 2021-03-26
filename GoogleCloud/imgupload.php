<?php
if(isset($_POST['submit'])){
if(isset($_FILES['file'])){
    $err=array();
    $f_name=$_FILES['file']['name'];
    //echo $f_name;
    $size=$_FILES['file']['size'];
    $type=$_FILES['file']['type'];
    $file_tmp =$_FILES['file']['tmp_name'];
    echo $file_tmp;
    $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
    $allowed_ext= array('jpg','jpeg','png');
    if(in_array($file_ext,$allowed_ext)==FALSE){
        $err[]="extension not allowed";

    }
    if($size > 1000000){
        $err[]='size is greater than 1MB';
    }
    if(empty($err)==TRUE){
        //chmod('upload_image',755);
        echo $_FILES['file']['tmp_name'];
        $newname = dirname(__FILE__).'/upload_image/'.$f_name;
        move_uploaded_file($_FILES['file']['tmp_name'],$newname);
        echo 'success';
    }
    else{
        print_r($err);
    }
}
}

?>

<hr>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Upload your file here:<br>
    <input type="file" name="file" />
    <input type="submit" name="submit" value="upload"/>
</form>