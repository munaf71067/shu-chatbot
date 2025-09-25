<?php
include('header.php');
$sender=$_GET['sender'];
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
                    <th>#</th>
                    <th >Agent name</th>
                    <th>Messages</th>
                    <th>Time</th>
                    <th>Customer name</th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php
        $query="SELECT * from `req_to_agent` where  phone_no = '{$sender}'  ";
		$result=mysqli_query($conn,$query);
		if($result->num_rows)
		{
		// $sno=1;	
		while($row1=mysqli_fetch_assoc($result))
		{
            $query1="SELECT *,(SELECT Concat(`name`,' ' ,`lname`) FROM `user` WHERE id = u_id) as uname from `d_agent` where ra_id = '{$row1['ra_id']}'  ";
            $result1=mysqli_query($conn,$query1);
            if($result1->num_rows)
            {
            $sno=1;	
            while($row=mysqli_fetch_assoc($result1))
            {
		?>
        <tr>
       <td><?php echo $sno++; ?></td>
      <td><?php echo $row['uname']?></td>
      <td><?php echo $row['msgs']?></td>
      <td><?php echo $row['datetime']?></td>
      <td><?php if($row['uname']==""){echo $row1['name'];}?></td>
     </tr>
     <?php
		}
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

