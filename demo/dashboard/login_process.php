<?php
session_start();
include ("db_connection.php");

if(isset($_POST['login']))
{

$email=$_POST['email'];
$password=sha1($_POST['password']);
$query="SELECT * from user WHERE email='$email'AND password='$password' And active = 1";
$result=mysqli_query($conn,$query);
if($result->num_rows>0){
$row=mysqli_fetch_assoc($result);

$insert_d="INSERT INTO `login_activity`(`u_id`) VALUES ('{$row['id']}')";
$result_accinfo_sql = mysqli_query($conn, $insert_d);
    $_SESSION['login_id'] = mysqli_insert_id($conn);
	$_SESSION['user']=$row; 
	$_SESSION['u_id']=$row['id'];
	$_SESSION['role']=$row['role'];
	$_SESSION['name']=$row['name']." ".$row['lname'];
	$user_id=$_SESSION['user']['id'];
	header("location:index.php");
}
else{
$_SESSION['msg'] = "Invalid user";
header("location:login.php");


}

}



?>
