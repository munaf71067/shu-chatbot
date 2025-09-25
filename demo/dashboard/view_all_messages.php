<?php
$sender=$_GET['sender'];
include('header.php');

?>
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
                        <th scope="col">#</th>
                       <th scope="col" >Number</th>
                       <th scope="col">Message</th>
                       <th scope="col">Time</th>
                        </tr>
                     </thead>
                     <tbody>
                    
                     <?php
        $query="SELECT * from testtbl WHERE sender='$sender' ORDER BY id DESC";
		$result=mysqli_query($conn,$query);
		if($result->num_rows)
		{
		    $sno=1;
		
		while($row=mysqli_fetch_assoc($result))
		{
		
		    
		 ?>
                      <tr>
      <th scope="row"><?php echo $sno++; ?></th>
      <td><?php echo $row['sender']?></td>
     <td><?php echo $row['message']?></td>
     <td><?php echo $row['created']?></td>
     </tr>
                    <?php
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

