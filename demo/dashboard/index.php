<?php
 include('header.php');
 ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 <style>
   h1{
      font-size:18px;
   }
   h4{
      font-size:16px;
   }
   /* .col-md-3
   {
      width: 23.5%;
   } */
   .card1
   {
      --bs-card-spacer-y: 0.5rem;
   }
   /* .iq-banner:not(.hide)+.content-inner
   {
      margin-top: -11.5rem !important;
   } */
   .table>:not(caption)>*>*
        {
            padding: 0.4rem 0.2rem;
        }
        .coloricon{
         font-size:30px;
         margin-left: 5px;
         color: #007BFF;
        }
        .coloricon1{
         font-size:30px;
         margin-left: 5px;
         color: #17A2B8;
        }
        .coloricon2{
         font-size:30px;
         margin-left: 5px;
         color: #28A745;
        }
   table 
   {
      font-size:10px;
   }
   .progressdetail
   {
      font-size:11.6px;
      margin-top: 5px;
   }
   #load_req tr td 
   {
      /* color: black; */
   }
   .opertorcart
   {
      margin:-10px;
       margin-right:-50px
   }
   @media screen and (max-width: 600px) {
      .opertorcart
   {
      margin:10px;
       margin-right:50px
   }
  
}

/* Media query for screens between 600px and 900px */
@media screen and (min-width: 600px) and (max-width: 900px) {
  body {
    font-size: 18px;
  }
}
.row 
{
    --bs-gutter-x: 1rem
}

 </style>
 <main class="main-content">
      <div class="position-relative iq-banner">
        <!--Nav Start-->
                <!-- Nav Header Component Start -->
          <div class="iq-navbar-header" style="height: 80px;">
              
              <div class="iq-header-img">
                  <img src="assets/images/dashboard/top-header.png" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
                  <img src="assets/images/dashboard/top-header1.png" alt="header" class="theme-color-purple-img img-fluid w-100 h-100 animated-scaleX">
                  <img src="assets/images/dashboard/top-header2.png" alt="header" class="theme-color-blue-img img-fluid w-100 h-100 animated-scaleX">
                  <img src="assets/images/dashboard/top-header3.png" alt="header" class="theme-color-green-img img-fluid w-100 h-100 animated-scaleX">
                  <img src="assets/images/dashboard/top-header4.png" alt="header" class="theme-color-yellow-img img-fluid w-100 h-100 animated-scaleX">
                  <img src="assets/images/dashboard/top-header5.png" alt="header" class="theme-color-pink-img img-fluid w-100 h-100 animated-scaleX">
              </div>
          </div>          <!-- Nav Header Component End -->
        <!--Nav End-->
      </div>

      <div class="conatiner-fluid content-inner mt-n5 py-0">
