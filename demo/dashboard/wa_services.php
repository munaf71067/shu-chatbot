<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Content-Type:application/json");

include 'database.php';
include 'chatbot.php';


//global
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'kodevg_ziahuddin_chatbot';
// 


$db = new Database($dbhost, $dbuser, $dbpass, $dbname);
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$chatbot = new ChatbotHelper();

//Managing Payload
$payload = file_get_contents('php://input');
$data = json_decode($payload);



if(empty($data->data->attachmenttype) || $data->data->attachmenttype == 'status') {
    echo json_encode(array('status' => 200, 'info' => 'OK'));
    die();
} else { $attachment_type = $data->data->attachmenttype; }


    
$sender = $data->data->receiveraddress;
$name = json_decode($data->data->parts[0]->originalEvent)->profile->name;

$real_data = json_decode(trim($data->data->parts[0]->originalEvent));
$real_data->connectionname = $data->data->connectionname;
$text = $real_data->text->body;
$pdf_file = null;

$db->query('INSERT INTO payloads (user_number,payload) VALUES (?,?)', $sender, $payload);

if ($data->data->connectionname == "") {
    $chatbot->curl_set_connection($sender);
}

//Message by user
if (!empty($data->data->parts[0]->data)) {
    $message = $text;
} else {
    //$message = 'hi';
  
    $message = '0';
}
$real_data->connectionname = $sender;

$conversation = $db->query('SELECT * FROM conversations where sender=? and ended=0', array($sender))->fetchArray();
$lmessage=strtolower($message);

