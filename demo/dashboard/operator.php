<?php
include('header.php');
// session_start();

?>
<style>
       .btn 
   {
      --bs-btn-padding-y: 0.1rem;
      --bs-btn-padding-x: 0.6rem
   }
      .table>:not(caption)>*>*
        {
            padding: 0.4rem 0.2rem;
        }

        table 
   {
      font-size:10px;
   }
   .row
   {
    --bs-gutter-x:0.5rem;
   }
   table tbody tr td
   {
      padding-left: 15px;
   }
   table thead tr th 
   {
      font-weight:bold;
   }
   table tbody tr td 
   {
      font-weight:600;
   } 
   #msg {
  visibility: hidden; /* Hidden by default. Visible on click */
  min-width: 250px; /* Set a default minimum width */
 /* margin-left: -125px;  Divide value of min-width by 2 */
  background-color: #333; /* Black background color */
  color: #fff; /* White text color */
  text-align: center; /* Centered text */
  border-radius: 2px; /* Rounded borders */
  padding: 16px; /* Padding */
  position: fixed; /* Sit on top of the screen */
  z-index: 1; /* Add a z-index if needed */
  left: 50%; /* Center the snackbar */
  bottom: 30px; /* 30px from the bottom */
}

/* Show the snackbar when clicking on a button (class added with JavaScript) */
#msg.show {
  visibility: visible; /* Show the snackbar */
  /* Add animation: Take 0.5 seconds to fade in and out the snackbar.
  However, delay the fade out process for 2.5 seconds */
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}
.opertorcards
{
   margin-bottom: 2px;
   box-shadow: 0 0 12px rgba(0, 0, 0, 1.5); /* Adjust as needed */
   /* border: 1px solid black; */
   border-collapse: collapse;

}

#chat_load {
    overflow: hidden; /* Disable scrolling */
    /* height: 400px; Adjust height as needed */
    position: relative;
}


     .right-side {
        text-align: right;
        color: blue; 
        padding: 10px;
        border: 1px solid #ddd;
        background-color: #f8f9fa;
        border-radius: 10px;
        display: inline-block;
        width: fit-content;
        float: right;
        clear: both;
        margin: 5px 0;
    }

    .left-side {
        text-align: left;
        color: green; 
        padding: 10px;
        border: 1px solid #ddd;
        background-color: #e9ecef;
        border-radius: 10px;
        display: inline-block;
        width: fit-content;
        float: left;
        clear: both;
        margin: 5px 0;
    } 
 
   .text-left {
        width: 100%;
    }
    
    .text-right {
        width: 100%;
    }
    @keyframes pulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}

.btn-pulse {
  animation: pulse 1s infinite;
}


</style>

