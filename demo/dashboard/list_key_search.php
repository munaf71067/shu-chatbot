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
<div class="conatiner-fluid content-inner mt-n6 mt-2 py-0 " >
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
                    <th>Question</th>
                    <th>No of keywords</th>
                    <th >Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php
                            // $sender=$_GET['id']; 
        $query="SELECT *,(select count(s_id) from search where q_id = id GROUP by q_id) as no_key from questions where (select count(s_id) from search where q_id = id GROUP by q_id) >0";
		$result=mysqli_query($conn,$query);
		if($result->num_rows)
		{
		    $sno=1;
		
		while($row=mysqli_fetch_assoc($result))
		{
		
		    
		 ?>
                        <tr>
                           <td><?php echo $sno++; ?></td>
                           <td><?php echo $row['title']?></td>
                           <td><?php echo $row['no_key']?></td>
                           <td ><a href="edit_key_search.php?id=<?php echo $row['id']?>" class="btn btn-primary" style="font-size:11px;" >Edit </a></td>
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