$last_chat    = $db->query("SELECT * FROM testtbl where sender='{$sender}'AND chat_mode='on'  ORDER BY id desc limit 1")->fetchArray();
$seclast_chat = $db->query("SELECT * FROM testtbl where sender='{$sender}'AND chat_mode='on' ORDER BY id desc limit 1,1")->fetchArray();

 $agent_mod=$last_chat['agent_mod'];
 
 if( $agent_mod=="0" || $agent_mod==0){
if(empty($last_chat))
{
    //new chat
    //insert sender phone number and  0 parent into testtbl
       $chat_first = $db->query("SELECT * FROM testtbl where sender='{$sender}' and parent='0'and chat_mode='off' ORDER BY id desc limit 1")->fetchArray();
       if($chat_first)
       {
       $chat_no = $chat_first['chat_no'];
       $chat_no++;
       }
       else
       {
        $chat_no=1;   
       }
    $insert_parent_sql="insert into testtbl set parent='0', message='{$lmessage}', sender='{$sender}',chat_mode='on',chat_no='$chat_no', status='1'";
    $result_parent = mysqli_query($conn, $insert_parent_sql);
    
     $sql="SELECT * FROM questions q WHERE  q.parent='0' AND status='A'";
    //$sql="SELECT q.questions AS questions FROM replies r ,questions q WHERE  q.parent='0'";
    $result = mysqli_query($conn, $sql);
    $questions="";
    if($result->num_rows)
    {
        while($row=mysqli_fetch_assoc($result))
        {
             //$questions.=$row['questions']."\n";
             if($row['conv_id']!=null)
             {
             $dash='.';
             }
             else
             {
               $dash='';  
             }
              if($row['image'] != '') $reply['image'] = $row['image'];
             if($row['pdf_file'] != '') $reply['pdf_file'] = $row['pdf_file']; 
             $questions.=$row['conv_id'].$dash.$row['questions']."\n";
             $intro_message=$row['intro_message']."\n";
             
               
        }
       
        
        $questions .="@ - Agent"."\n";
        if($row['parent']!=0)
        { $questions .="0 - Back"."\n";
        $questions .="* - Home"; }
       
        $questions .="# - exit";
       
        $reply['reply']=$intro_message."\n";
        $reply['reply'].=$questions;
        
        //$reply['pdf_file'] = 'http://www.africau.edu/images/default/sample.pdf';
        //$reply['reply']=json_encode($questions);
    }
}
else
{
//check last query created time with current time

$from       = $last_chat['created'];
$to         = date('Y-m-d h:i:s');

$total      = strtotime($to) - strtotime($from);
// $hours      = floor($total / 60 / 60);
// $minutes    = round(($total - ($hours * 60 * 60)) / 60
$minutes    = $total/60;
if($minutes <= 30){
    
    //$reply['reply']='last chat is => '.json_encode($last_chat);
    if($lmessage == '@'){ 
        $sender=$last_chat['sender'];
        $sqldb="update  testtbl SET agent_mod='1',parent='0' WHERE id='{$last_chat['id']}'";
        //   $sqldb="insert into testtbl set parent='0', message='hi', sender='{$sender}',chat_no='$chat_no',chat_mode='on', status='1', agent_mod='1'";
        $result_home1 = mysqli_query($conn, $sqldb); 
        //  $last_id = $conn->insert_id;
         
         $sqldb2="INSERT INTO `req_to_agent` set  `u_id`='0', `status`='0' , `mode`='0', `phone_no`='{$sender}',`name`='{$name}',`t_id`='{$last_chat['id']}'";
        $result1 = mysqli_query($conn, $sqldb2);
        $reply="Your Request has been gone, Please wait for Agent \n\n  Thank You! \n\n   Back #";
        $parameters = $chatbot->wa_text_Array($reply, $sender);
$chatbot->send_message(json_encode($parameters));
        die;
    } elseif($lmessage == '*'){
      $sender=$last_chat['sender'];
       
       //Delete all next rows of this user
       //$pre_reply = $db->query('SELECT * FROM replies where id=?', $conversation['previous'])->fetchArray();
       //$chat_first_row ="SELECT * FROM testtbl WHERE sender='{$sender}' and parent='0' ORDER BY id DESC limit 1'";
       //$chatrow = $db->query($chat_first_row);
       
         $home_parent="insert into testtbl set parent='0', message='hi', sender='{$sender}',chat_no='$chat_no', status='1'";
        $result_home = mysqli_query($conn, $home_parent);  
               
       $chat_first_row = $db->query("SELECT * FROM testtbl where sender='{$sender}' and parent='0' ORDER BY id desc limit 1")->fetchArray();
               
       $chat_first_id = $chat_first_row['id'];
               
    //   $del_all_next ="DELETE FROM testtbl WHERE sender='{$sender}' and id > '{$chat_first_id}'";
    //   $db->query($del_all_next);
    
    
               
       $prev_id2 = 0;
       
       //$reply['reply']= 'query array is => '.json_encode($chat_first_id);
       //$reply['reply']='sec last chat is => '.json_encode($seclast_chat);
   }elseif($lmessage == '0' || $lmessage == 0){

    $prev_id2=$seclast_chat['parent'];
   
       
       //Delete all next rows of this user
       
      $del_all_next =" DELETE FROM testtbl WHERE sender='{$sender}' and id='{$last_chat['id']}'";
      $db->query($del_all_next);
       
       //$reply['reply']='sec last chat is => '.json_encode($seclast_chat);
   }
   elseif($lmessage == '#'){
       
       //Update Chat_mode OFF
        $chat_mode ="update testtbl SET chat_mode='off' WHERE sender='{$sender}'";
       $db->query($chat_mode);
       die;
       
       
   }
   else{
        $prev_id=$last_chat['parent'];
        $secon_last_parent=$seclast_chat['parent'];
        $prev_id2= $prev_id;
        $acc_type= '';
        $get_acc_type = $db->query("SELECT * FROM questions where id='$prev_id' limit 1")->fetchArray();
         $acc_types = $get_acc_type['title'];
         
          $get_acc = $db->query("SELECT * FROM testtbl where id='$prev_id' limit 1")->fetchArray();
          if($get_acc)
          {
              $parent=$secon_last_parent;
          }
          else
          {
              $parent=$prev_id;
              
          }
         
         
         
         $sql3="SELECT * FROM questions q WHERE q.parent='229'";
         $result3=mysqli_query($conn, $sql3);
         $array=array();
         while($row3=mysqli_fetch_assoc($result3))
         {
             $array[]=$row3['id'];
         }
       
       

      if(in_array($prev_id, $array)){
      //Take data of name/email/phonenumber and save it in 'account_request' table when parent with in 230,231,232,233
        switch($prev_id){
            case $prev_id : {
                //Account opening request information for ADA
                //insert details into account_request table
                //$insert_accinfo_sql="insert into account_request set parent='{$prev_id}', sender='{$sender}', message='{$lmessage}', status='A'";
                //$result_accinfo_sql = mysqli_query($conn, $insert_accinfo_sql);
        
                //$reply['reply'] = 'Thanks your query has submitted for ADA';
                $acc_type=  $acc_types;
            }break;
      
        }
       
        if (strpos($lmessage, ',') !== false) {
        $chat_first = $db->query("SELECT * FROM testtbl where sender='{$sender}' and parent='0'and chat_mode='on' ORDER BY id desc limit 1")->fetchArray();
        $chat_id = $chat_first['id'];

        $data=explode(",",$lmessage);
        $name=$data[0];
        $email=$data[1];
        $phone=$data[2];
        $pattern = "/\\d{10}/";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $reply['reply'] = "Invalid email format eg.{peter@gmail.com}";
        }
       
        else if(!preg_match($pattern,$phone))
        {
            
            $reply['reply'] = "Invalid contact format eg.{3352465985}";
        }
        else
        {
        $insert_accinfo_sql="insert into account_request set parent='{$prev_id}', sender='{$sender}', message='{$lmessage}',account_type='{$acc_type}',chat_id='$chat_id', status='A'";
        $result_accinfo_sql = mysqli_query($conn, $insert_accinfo_sql);
        
        $reply['reply'] = 'Thanks your query has submitted for '.$acc_type."\n";
        
        // $reply['reply'] .="0 Back"."\n";
        // $reply['reply'] .="* Home"."\n";
        $reply['reply'] .="# - exit"."\n";
        
     
        }
      
        }
        
      }else{
           
          //$questions = $db->query('SELECT * FROM questions where conv_id=? and parent =?', array($lmessage),array($prev_id))->fetchArray();
          $sql_quest = "SELECT * FROM questions where conv_id='{$lmessage}' and parent ='{$prev_id}'AND status='A'";
          $questions = $db->query($sql_quest)->fetchArray();
            
            if($questions){
                $chat_first = $db->query("SELECT * FROM testtbl where sender='{$sender}' and parent='0'and chat_mode='on' ORDER BY id desc limit 1")->fetchArray();
                $chat_no = $chat_first['chat_no'];
                //$reply['reply']='last chat msg is => '.json_encode($sql_quest);
            
                $prev_id2 = $questions['id'];
                //$reply['reply']='new parent id is => '.json_encode($prev_id2);
                
                //save new parent in testtbl
                $insert_parent_sql="insert into testtbl set parent='{$questions['id']}', message='{$lmessage}', sender='{$sender}',chat_no='$chat_no', status='1'";
                $result_parent = mysqli_query($conn, $insert_parent_sql);    
            }else{
                $prev_id2 = $last_chat['parent'];
            }
      }    
   }
   
    $ansq="";
      $sql1='SELECT * from search where kewords like  "%'.$lmessage.'%" limit 1';
                    $result1 = mysqli_query($conn, $sql1);
                    if($result1->num_rows){
                    while($row1=mysqli_fetch_assoc($result1))
                        {
                            $ansq = $row1['q_id'];
                            // array_push($ansq,$row1['q_id']);
                        }
                        //   $ansq =   implode(",",$ansq);
                          $insert_parent_sql="insert into testtbl set parent='{$ansq}', message='{$lmessage}', sender='{$sender}', chat_mode='on', status='1'";
        mysqli_query($conn, $insert_parent_sql);
                         $sql="SELECT * FROM questions q WHERE q.parent = $ansq AND status='A'";
                    $result = mysqli_query($conn, $sql);
                    $questions="";
                    $q2="";
                    $conv="";
                    if($result->num_rows)
                    {
                        while($row=mysqli_fetch_assoc($result))
                        {
                            $prev_id2=$row['parent'];
                            //$questions.=$row['questions']."\n";
                             if($row['conv_id']!=null)
                         {
                         $dash='.';
                         }
                         else
                         {
                          $dash='';  
                         }
                          if($row['image'] != '') $reply['image'] = $row['image'];
                            if($row['pdf_file'] != '') $reply['pdf_file'] = $row['pdf_file'];
                            $questions.=$row['conv_id'].$dash.$row['questions']."\n";
                            $intro_message=$row['intro_message']."\n";
                           
                            $q2 .= $row['id'].', ';
                            $conv .= $row['conv_id'].', ';
                        }
                        if($prev_id2!=0)
                        {
                            
                        
                        $questions .="@ - Agent"."\n";
                        $questions .="0 - Back"."\n";
                        $questions .="* - Home \n";
                        $questions .="# - exit";
                        }
                        $reply['reply']= $intro_message."\n";
                        $reply['reply'].= $questions;
                    }
                       
                        
                    }else{
                        
        if (strpos($lmessage, ',') == false && strlen($lmessage)!=4) {
        //if($prev_id2 < '230' || $prev_id2 > '233'){
        
        //$sql="SELECT q.questions AS questions FROM replies r ,questions q WHERE r.message='$lmessage' AND q.parent='$prev2_id'";
                $sql="SELECT * FROM questions q WHERE q.parent='$prev_id2' AND status='A'";
                    $result = mysqli_query($conn, $sql);
                    $questions="";
                    $q2="";
                    $conv="";
                    if($result->num_rows)
                    {
                        while($row=mysqli_fetch_assoc($result))
                        {
                            //$questions.=$row['questions']."\n";
                             if($row['conv_id']!=null)
                         {
                         $dash='.';
                         }
                         else
                         {
                          $dash='';  
                         }
                          if($row['image'] != '') $reply['image'] = $row['image'];
                            if($row['pdf_file'] != '') $reply['pdf_file'] = $row['pdf_file'];
                            $questions.=$row['conv_id'].$dash.$row['questions']."\n";
                            $intro_message=$row['intro_message']."\n";
                           
                            $q2 .= $row['id'].', ';
                            $conv .= $row['conv_id'].', ';
                        }
                        if($prev_id2!=0)
                        {
                            
                        $questions .="@ - Agent"."\n";
                        $questions .="0 - Back"."\n";
                        $questions .="* - Home \n";
                        $questions .="# - exit";
                        }
                        $reply['reply']= $intro_message."\n";
                        $reply['reply'].= $questions;
                    }
        
        }
                    }
    
    //end of if($minutes <= 100){    
    } 
    
    else{
        //only parent will show
        $chat_mode ="update testtbl SET chat_mode='off' WHERE sender='{$sender}'";
        $result_home1 = mysqli_query($conn, $chat_mode); 
        
        $insert_parent_sql="insert into testtbl set parent='0', message='{$lmessage}', sender='{$sender}', chat_mode='on', status='1'";
        $result_parent = mysqli_query($conn, $insert_parent_sql);
        
        //   $sql="SELECT * FROM questions q WHERE  q.parent='0' AND status='A'";
        // //$sql="SELECT q.questions AS questions FROM replies r ,questions q WHERE  q.parent='0'";
        // $result = mysqli_query($conn, $sql);
        // $questions="";
        
        // if($result->num_rows)
        // {
        //     while($row=mysqli_fetch_assoc($result))
        //     {
        //      //$questions.=$row['questions']."\n";
        //       if($row['conv_id']!=null)
        //      {
        //      $dash='.';
        //      }
        //      else
        //      {
        //       $dash='';  
        //      }
        //      if($row['image'] != '') $reply['image'] = $row['image'];
        //      if($row['pdf_file'] != '') $reply['pdf_file'] = $row['pdf_file'];
        //      $questions.=$row['conv_id'].$dash.$row['questions']."\n";
             
        //     }
            
        //                 // $questions .="@ - Agent"."\n";
        //                 // $questions .="0 - Back"."\n";
        //                 // $questions .="* - Home \n";
        //                 // $questions .="# - exit";
            
        //     $reply['reply']=$questions;
        //     //$reply['pdf_file'] = 'http://www.africau.edu/images/default/sample.pdf';
        //     //$reply['reply']=$sender;
        // }
            $sql="SELECT * FROM questions q WHERE q.parent = 0 AND status='A'";
                    $result = mysqli_query($conn, $sql);
                    $questions="";
                    $q2="";
                    $conv="";
                    if($result->num_rows)
                    {
                        while($row=mysqli_fetch_assoc($result))
                        {
                            $prev_id2=$row['parent'];
                            //$questions.=$row['questions']."\n";
                             if($row['conv_id']!=null)
                         {
                         $dash='.';
                         }
                         else
                         {
                          $dash='';  
                         }
                          if($row['image'] != '') $reply['image'] = $row['image'];
                            if($row['pdf_file'] != '') $reply['pdf_file'] = $row['pdf_file'];
                            $questions.=$row['conv_id'].$dash.$row['questions']."\n";
                            $intro_message=$row['intro_message']."\n";
                           
                            $q2 .= $row['id'].', ';
                            $conv .= $row['conv_id'].', ';
                        }
                        $reply['reply']= $intro_message."\n";
                        $reply['reply'].= $questions;
                    }
    }
    //end of if($minutes <= 1){}else{}    
}