<div class="conatiner-fluid content-inner mt-n9 mt-2 py-0 " >
<div class="row">
<div class="col-lg-6">
   
         <div class="card">
         <div id='msg'></div>

            <div class="card-body">
               <div class="border-bottom  pb-3 " style="height:350px; ">
               <?php if(isset($_SESSION['request_id'])){ 
        $query="SELECT * from req_to_agent WHERE `ra_id`='{$_SESSION['request_id']}'";
		$result=mysqli_query($conn,$query);
		if($result->num_rows>0)
		{

	$row=mysqli_fetch_assoc($result);
		    
	

                    ?>
             <div style="color: #2a3f54;BACKGROUND: aliceblue;FONT-WEIGHT: 800;TEXT-ALIGN: center;"><b>Customer name : </b><?php  echo $row['name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Customer Phone : </b><?php  echo $row['phone_no']; ?></div>
             <!-- <div id="customer_info"></div> -->
             <br>
            <?php }  
            }
            ?> 
            <div id="customer_info"></div>

                    <input type="hidden" value ="<?php if(isset($_SESSION['request_id'])){ echo $_SESSION['request_id']; } ?>" id="chat_id">
                    <div class="overflow-auto" style="height:300px; background:white; border-radius: 10px; padding-top: 10px;" id="chat_load">
                    </div>

                      
                        
               </div> 
               <div class=" justify-content-between mt-3 ml-5">
                  <div>
                  <form class="row mt-2" onsubmit="return false">
                       <div class="col-8 ">
                            <input type="text"  id="message" class="form-control" placeholder="Reply to user" style="font-weight:400;" >
                        </div>
                        <div class="col-4 d-flex">
                            <button type="button"  onclick="msg_send($('#chat_id').val())"  class="btn btn-primary  " style="font-size:11px;">Send</button>&nbsp;&nbsp;
                            <button type="button" onclick="chat_close($('#chat_id').val())" class="btn btn-danger " style="font-size:10px;">Close chat</button>
                        </div>
                   </form>
                  </div>
                  <div class="mt-2">
                  <div class="row pl-2">
                        <div class="col-2 transfer" style="padding: 11px 0px 0px 5px; font-weight:400; width:80px; font-size:12px">
                         Transfer to
                        </div>
                       <div class="col-lg-6 col-sm-12" style="font-weight:400;">
                            <select id="agent_sel" class="form-control" required >
                                <option value=""  >Select Agent</option>
        <?php
        $query="SELECT * FROM `user` WHERE id != ".$_SESSION['u_id']." and role = 2 and active = 1";
		$result=mysqli_query($conn,$query);
		while($row=mysqli_fetch_assoc($result))
		{
		 ?>
          <option value="<?php echo $row["id"]?>"><?php echo $row["name"]." ".$row["lname"] ;?></option>
                    <?php
		} 
 ?>
                            </select>
                        </div>
                        <div class="col-2 ">
                            <button type="submit"  onclick="transfer_to (<?php if(isset($_SESSION['request_id'])){ echo $_SESSION['request_id']; }  ?>)"  class="btn btn-primary  " style="font-size:10px; padding: 10px 40px">Transfer</button> 
                        </div>
                        <script>
                           print($_SESSION['request_id']);
                        </script>
                        
                   </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-6">
         <div class="bg-primary p-1" style="border-radius: 10px;">
         <div class="row">
         <div class="col-md-6" >
            <div class="card opertorcards overflow-auto" style="height:450px">
            <div class="card-header d-flex justify-content-between badge p-3 bg-primary-light">
               <div class="header-title">
                  <h4 class="card-title" style="font-size:14px; color:white;">On Going chats</h4>
               </div>
            </div>
            <div class="card-body p-1">
               <div class="table-responsive ">
                  <table id="basic-table" class="table table-striped mb-0" role="grid">
                     <thead>
                        <tr>
                           <th class="p-2">Companies</th>
                           <th>Members</th>
                           <th>Budget</th>
                           
                        </tr>
                     </thead>
                     <tbody id="queue_data">
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
            </div>
            <div class="col-md-6 ">
            <!-- <div id="agent-queue-notification" class="mb-2" style="display:block; background-color: #ffcc00; padding: 10px; text-align: center; margin-top: 10px;">
    New unresolved query! <button onclick="viewNotification()">View</button>
</div> -->

            <div class="card opertorcards overflow-auto" style="height:450px">
            <div class="card-header d-flex justify-content-between badge p-3 bg-primary-light">
               <div class="header-title">
                  <h4 class="card-title" style="font-size:14px;color:white;">Agent queue</h4>
               </div>
            </div>
            <div class="card-body p-1">
               <div class="table-responsive ">
                  <table id="basic-table" class="table table-striped mb-0" role="grid">
                     <thead>
                        <tr>
                           <th class="p-1">Name</th>
                           <th>Phone no</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody id="load_req" style="color:black;">
                       
                        <tr>
                           
                           <td>$2000</td>
                           <td><div class="text-warning">Completed</div></td>
                           <td>
                              <div class="d-flex align-items-center mb-2">
                                 <h6>40%</h6>
                              </div>
                              <div class="progress bg-soft-warning shadow-none w-100" style="height: 6px">
                                 <div class="progress-bar bg-warning" data-toggle="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
            </div>
         </div>
         </div>
         <div class="row mt-2">
            <div class="col-md-12">
            <div class="card">
            <div class="card-header d-flex justify-content-between badge p-3 bg-primary-light">
               <div class="header-title">
                  <h4 class="card-title" style="font-size:14px; color: white;" >Transfer Agent to me</h4>
               </div>
            </div>
            <div class="card-body p-1">
               <div class="table-responsive ">
                  <table id="basic-table" class="table table-striped mb-0" role="grid">
                     <thead>
                        <tr>
                           <th class="p-2">Agent Name	</th>
                           <th>Name</th>
                           <th>Phone no</th>
                           <th colspan="2">action</th>
                           
                        </tr>
                     </thead>
                     <tbody id="transfer_data">
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
            </div>
         </div>
      </div>
      
   </div>
      </div>
<?php
include('footer.php');

?>


<script>
   
 $(document).ready(function(){
    //  $("#msg").hide()
     load_req();
     queue_data();
     transfer_data()
   //   chat_load();
  var chat_id =  $("#chat_id").val()
  if(chat_id!=""){
        $("#message").focus();
      chat_load(chat_id);
      // fetchCustomerInfo(chat_id);
  }
});
setInterval(function() {
  transfer_data()        
  load_req();
  queue_data();
//   chat_load();
  var chat_id =  $("#chat_id").val()
  if(chat_id!=""){
   $("#message").focus();
      chat_load(chat_id);
      // fetchCustomerInfo(chat_id);

  }
            }, 1000);

            function accept(val) {
    if ($("#chat_id").val() == "") {
        console.log("Accepting chat with ID: " + val); // Debugging statement
        $.ajax({
            url: "chat_process.php",
            type: "post",
            data: { ara_id: val, table: "req_to_agent_a" },
            dataType: "json",
            success: function(response) {
                console.log("Response from server: ", response); // Debugging statement
                toast_s(response.message);
                $("#chat_id").val(val); // Setting the chat_id value
                console.log("Chat ID after accept: " + $("#chat_id").val()); // Debugging statement
                
                // Update customer info
                $('#customer_info').html(
                    `<div style="color: #2a3f54;BACKGROUND: aliceblue;FONT-WEIGHT: 800;TEXT-ALIGN: center;">
                        <b>Customer name : </b>${response.name}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <b>Customer Phone : </b>${response.phone_no}
                    </div>`
                );

                chat_load(val); // Load the chat immediately
                load_req(); // Update the request list
                queue_data(); // Update the queue data
            }
        });
    } else {
        alert("You can't join this Chat, Please close the Previous chat");
    }
}

    function reject(val,val1)
    {
       
if (confirm("Sure! You want to Recject this Request")==true) {
  $.ajax({
  url: "chat_process.php",
  type: "post",
  data: {ta_id : val,ra_id:val1,table : "req_to_agent_r"},
  success: function(data){
    toast_s(data);
    
  }
});
}

}

// Enter key press ke liye event listener
$("#message").keypress(function(e) {
    if (e.which == 13) {
        msg_send($('#chat_id').val());
    }
});

function msg_send(val) {
    var sendmsg = $("#message").val();
    var msg = "You can't send an empty Message";
    if (isNaN(val)) {
        val = "";
        msg = "You have to Accept the chat";
    }
    if (sendmsg != "" && val != "") {
        console.log("Message to send: ", sendmsg);
        $("#message").val(''); // Input field clear karna 
        $.ajax({
            url: "services.php",
            type: "post",
            data: {sendmsg: sendmsg, ra_id: val, table: "sendmsg"},
            success: function(data) {
                $("#message").val(''); // Input field clear karna
                console.log(data);
                load_req(); // Refresh the requests
                chat_load(); // Refresh the chat messages
            }
        });
    } else {
        toast_s(msg);
    }
}

    function load_req()
    {
  $.ajax({
  url: "chat_process.php",
  type: "post",
  data: {table : "load_req"},
  success: function(data){
      $("#load_req").html(data)
   
  }
}); 
            
}
  function queue_data()
    {
  $.ajax({
  url: "chat_process.php",
  type: "post",
  data: {table : "queue_data"},
  success: function(data){
      $("#queue_data").html(data)

  }
})
}

function chat_load(val) {
    var chat_id = val || $("#chat_id").val();
    console.log("Loading chat with ID: " + chat_id); // Debugging statement
    if (chat_id != "") {
        $.ajax({
            url: "chat_process.php",
            type: "post",
            data: {table: "chat_load", req_id: chat_id},
            success: function(data) {
                $("#chat_load").html(data);
                // $('#chat_load').animate({
                //     scrollTop: $("#last_c").offset().top
                // }, 0);
                var chatLoad = $('#chat_load');
                  //   chatLoad.scrollTop(chatLoad[0].scrollHeight);
            }
        });
    } else {
        $("#chat_load").html(''); // Clear chat messages if no chat_id
    }
}

function chat_close(val) {
    console.log("Closing chat with ID: " + val); // Debugging statement
    if (isNaN(val)) {
        val = $("#chat_id").val();
    }
    if (val != "") {
        if (confirm("Sure! You want to close this Chat") == true) {
         $("#chat_id").val("");
         $('#customer_info').html("");
         load_req(); // Update the request list
         queue_data(); // Update the queue data
         chat_load("");
            $.ajax({
                url: "chat_process.php",
                type: "post",
                data: {cra_id: val, table: "close_chat"},
                dataType: "json",
                success: function(response) {
                    console.log("Response from server: ", response); // Debugging statement
                    if (response.status == 200) {
                        toast_s(response.message);
                        $("#chat_id").val(""); // Reset chat_id after closing the chat
                        setTimeout(function() {
                            load_req(); // Update the request list
                            queue_data(); // Update the queue data
                            chat_load(""); // Clear the chat messages
                            console.log("Chat ID after closing: " + $("#chat_id").val()); // Debugging statement
                        }, 500); // Small delay to ensure smooth operation
                    }
                }
            });
        }
    } else {
        toast_s("Already closed");
    }
}

        function transfer_data()
    {
  $.ajax({
  url: "chat_process.php",
  type: "post",
  data: {table : "transfer_data"},
  success: function(data){
      $("#transfer_data").html(data)
   
  }
});
            
}
function toast_s(val){
   
   var x = document.getElementById("msg");
      x.innerHTML = val;
 // Add the "show" class to DIV
 x.className = "show";

 // After 3 seconds, remove the show class from DIV
 setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
  
   // $("#"+id).html('<div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">'+val+'</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>')
}
function toast_d(id,val){
     $("#"+id).html('<div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">'+val+'</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>')
}
       function transfer_to(val1)
    {
        
        var msg="";
         if(isNaN(val1)){
            val1 = "";
            msg += "you have to accept request to tranfer another \n";
        }
        var val2 = $('#agent_sel').val();
         if(isNaN(val2) ){
            val2 = ""; 
            msg += "You to select any agent \n";

         }
    
        if(val1 !="" && val2 !=""){
             $.ajax({
  url: "chat_process.php",
  type: "post",
  data: {to_agent:val2,ra_id:val1,table : "transfer_to"},
  success: function(data){
    //   $("#transfer_data").html(data);
    // alert(data)
    toast_s(data);
  
    setTimeout(function(){ location.reload(); }, 3000);   

    //  console.log(data)
  }
});
        }else{
            toast_s(msg)
        }   
}
    function taccept(val2,val)
    { 
        if($("#chat_id").val() ==""){
   
  $.ajax({
  url: "chat_process.php",
  type: "post",
  data: {to_agent:val2,ag_ra_id : val,table : "agent_to_agent_a"}, 
  success: function(data){
    toast_s(data);
    setTimeout(function(){ location.reload(); }, 3100);            
  }
});
}else{
    toast_s("You can't join this Chat,  Please close the Previous chat");
}
    
}
</script>