<div class="row">
   <div class="col-md-12 col-lg-12">
      <div class="row row-cols-1">
         <div class="overflow-hidden d-slider1 ">
            <ul  class="p-0 m-0 mb-2 swiper-wrapper list-inline">
            <?php
              	$query="SELECT count(id) as total FROM `testtbl` WHERE cast(created as date) = CURRENT_DATE()";
		$result=mysqli_query($conn,$query);
		if($result->num_rows>0)
		{

	$row=mysqli_fetch_assoc($result);
    echo '
               <li class="swiper-slide card card-slide card1" data-aos="fade-up" data-aos-delay="700">
                  <div class="card-body">
                     <div class="progress-widget">
                     <div>
                        <i class="fas fa-user coloricon"></i>

                        </div>
                        <div class="progress-detail progressdetail">
                           <p  class="mb-2">Total Customers</p>
                           <h4 class="counter mb-2">'.$row['total'].'</h4>
                           <p  style="margin-bottom:-5px">Today</p>

                        </div>
                     </div>
                  </div>
               </li>';
            }
            ?>
                 <?php
              	$query="SELECT count(ra_id) as total FROM `req_to_agent` WHERE cast(datetime as date) = CURRENT_DATE()";
		$result=mysqli_query($conn,$query);
		if($result->num_rows>0)
		{

	$row=mysqli_fetch_assoc($result);
    echo '  <li class="swiper-slide card card-slide card1" data-aos="fade-up" data-aos-delay="800">
                  <div class="card-body">
                     <div class="progress-widget">
                        <div>
                        <i class="fas fa-comments coloricon1"></i>

                        </div>
                        <div class="progress-detail progressdetail">
                           <p  class="mb-2">Requested to agent chat </p>
                           <h4 class="counter mb-2">'.$row['total'].'</h4>
                           <p  style="margin-bottom:-5px">Today</p>
                        </div>
                     </div>
                  </div>
               </li>';
            }
            ?>
                  <?php
              	$query="SELECT COUNT(DISTINCT(ra_id)) as total   FROM `d_agent` WHERE cast(`datetime` as date) = CURRENT_DATE() ";
		$result=mysqli_query($conn,$query);
		if($result->num_rows>0)
		{

	$row=mysqli_fetch_assoc($result);
    echo '<li class="swiper-slide card card-slide card1" data-aos="fade-up" data-aos-delay="900">
                  <div class="card-body">
                     <div class="progress-widget">
                        <div >
                        <i class="fas fa-user-check coloricon2"></i>
                        </div>
                        <div class="progress-detail progressdetail">
                           <p  class="mb-2">Chat Accpeted by Agents</p>
                           <h4 class="counter mb-2">'.$row['total'].'</h4>
                           <p  style="margin-bottom:-5px">Today</p>
                        </div>
                     </div>
                  </div>
               </li>';
         }
         ?>
            </ul>
            <div class="swiper-button swiper-button-next"></div>
            <div class="swiper-button swiper-button-prev"></div>
         </div>
      </div>
   </div>
   <?php
        $todays=date('Y-m-d');
        $array="";
        $dayss="";
        $no=1;
        
        for($i=6;$i>=0;$i--)
        {
        $dates=date("Y-m-d", strtotime("-$i day"));  
        if($no<7)
		{
        $dayss.=date("l", strtotime("-$i day")).",";
		}
		else
		{
		    $dayss.=date("l", strtotime("-$i day"));
		}
        $query6="SELECT count(id) as chatrr FROM `testtbl` WHERE created like '%$dates%'";
		$result6=mysqli_query($conn,$query6);
		$total=$result6->num_rows;
		
		$row6=mysqli_fetch_assoc($result6);
		if($no<7)
		{
 		$array.=$row6['chatrr'].",";
 		$no++;
		}
		else
		{
		    $array.=$row6['chatrr'];
		}
        }
    
         $query7="SELECT Month(created) as month, count(chat_no) as chats  FROM `testtbl`group by month ";
         $result7=mysqli_query($conn,$query7);
         $noo=1;
         $total=$result7->num_rows;
         $dbarr='';
         $all_d='';
      	while($row7=mysqli_fetch_assoc($result7))
      	{
      	    if($noo<$total)
      	    {
      	        $dbarr.=$row7['month'].",";  
      	        $all_d.=$row7['chats'].","; 
      	         
      	    }
      	    else
      	    {
      	         $dbarr.= $row7['month'];
      	          $all_d.=$row7['chats'];
      	         
      	    }
      	 
      	}
      $dm=explode(",",$dbarr);
      $mj=explode(",",$all_d);
   
 $all_months=array(1,2,3,4,5,6,7,8,9,10,11,12);
 $key_value=array();
 for($i=0;$i<=11;$i++)
 {
   
     if(in_array($all_months[$i], $dm))
     {
        
            // echo $chats[$i]=$all_months[$i].'-true <br>'; 
         $query8="SELECT Month(created) as month, count(chat_no) as chats  FROM `testtbl`group by month ";
         $result8=mysqli_query($conn,$query8);
         	while($row8=mysqli_fetch_assoc($result8))
      	{
      	    if($all_months[$i]==$row8['month'])
      	    {
      	        $key_value[$i+1]=$row8['chats'];
      	    }

      	}
        
       
     }
     else
     {
      $key_value[$i+1]=0;
     }
 }
 $month_name="";
  $total_chat="";
  $noo=1;
