<?php
session_start();
include ("db_connection.php");
if(isset($_SESSION['user']))
{
    echo $_SESSION['login_id'];
$update2="UPDATE `Login_activity` SET `endtime` = CURRENT_TIMESTAMP() WHERE `id`='{$_SESSION['login_id']}'";
$result_accinfo_sql = mysqli_query($conn, $update2);


	session_destroy();
	header("location:login.php");
}
else
{
header("location:login.php");
}




?>