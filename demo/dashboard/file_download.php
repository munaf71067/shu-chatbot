<?php

if(isset($_GET['file_name']))
{
$file_path = $_GET['file_name'];
$file_set = explode("/",$_GET['file_name']);
 $file_name=array_pop($file_set);


	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file_path));
	readfile($file_path);
	

}





?>