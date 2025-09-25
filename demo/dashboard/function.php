<?php
include ("db_connection.php");




        
function create_user($first_name,$last_name,$email,$password,$role)
{   
   $user = $_SESSION['u_id'];
	global $conn;
	$date=date("Y-m-d");
	$query="INSERT INTO user(name,created_by,lname,email,password,role,active)VALUES('".$first_name."','".$user."','".$last_name."','".$email."','".$password."','".$role."','1')";
		$result=mysqli_query($conn,$query);
		if($result)
		{
			header("location:admin_dashboard.php");
		}
		else
		{
			echo "not created";
		}

}


function show_reply()
{
	global $conn;
	?>

	  <select style="color:black" id="messages" class="form-control" name="messages">
	  	<?php
	  	$query="SELECT * from replies ";
		$result=mysqli_query($conn,$query);
		if($result->num_rows>0)
		{
			 ?><option value="act" >Show Messages</option><?php
			while($row=mysqli_fetch_assoc($result))
			{

	  	?>

                            <option value="<?php echo $row['id']?>" ><?php if($row['parent']!=null){ echo $row['parent'].'=>';}else{echo '
                            Null';}?><?php echo $row['message']?>=><?php echo $row['reply']?></option>
                                  
                      
                        <?php
                    }
                      ?></select>
                      <?php
                }



	}

	function view_data($table,$id=null)
{
	global $conn;
	if($id==null)
	{
	$query="SELECT * from $table order by parent asc";
	$result=mysqli_query($conn,$query);
	return $result;
}
else
{
	$query="SELECT * from $table WHERE id='$id'";
	$result=mysqli_query($conn,$query);
	return $result;

}

}


function show_questions()
{
	global $conn;
	?>

	 
	  	
	  	<?php
	  	$query="SELECT * from questions order by parent";
		$result=mysqli_query($conn,$query);
	
			 ?>
			 <?php
			while($row=mysqli_fetch_assoc($result))
			{
				$parent=$row['parent'];

	  	?>

                            <option value="<?php echo $row['id']?>" ><?php
							 if($row['parent']=='0')
							 { echo $row['title']; }
							 elseif($row['parent']!='0')
							 {

		$query2="SELECT * from questions WHERE id='$parent'";
		$result2=mysqli_query($conn,$query2);
		if($result2->num_rows)
		{
			
		$row2=mysqli_fetch_assoc($result2);
		$parent2=$row2['parent'];	
		$query3="SELECT * from questions WHERE id='$parent2'";
		$result3=mysqli_query($conn,$query3);
		if($result3->num_rows)
		{
		$row3=mysqli_fetch_assoc($result3);
		$parent3=$row3['parent'];

		$query4="SELECT * from questions WHERE id='$parent3'";
		$result4=mysqli_query($conn,$query4);
		if($result4->num_rows)
		{
			$row4=mysqli_fetch_assoc($result4);
			$parent4=$row4['parent'];

		$query5="SELECT * from questions WHERE id='$parent4'";
		$result5=mysqli_query($conn,$query5);
		if($result5->num_rows)
		{
			$row5=mysqli_fetch_assoc($result5);
			$parent5=$row5['parent'];

			$query6="SELECT * from questions WHERE id='$parent5'";
		$result6=mysqli_query($conn,$query6);
		if($result6->num_rows)
		{
			$row6=mysqli_fetch_assoc($result6);
			echo  $row6['title'].'=>'.$row5['title'].'=>'.$row4['title'].'=>'.$row3['title'].'=>'.$row2['title'] .'=>'.$row['title'];


		}
		else{
			echo  $row5['title'].'=>'.$row4['title'].'=>'.$row3['title'].'=>'.$row2['title'] .'=>'.$row['title'];
		}

		}
		else
		{
			echo $row4['title'].'=>'.$row3['title'].'=>'.$row2['title'] .'=>'.$row['title'];
		}
		}
		else{

		echo $row3['title'].'=>'.$row2['title'] .'=>'.$row['title'];
		}
		}
		else{
		echo $row2['title'] .'=>'.$row['title'];
		}
						
		} 
							} 
							  ?></option>
                                  
                      
                        <?php
                    }
                      ?></select>
                      <?php
                // }



	}


function show_parent()
{
	global $conn;
	?>

	 
	  	
	  	<?php
	  	$query="SELECT * from questions";
		$result=mysqli_query($conn,$query);
	
			 ?>
			 <?php
			while($row=mysqli_fetch_assoc($result))
			{
				$parent=$row['parent'];

	  	?>

                            <option value="<?php echo $row['id']?>" ><?php
							 echo $row['title']
							?></option>
                                  
                      
                        <?php
                    }
                      ?>
                      <?php
                // }



	}

?>