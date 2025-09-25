<?php

include("db_connection.php");

if(isset($_POST['question_submit']))
{

$title = $_POST['title'];
$question = $_POST['question'];

   if($title){
				   foreach($title as $key => $preq){
					   if(strlen($preq) > 0 ){
						   $sql_pro="insert into `search` (`q_id`, `kewords`) values  ('{$question}','$title[$key]')";
						   $query  =   mysqli_query($conn,$sql_pro);
					   }    
					}
				}
// echo 123;

     echo "<script>window.location='list_key_search.php'</script>"; 

}


if(isset($_POST['edit_question_submit']))
{

if(isset($_POST['etitle'])) $etitle = $_POST['etitle']; else $etitle = false;
// $etitle = $_POST['etitle'];
$question = $_POST['question'];

   if($etitle){
				   foreach($etitle as $ekey => $preq){
					   if(strlen($preq) > 0 ){
						   $date=date('Y-m-d h:i:s');
						   $sql_pro="UPDATE `search` SET `kewords` = '$etitle[$ekey]' where s_id = $ekey ";
						   $query  =   mysqli_query($conn,$sql_pro) or die($sql_pro) ;
					   }    
					}
				}


$title = $_POST['title'];

   if($title){
				   foreach($title as $key => $preq){
					   if(strlen($preq) > 0 ){
						   $sql_pro="insert into `search` (`q_id`, `kewords`) values  ('{$question}','$title[$key]')";
						   $query  =   mysqli_query($conn,$sql_pro);
					   }    
					}
				}

     echo "<script>window.location='list_key_search.php'</script>";
    // echo 1232323;

}




 if(isset($_POST['del_keyword']))
{
    $id = $_POST['del_keyword'];
   $sql_pro="delete from `search` where s_id = $id ";
   $query  =   mysqli_query($conn,$sql_pro);
    //  echo "<script>window.location='list_key_search.php'</script>";
    // echo 1;

}
?>