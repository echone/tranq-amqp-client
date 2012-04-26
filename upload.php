<?php
include("function.php");
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $file = pathinfo($_FILES['file']['name']);
    list($path, $url) = explode(' ', urldecode($_POST['PRESENZA'].$_POST['EDIPA'].$_POST['MOI'].$_POST['SCO']));
    $path = $path.'.'.$file['extension'];
    if(file_exists($url)){
    	move_uploaded_file($_FILES['file']['tmp_name'], "$url/$path");
    } else {
    	mkdir("$url", 0755, true);
    	move_uploaded_file($_FILES['file']['tmp_name'], "$url/$path");
    }
$text=$path.' '.$url;
 $i=rand(0,3);
 if($i<2){
 	$exchange='ffmpeg_exchange1';
 } else {
 	$exchange='ffmpeg_exchange2';
 }
   sender($text, 'encode.key', $exchange, '127.0.0.1');
}

?>
