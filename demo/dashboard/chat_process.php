
<?php
session_start();
include 'db_connection.php';


   if(isset($_POST['ta_id']) && $_POST['table']== "req_to_agent_r"){
    $u_id=$_SESSION['u_id'];
    $ta_id=$_POST['ta_id'];
    $r_id=$_POST['ra_id'];
	$update1="UPDATE `req_to_agent` SET `u_id`='0',`status`='0',`mode`='0' WHERE `ra_id`='{$r_id}'";
	$result=mysqli_query($conn, $update1);
	
		    
	$update2="UPDATE `transfer_to` SET `status`='2' WHERE `ta_id`='{$ta_id}'";
	$result=mysqli_query($conn, $update2);
	
	
    echo "Recjected successfully";

} 

if(isset($_POST['ara_id']) && $_POST['table'] == "req_to_agent_a") {
  $u_id = $_SESSION['u_id'];
  $r_id = $_POST['ara_id'];
  $update1 = "UPDATE `req_to_agent` SET `u_id`='{$u_id}', `status`='1', `mode`='1' WHERE `ra_id`='{$r_id}'";
  $result = mysqli_query($conn, $update1);
  $_SESSION['request_id'] = $r_id;
  $query = "SELECT name, phone_no FROM req_to_agent WHERE ra_id = '{$r_id}'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $phone = $row['phone_no'];
    $_SESSION['phone_no'] = $phone;
  echo json_encode(['status' => 200, 'message' => "Accepted successfully", 'request_id' => $r_id, 'name' => $name, 'phone_no' => $phone]);
  // exit;
}




//    if(isset($_POST['ara_id']) && $_POST['table']== "req_to_agent_a"){
//     $u_id=$_SESSION['u_id'];
//     $r_id=$_POST['ara_id'];
// 	$update1="UPDATE `req_to_agent` SET `u_id`='{$u_id}',`status`='1',`mode`='1'WHERE `ra_id`='{$r_id}'";
// 	$result=mysqli_query($conn, $update1);
// 	$_SESSION['request_id']=$r_id;
//     echo "Accepted successfully";

// }

  if(isset($_POST['cra_id']) && $_POST['table']== "close_chat"){
   $r_id=$_POST['cra_id'];
	$update1="UPDATE `req_to_agent` SET `mode`='2' WHERE `ra_id`='{$r_id}'";
	$result=mysqli_query($conn, $update1);
	$query="SELECT * from req_to_agent WHERE `ra_id`='{$r_id}'";
		$result=mysqli_query($conn,$query);
		if($result->num_rows>0)
		{

	$row=mysqli_fetch_assoc($result);
		    
	$update2="UPDATE `testtbl` SET `agent_mod`='0' WHERE `id`='{$row['t_id']}'";
	$result=mysqli_query($conn, $update2);
		}
	unset($_SESSION['request_id']);

    echo "Close successfully"; 

}

  if(isset($_POST['table']) && $_POST['table']== "load_req"){
  
        $query="SELECT *,(select concat(name,' ',lname) from user where id = u_id) as uname FROM `req_to_agent`  WHERE   mode != 2 ORDER BY ra_id DESC";
		$result=mysqli_query($conn,$query);
		if($result->num_rows)
		{
		while($row=mysqli_fetch_assoc($result))
		{
		   
		 ?>
                    
                       <tr>
    <td style="color: ; font-weight: 600;" > <?php echo $row['name'];?></td>
    <td style="color: ; font-weight: 600;"> <?php echo $row['phone_no'];?></td>
    <td style="color: ; font-weight: 600;"> <?php if($row['u_id']==""|| $row['u_id']=="0"){echo '<button onclick="accept( '.$row['ra_id'].')" style="font-size: smaller;"class="btn btn-success  btn-pulse">Accept</button>'; }else{ echo  $row['uname'];}?> </td>
  </tr>
                    <?php 

		
		} 
	} 
}