$error = null;
if (!empty($reply)) {
    // if reply is hi
    if (!empty($conversation)) {
        $db->query('Update conversations set ended=1 where sender=?', $sender);
        $db->query('INSERT INTO conversations (sender,name,previous) VALUES (?,?,?)', $sender, $name, $reply['id']);
        $conversation['id'] = $db->lastInsertID();
    } else {
        $db->query('INSERT INTO conversations (sender,name,previous) VALUES (?,?,?)', $sender, $name, $reply['id']);
        $conversation['id'] = $db->lastInsertID();
    }
    
    if(!empty($conversation)){
        $reply['reply']=str_replace("[name]",$conversation['fullname'],$reply['reply']);
        //$reply['reply']='not empty(conversation)';
    }
    
    if($reply['pdf_file']==null){
        if($reply['image']==null){
            $parameters = $chatbot->wa_text_Array($reply['reply'], $sender);
            //$parameters = $chatbot->wa_text_Array("11111111111111", $sender);
        }else{
                
            //  $chatbot->send_message(json_encode($chatbot->wa_text_Array("hello world!", $sender)));
             
             $chatbot->send_message(json_encode($chatbot->wa_attach_Array($reply['reply'], $sender,'SAS',$reply['image'],'image/jpg','image','image_link')));
            // $parameters = $chatbot->wa_text_Array($reply['reply'], $sender);
            
            //$parameters = $chatbot->wa_attach_Array('444444444444444444', $sender,'SAS',$reply['image'],'image/jpeg','image','image_link');
        }
        
    } 
    else{
        if($reply['image'] != '' || $reply['image']!=null){
             $chatbot->send_message(json_encode($chatbot->wa_attach_Array('', $sender,'SAS',$reply['image'],'image/jpg','image','image_link')));
        }else{
            //$parameters = $chatbot->wa_attach_Array($reply['reply'], $sender);
        }
        $chatbot->send_message(json_encode($chatbot->wa_attach_Array('', $sender,'SAS',$reply['pdf_file'],'application/pdf','document','document')));
        $parameters = $chatbot->wa_attach_Array($reply['reply'], $sender);
        
        //$parameters = $chatbot->wa_attach_Array('5555555555555', $sender,'SAS',$reply['pdf_file'],'application/pdf','document','document');
    }
}
else {
    $pre_reply = $db->query('SELECT * FROM replies where id=?', $conversation['previous'])->fetchArray();
    //if conversation continues
    if ($pre_reply['input_type'] != null) {
        // If requires Input/attachment
        $reply = $db->query('SELECT * FROM replies where parent like "%,' . $conversation['previous'] . ',%"')->fetchArray();
        if ($pre_reply['input_type'] == 'picture' && $attachment_type == 'image') {
            // $file = $chatbot->image_main($real_data);
        } elseif ($pre_reply['input_type'] == 'text' && $attachment_type == 'text') {
        } elseif ($pre_reply['input_type'] == 'name' && $attachment_type == 'text') {
            $db->query('Update conversations set fullname=? where sender=?',$message,$sender);
        } elseif ($pre_reply['input_type'] == 'email' && $attachment_type == 'text') {
            if (!filter_var($message, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please provide vaild Email Address e.g(someone@email.com)';
            }
        } elseif ($pre_reply['input_type'] == 'number' && $attachment_type == 'text') {
        } elseif ($pre_reply['input_type'] == 'location' && $attachment_type == 'location') {
        } else {
            $error = 'Please provide ' . $pre_reply["input_type"];
        }
    } else {
         $reply = $db->query('SELECT * FROM replies where message=? and parent like "%,' . $conversation['previous'] . ',%"', $message)->fetchArray();
    }

    if (!empty($reply) && $error == null) {
        
        // $parameters = $chatbot->wa_attach_Array("1254", $sender,'SAS','','application/pdf','document','document');
            $conversation = $db->query('SELECT * FROM conversations where sender=? and ended=0', array($sender))->fetchArray();
            if(!empty($conversation)){
                $reply['reply']=str_replace("[name]",'*'.$conversation['fullname'].'*',$reply['reply']);
            } 
        $db->query('Update conversations set previous=?,ended=? where sender=? and id=?', $reply['id'], $reply['ended'], $sender,$conversation['id']);
        if($reply['pdf_file']==null){
        //$parameters = $chatbot->wa_text_Array($reply['reply'], $sender);
        if($reply['image']==null){
                $parameters = $chatbot->wa_text_Array($reply['reply'], $sender);
                $chatbot->send_message(json_encode($chatbot->wa_attach_Array($reply['reply'], $sender)));
                  //$parameters = $chatbot->wa_text_Array('66666666666', $sender);
            }else{
                $parameters = $chatbot->wa_attach_Array($reply['reply'], $sender,'SAS',$reply['image'],'image/jpeg','image','image_link');
                $chatbot->send_message(json_encode($chatbot->wa_attach_Array($reply['reply'], $sender)));
                  //$parameters = $chatbot->wa_attach_Array('777777777777', $sender,'SAS',$reply['image'],'image/jpeg','image','image_link');
            }
            
        }
        else{
            if($reply['image']==null){
                $chatbot->send_message(json_encode($chatbot->wa_text_Array($reply['reply'],$sender)));
                  //$chatbot->send_message(json_encode($chatbot->wa_text_Array('8888888888',$sender)));
            }else{
                $chatbot->send_message(json_encode($chatbot->wa_attach_Array($reply['reply'], $sender,'SAS',$reply['image'],'image/jpg','image','image_link')));
                $chatbot->send_message(json_encode($chatbot->wa_attach_Array($reply['reply'], $sender)));
                  //$chatbot->send_message(json_encode($chatbot->wa_attach_Array('99999999999999', $sender,'SAS',$reply['image'],'image/jpg','image','image_link')));
            }
            $parameters = $chatbot->wa_attach_Array($reply['reply'], $sender,'SAS',$reply['pdf_file'],'application/pdf','document','document');
            $chatbot->send_message(json_encode($chatbot->wa_attach_Array($reply['reply'], $sender)));
              //$parameters = $chatbot->wa_attach_Array('101010101010', $sender,'SAS',$reply['pdf_file'],'application/pdf','document','document');
        }
    }
    else {
        $reply = 'Question not found!.Please go back with 0 and choose another from List';
        $parameters = $chatbot->wa_text_Array($error?$error:$reply, $sender);
    }
}

$chatbot->send_message(json_encode($parameters));

if (!empty($pre_reply)) {
    $db->query('INSERT INTO msgs(conversation_id,question,answer,file) VALUES (?,?,?,?)', $conversation['id'], $error ? $error : $pre_reply['reply'], $message, $pdf_file);
} else {
    $db->query('INSERT INTO msgs(conversation_id,question,answer,file) VALUES (?,?,?,?)', $conversation['id'], null, $message, $pdf_file);
}

echo json_encode(array('status' => 200, 'info' => 'OK'));
}
else if( $agent_mod=="1" || $agent_mod==1){
    if($lmessage=="#"){
  $sqldb1="update  testtbl SET agent_mod='0' WHERE id='{$last_chat['id']}'";
  $result_home = mysqli_query($conn, $sqldb1); 
  $sqldb2="update  req_to_agent SET  `mode`='2' WHERE t_id='{$last_chat['id']}'";
  $result_home2 = mysqli_query($conn, $sqldb2); 
  
    $sql="SELECT * FROM questions q WHERE q.parent = 0 AND status='A'";
                    $result = mysqli_query($conn, $sql);
                    $questions="";
                    $q2="";
                    $conv="";
                    if($result->num_rows)
                    {
                        while($row=mysqli_fetch_assoc($result))
                        {
                            $prev_id2=$row['parent'];
                            //$questions.=$row['questions']."\n";
                             if($row['conv_id']!=null)
                         {
                         $dash='.';
                         }
                         else
                         {
                          $dash='';  
                         }
                          if($row['image'] != '') $reply['image'] = $row['image'];
                            if($row['pdf_file'] != '') $reply['pdf_file'] = $row['pdf_file'];
                            $questions.=$row['conv_id'].$dash.$row['questions']."\n";
                            $intro_message=$row['intro_message']."\n";
                           
                            $q2 .= $row['id'].', ';
                            $conv .= $row['conv_id'].', ';
                        }
                        $reply['reply']= $intro_message."\n";
                        $reply['reply'].= $questions;
                    }

$parameters = $chatbot->wa_attach_Array($reply['reply'], $sender,'SAS',$reply['image'],'image/jpg','image','image_link');
$chatbot->send_message(json_encode($parameters));
}
else{
    
    $r_data = $db->query("SELECT * FROM req_to_agent where t_id ='{$last_chat['id']}'  ORDER BY datetime  DESC limit 1 ")->fetchArray();
      
        if($r_data['status']=="1" && $r_data['mode']=="1"){
            
      $insert_d="INSERT INTO d_agent set `ra_id`='{$r_data['ra_id']}',  `msgs`='{$message}'";
$result_accinfo_sql = mysqli_query($conn, $insert_d);
        }
        else{
            $reply = "Please wait for agent accept message";
$parameters = $chatbot->wa_text_Array($reply, $sender);
$chatbot->send_message(json_encode($parameters));
      }
      
//      $r_data="asdasdas";
//       $parameters = $chatbot->wa_text_Array($r_data, $sender);
// $chatbot->send_message(json_encode($parameters));
}
    
}
