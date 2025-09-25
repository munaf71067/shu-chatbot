<?php
include('header.php');

?>
<style>
       .btn 
   {
      --bs-btn-padding-y: 0.1rem;
      --bs-btn-padding-x: 0.6rem
   }
</style>
<br>
<br>
<br>
<div class="conatiner-fluid content-inner mt-n5 py-0 " >
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            
            <div class="card-body">
               <!-- <p>Images in Bootstrap are made responsive with <code>.img-fluid</code>. <code>max-width: 100%;</code> and <code>height: auto;</code> are applied to the image so that it scales with the parent element.</p> -->
               <div class="table-responsive">
                  <table id="datatable" class="table table-striped" data-toggle="data-table">
                     <thead>
                        <tr>
                        <th>#</th>
                    <th >Phone Number</th>
                    <th>Last Message</th>
                    <th>Time</th>
                    <th>Bots Chat</th>
                    <th>Agent Chat</th>
                        </tr>
                     </thead>
                     <tbody>
                    
                     <?php
        $query="SELECT * from testtbl group by sender ORDER BY created DESC";
		$result=mysqli_query($conn,$query);
		if($result->num_rows)
		{
		$sno=1;	
		while($row=mysqli_fetch_assoc($result))
		{
		$sender=$row['sender'];
		
		$query2="SELECT * FROM `testtbl` WHERE sender='$sender' order by id DESC limit 1";
		$result2=mysqli_query($conn,$query2);
		if($result2->num_rows)
		{
		    
		$row2=mysqli_fetch_assoc($result2);
		$phone=$row2['sender'];
		?>
                      <tr>
                     <td><?php echo $sno++; ?></td>
                    <td><?php echo $row2['sender']?></td>
                    <td><?php echo $row2['message']?></td>
                    <td><?php echo $row2['created']?></td>
                    <td><a href="view_all_messages.php?sender=<?php echo $phone;?>" target="_blank" class="btn btn-primary" style="font-size:11.1px;">Message</a></td>
                    <td><a href="view_all_messages_ag.php?sender=<?php echo $phone;?>" target="_blank" class="btn btn-primary" style="font-size:11.1px;">Message</a></td>
                    </tr>
                    <?php
		}
		}
		}
		?>



                        
                     </tbody>
                     
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
      </div>
<?php
include('footer.php');

?>