if(isset($_POST['table']) && $_POST['table']== "queue_data"){
  
        // $query="SELECT DISTINCT *,(select name from conversations where sender = sender order by created_at desc) as name FROM `testtbl` WHERE chat_mode = 'on' ";
        $query="SELECT * ,(select name from conversations where conversations.sender = testtbl.sender order by created_at desc limit 1) as name FROM `testtbl` WHERE chat_mode = 'on' group by sender";
		$result=mysqli_query($conn,$query);
		if($result->num_rows)
		{
		while($row=mysqli_fetch_assoc($result))
		{
		 ?>
                    
                       <tr>
    <td > <?php echo $row['name'];?></td>
    <td > <?php echo $row['sender'];?></td>
    <td ><?php if($row['agent_mod']>0){echo "Agent";}else{echo "Bots";}?></td>
  </tr>
                    <?php 
		} 
	} 
}



  if(isset($_POST['req_id']) && $_POST['table']== "chat_load"){ 


  
    
    //   $html =  '<div class="overflow-auto " style="height:500px;background:white;border-radius: 10px;padding-top: 10px;" id="chat_load">';
            $u_id=$_SESSION['u_id'];             
          $html="";              
          ///        
// $query="     SELECT 
//   r.phone_no,
//   r.name,
//   r.datetime AS request_time,
//   d.datetime AS message_time,
//   d.msgs,
//   d.u_id
// FROM req_to_agent r
// JOIN d_agent d ON r.ra_id = d.ra_id
// WHERE r.phone_no = '$_SESSION[phone_no]'
// ORDER BY r.ra_id, d.datetime";


   ////
        // $query="SELECT * FROM `d_agent` where ra_id ='{$_POST['req_id']}' order by datetime";
        // $query="SELECT * FROM `d_agent` where phone_no ='$_SESSION[phone_no]' order by datetime";

	// 	$result=mysqli_query($conn,$query);

	// 	if($result->num_rows)
	// 	{ 
	// 	while($row=mysqli_fetch_assoc($result))
	// 	{
	// 	    if($row["u_id"] > 0 || $row["u_id"] !=""){
	// 	$html .='<div class=" text-right mt-2 ml-1"><span class="right-side">'.$row['msgs'].'</span></div>';
	// 	    }else {
	// 	$html .='<div class=" text-left mt-2 ml-1"> <span class="left-side">'.$row['msgs'].'</span></div>';
	// 	    }
	// 	} 
	// 	$html .=  '<div id="last_c"></div>' ;
	// 	echo $html;
	// } 


  $query = "
(
    SELECT 
        d.datetime AS msg_time,
        d.msgs AS message,
        d.u_id,
        'agent' AS sender_type
    FROM d_agent d
    JOIN req_to_agent r ON r.ra_id = d.ra_id
    WHERE r.phone_no = '$_SESSION[phone_no]'
      AND d.msgs IS NOT NULL
      AND d.msgs != '0'
)
UNION ALL
(
    SELECT 
        m.created_at AS msg_time,
        m.question AS message,
        NULL AS u_id,
        'user' AS sender_type
    FROM msgs m
    JOIN conversations c ON c.id = m.conversation_id
    WHERE c.sender = '$_SESSION[phone_no]'
      AND m.question IS NOT NULL
)
UNION ALL
(
    SELECT 
        m.created_at AS msg_time,
        m.answer AS message,
        NULL AS u_id,
        'bot' AS sender_type
    FROM msgs m
    JOIN conversations c ON c.id = m.conversation_id
    WHERE c.sender = '$_SESSION[phone_no]'
      AND m.answer IS NOT NULL
)
ORDER BY msg_time ASC
";


$result = mysqli_query($conn, $query);
$html = "";

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // if ($row['sender_type'] == 'user' || $row["u_id"] > 0 || $row["u_id"] !="") {
        //     $html .= '<div class="text-right mt-2 ml-1"><span class="right-side">' . $row['message'] . '</span></div>';
        // } elseif ($row['sender_type'] == 'bot') {
        //     $html .= '<div class="text-left mt-2 ml-1"><span class="left-side">' . $row['message'] . '</span></div>';
        // } elseif ($row['sender_type'] == 'agent') {
        //     $html .= '<div class="text-left mt-2 ml-1"><span class="left-side">' . $row['message'] . '</span></div>';
        // }
        if ($row['sender_type'] == 'user' || (!empty($row["u_id"]) && $row["u_id"] > 0)) {
    $html .= '<div class="text-right mt-2 ml-1"><span class="right-side">' . $row['message'] . '</span></div>';
} else {
    $html .= '<div class="text-left mt-2 ml-1"><span class="left-side">' . $row['message'] . '</span></div>';
}

    }
    $html .= '<div id="last_c"></div>';
    echo $html;
} else {
    echo '<div class="text-center text-muted">No chat history found.</div>';
}
}


 if(isset($_POST['table']) && $_POST['table']== "transfer_data"){
   $u_id=$_SESSION['u_id'];
        $query="select * ,t.ra_id as tra_id,(select concat(name,' ',lname) from user where id = t.u_id) as uname  from transfer_to as t join req_to_agent as ra on ra.ra_id=t.ra_id where to_agent = $u_id and t.status =0";
		$result=mysqli_query($conn,$query);
		while($row=mysqli_fetch_assoc($result))
		{
		 ?>
                    
                       <tr>
    <td > <?php echo $row['uname'];?></td>
    <td > <?php echo $row['name'];?></td>
    <td > <?php echo $row['phone_no'];?></td>
    <td ><button onclick="taccept(<?php echo $row['ta_id'].",".$row['tra_id'];?>)" style="font-size: smaller;"class="btn btn-success ">Accept</button></td>
    <td ><button onclick="reject(<?php echo $row['ta_id'].",".$row['tra_id'];?>)" style="font-size: smaller;"class="btn btn-danger ">Reject</button></td>
  </tr>
                    <?php 
		} 

}

 if(isset($_POST['table']) && $_POST['table']== "transfer_data_idex"){
   $u_id=$_SESSION['u_id'];
        $query="select * ,t.ra_id as tra_id,(select concat(name,' ',lname) from user where id = t.u_id) as uname  from transfer_to as t join req_to_agent as ra on ra.ra_id=t.ra_id where to_agent = $u_id and t.status =0";
		$result=mysqli_query($conn,$query);
		while($row=mysqli_fetch_assoc($result))
		{
		 ?>
                    
                       <tr>
    <td > <?php echo $row['uname'];?></td>
    <td > <?php echo $row['name'];?></td>
    <td > <?php echo $row['phone_no'];?></td>
    
  </tr>
   <tr>
   <td ><button onclick="taccept(<?php echo $row['ta_id'].",".$row['tra_id'];?>)" style="font-size: smaller;"class="btn btn-success ">Accept</button></td>
    <td ></td>
    <td ><button onclick="reject(<?php echo $row['ta_id'].",".$row['tra_id'];?>)" style="font-size: smaller;"class="btn btn-danger ">Reject</button></td>
    
  </tr>
                    <?php 
		} 

}

 if(isset($_POST['table']) && $_POST['table']== "transfer_to"){
   $u_id=$_SESSION['u_id'];
    $r_id=$_POST['ra_id'];
    $to_agent=$_POST['to_agent'];
$insert_d="INSERT INTO transfer_to (`ra_id`, `u_id`, `to_agent`,  `status`) VALUES('{$r_id}','{$u_id}', '{$to_agent}', '0')";
$result_accinfo_sql = mysqli_query($conn, $insert_d);
	unset($_SESSION['request_id']);
echo "Successfully transfered";
}

  if(isset($_POST['ag_ra_id']) && $_POST['table']== "agent_to_agent_a"){
    $u_id=$_SESSION['u_id'];
    $r_id=$_POST['ag_ra_id'];
    $ta_id=$_POST['to_agent'];
	$update1="UPDATE `req_to_agent` SET `u_id`='{$u_id}',`status`='1',`mode`='1'WHERE `ra_id`='{$r_id}'";
	$result=mysqli_query($conn, $update1);
		$update2="UPDATE `transfer_to` SET `status`='2' WHERE `ta_id`='{$ta_id}'";
$result_accinfo_sql = mysqli_query($conn, $update2);
	$_SESSION['request_id']=$r_id;
  echo json_encode(array('status' => 200, 'message' => "Accepted successfully"));

    // echo "Accepted successfully";

}


?>