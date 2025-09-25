<?php
require_once 'db_connection.php';
if(isset($_POST['pdf_id']))
{
     $id=$_POST['pdf_id'];
     $query="SELECT * from questions WHERE id='$id'";
     $result=mysqli_query($conn,$query);
     $row=mysqli_fetch_assoc($result);
       $old_pdf=$row['pdf_file'];
       $old_pdf_arr = explode('questions/', $old_pdf);
       $older_pdf=array_pop($old_pdf_arr);
        unlink($older_pdf);
    $query2="UPDATE questions SET pdf_file='' WHERE id='$id'";
    $result2=mysqli_query($conn,$query2);
    if($result2)
    {
        echo "Deleted Successfully";
    }
    
    }

    if(isset($_POST['image_id']))
{
     $id=$_POST['image_id'];
     $query="SELECT * from questions WHERE id='$id'";
     $result=mysqli_query($conn,$query);
     $row=mysqli_fetch_assoc($result);
       $old_image=$row['image'];
       $old_img_arr = explode('questions/', $old_image);
       $older_img=array_pop($old_img_arr);
        unlink($older_img);
    $query="UPDATE questions SET image='' WHERE id='$id'";
    $result=mysqli_query($conn,$query);
    if($result)
    {
        echo "Deleted Successfully";
    }

    
    }
    if(isset($_POST['email']) && $_POST['table']=="user" )
{
     $id=$_POST['email'];
     $query="SELECT * from user WHERE email='$id'";
     $result=mysqli_query($conn,$query);
     $row=mysqli_fetch_assoc($result);
     if($row>0){
         echo 1;
     }
     
        
    
    
    }
 
if(isset($_POST['show_q'])=="show_q" && isset($_POST['id'])>0 ){
    $id = $_POST['id'];
      $query="SELECT * FROM `questions` WHERE id =$id";
		$result=mysqli_query($conn,$query);
		while($row=mysqli_fetch_assoc($result))
		{
		    echo $row["questions"];
		}
		
    
}
if(isset($_GET['delete_id']) && isset($_GET['table'])=="user" ){
    $id = $_GET['delete_id'];
     $query="delete FROM `user` WHERE id =$id";
		$result=mysqli_query($conn,$query);
// 		$_Session["msg"] = "Deleted Successfully";
 if($result)
    {
        echo "Deleted Successfully";
    }
    // echo "23";
}

?>