foreach($key_value as $keys=>$values)
{
    if($keys==1)
    {
       $keys="January"; 
    }
    if($keys==2)
    {
       $keys="Febuary"; 
    }
    if($keys==3)
    {
       $keys="March"; 
    }
    if($keys==4)
    {
       $keys="April"; 
    }
    if($keys==5)
    {
       $keys="May"; 
    }
    if($keys==6)
    {
       $keys="June"; 
    }
    if($keys==7)
    {
       $keys="July"; 
    }
    if($keys==8)
    {
       $keys="August"; 
    }
    if($keys==9)
    {
       $keys="September"; 
    }
    if($keys==10)
    {
       $keys="Otober"; 
    }
    if($keys==11)
    {
       $keys="November"; 
    }
    if($keys==12)
    {
       $keys="December"; 
    }
    if($noo<12)
    {
    $month_name.=$keys.",";
    $total_chat.=$values.",";
    $noo++;
    }else
    {
        $month_name.=$keys;
        $total_chat.=$values;
    }
    
}

 

        
       
		?>
	
	    <input type="hidden" value="<?php echo $dayss ?>"id="days_week">
	    <input type="hidden" value="<?php echo $array ?>"id="chat_week">
	    <input type="hidden" value="<?php echo $month_name ?>"id="monthss">
	    <input type="hidden" value="<?php echo $total_chat ?>"id="chat_month">
	    

   <div class="col-md-12 col-lg-8">
      <div class="row">
         <div class="col-md-12">
            <div class="card" data-aos="fade-up" data-aos-delay="800">
               <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                  <div class="header-title">
                     <h4 class="card-title" id="cardTitle">Total Chat in Month</h4>
                     <!-- <p class="mb-0">Total Chats</p> -->
                  </div>
                  <div class="d-flex align-items-center align-self-center">
                     <div class="d-flex align-items-center text-primary"  id="monthText">
                        <svg class="icon-12" xmlns="http://www.w3.org/2000/svg" width="12" viewBox="0 0 24 24" fill="currentColor">
                           <g>
                              <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                           </g>
                        </svg>
                        <div class="ms-2">
                           <span class="text-gray">Total Chats</span>
                        </div>
                     </div>
                     <!-- <div class="d-flex align-items-center ms-3 text-info">
                        <svg class="icon-12" xmlns="http://www.w3.org/2000/svg" width="12" viewBox="0 0 24 24" fill="currentColor">
                           <g>
                              <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                           </g>
                        </svg>
                        <div class="ms-2">
                           <span class="text-gray">Cost</span>
                        </div>
                     </div> -->
                  </div>
                  <div class="dropdown">
                     <a href="#" class="text-gray dropdown-toggle" id="dropdownMenuButton22" data-bs-toggle="dropdown" aria-expanded="false">
                     This Month
                     </a>
                     <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton22">
                        <li><a class="dropdown-item" style="font-size:12px;" href="#" onclick="showMonth()">This Month</a></li>
                        <li><a class="dropdown-item" style="font-size:12px;" href="#" onclick="showWeek()">This Week</a></li>
                        <!-- <li><a class="dropdown-item" href="#">This Year</a></li> -->
                     </ul>
                  </div>
               </div>
               <div class="card-body" id="card-body1">
                  <div id="d-main" class="d-main"></div>
               </div>
               <div class="card-body" id="card-body2" style="display:none">
                  <div id="d-main1" class="d-main"></div>
               </div>
            </div>
         </div>
         <div class="row">
                
  <?php
              	$query1="SELECT `id`,`name`, `lname` FROM `user` WHERE role = 2";
		$result1=mysqli_query($conn,$query1);
		if($result1->num_rows>0)
		{
while($row=mysqli_fetch_assoc($result1))
      	{
	 
        $query="SELECT COUNT(DISTINCT(ra_id)) as total   FROM `req_to_agent` WHERE cast(`datetime` as date) = CURRENT_DATE()  and u_id ='{$row['id']}' ";
		$result=mysqli_query($conn,$query);
		if($result->num_rows>0)
		{

	$row2=mysqli_fetch_assoc($result);
    echo '
            <div class="col-md-2 col-sm-2 " style="">
               <div class="card" data-aos="fade-up" data-aos-delay="800">
                  <div class="card-body">
                     <div class="d-flex flex-column align-items-between opertorcart">
                        <div>
                           <span style="font-size:11px"> '.$row['name'].' '.$row['lname'].'</span>
                           <div class="mt-1">
                              <h3 class="counter">'.$row2['total'].'</h3>
                           </div>
                        </div>
                        <div class="mt-2">
                           <div class="badge p-2 bg-primary">
                              
                              <span>Today</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>';
         }
             
      	    
      }


 }
           ?>
            
           
         </div>
         
      </div>
   </div>
   <div class="col-md-12 col-lg-4">
      <div class="row">
         <div class="col-md-12 col-lg-12">
            <div class="card credit-card-widget" data-aos="fade-up" data-aos-delay="900" >
               <div class="pb-4 border-0 card-header">
                  <div class="p-3 border border-white rounded primary-gradient-card overflow-auto"  style="height:290px">
                  <div>
               <h5 class="mb-3" style="font-size:16px;color: white;font-weight: 600;">Agent queue </h5>
               </div>
            <div class="table-responsive" >
            <!-- data-toggle="data-table" -->
                  <table id="datatable table2"  class="table table-striped" >
                     <thead style="opacity: 0.8" >
                        
                        <tr> 
                    <th style="width: 50px">Name</th>
                    <th  style="width: 50px">Phone no</th>
                    <th style="width: 50px">Action</th>
                        </tr>
                     </thead>
                     <tbody id="load_req"  >    
                                    
                     </tbody>
                     
                  </table>
               </div>
                     
                     
                  </div>
               </div>
               
            </div>
         </div>
         <div class="col-md-12 col-lg-12">
            <div class="card" data-aos="fade-up" data-aos-delay="600">
               <div class="flex-wrap card-header d-flex justify-content-between">
               <div class="header-title">
                     <h4 class=" card-title">Transfer Agent to me</h4>
                  </div>
               </div>
               <div class="card-body">
               <div class="table-responsive" >
            <!-- data-toggle="data-table" -->
                  <table id="datatable table1"  class="table table-striped" >
                     <thead >
                        
                        <tr> 
                           <th >Agent Name</th>
                           <th >Name</th>
                           <th >Phone no</th>
                        </tr>
                     </thead>
                     <tbody id="transfer_data" >    
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
      <div class="btn-download">
          <a class="btn btn-success px-3 py-2" href="https://iqonic.design/product/admin-templates/hope-ui-admin-free-open-source-bootstrap-admin-template/" target="_blank" >
              <svg class="icon-24"  width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path opacity="0.4" d="M17.554 7.29614C20.005 7.29614 22 9.35594 22 11.8876V16.9199C22 19.4453 20.01 21.5 17.564 21.5L6.448 21.5C3.996 21.5 2 19.4412 2 16.9096V11.8773C2 9.35181 3.991 7.29614 6.438 7.29614H7.378L17.554 7.29614Z" fill="currentColor"></path>
                  <path d="M12.5464 16.0374L15.4554 13.0695C15.7554 12.7627 15.7554 12.2691 15.4534 11.9634C15.1514 11.6587 14.6644 11.6597 14.3644 11.9654L12.7714 13.5905L12.7714 3.2821C12.7714 2.85042 12.4264 2.5 12.0004 2.5C11.5754 2.5 11.2314 2.85042 11.2314 3.2821L11.2314 13.5905L9.63742 11.9654C9.33742 11.6597 8.85043 11.6587 8.54843 11.9634C8.39743 12.1168 8.32142 12.3168 8.32142 12.518C8.32142 12.717 8.39743 12.9171 8.54643 13.0695L11.4554 16.0374C11.6004 16.1847 11.7964 16.268 12.0004 16.268C12.2054 16.268 12.4014 16.1847 12.5464 16.0374Z" fill="currentColor"></path>
              </svg>
          </a>
      </div>
<Script>
      $(document).ready(function(){
    //  $("#msg").hide()
     load_req();
     transfer_data()
});
setInterval(function() {
  transfer_data()        
  load_req();
 }, 1000);


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
function transfer_data()
    {
  $.ajax({
  url: "chat_process.php",
  type: "post",
  data: {table : "transfer_data_idex"},
  success: function(data){
      $("#transfer_data").html(data)
   
  }
});
            
}


</Script>
<script>
        function showMonth() {
            $('#card-body1').show();
            $('#card-body2').hide();
            $('#cardTitle').html('<h4 class="card-title">Total Chat in Month</h4>');
            $('#monthText').removeClass('text-success').addClass('text-primary');
            $('#dropdownMenuButton22').text('This Month');
        }

        function showWeek() {
            $('#card-body1').hide();
            $('#card-body2').show();
            $('#cardTitle').html('<h4 class="card-title">Total Chat in Week</h4>');
            $('#monthText').removeClass('text-primary').addClass('text-info');
            $('#dropdownMenuButton22').text('This Week');

        }
    </script>


      <?php
      include('footer.php')
      ?>
