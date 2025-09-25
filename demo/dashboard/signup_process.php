<?php
include("function.php");

if(isset($_POST['submit']))
{
	$first_name=$_POST['first_name'];
	$last_name=$_POST['last_name'];
	$email=$_POST['email'];
	$role=$_POST['role'];
	$password=sha1($_POST['password']);
	create_user($first_name,$last_name,$email,$password,$role);

}
if(isset($_POST['edit_user']) && isset($_POST['id_u'])){
   $id=$_POST['id_u'];
$first_name=$_POST['first_name'];
	$last_name=$_POST['last_name'];
	$role=$_POST['role'];
	$password="";
	$p=$_POST['password'];
	if($_POST['password']!=""){
	  $password=", password='".sha1($p)."' ";
	}




            $sql="UPDATE user SET
name='$first_name',
lname='$last_name',
role='$role'".$password." WHERE id='$id'";
$query  =   mysqli_query($conn,$sql) or die($sql);
     echo "<script>window.location='user_list.php?edit_id=".$id."'</script>";
}
?>
