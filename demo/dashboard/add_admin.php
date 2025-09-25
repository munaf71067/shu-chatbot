<?php
include('header.php')
?>
<div class="conatiner-fluid content-inner mt-n6 mt-2 py-0">
<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title" style="font-size:16px">Create Admin</h4>
                    </div>
                </div>
                <div class="card-body">
                    <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam nibh finibus leo</p> -->
                    <form action="signup_process.php" method="POST">
                        <div class="form-group">
                            <label class="form-label" for="email">Name :</label>
                            <input type="text" class="form-control" id="name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pwd">Last Name :</label>
                            <input type="text" class="form-control" id="l_name" name="last_name">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pwd">Email :</label> <label class="form-label" for="pwd" style="color:red" id="vpemail"></label>
                            <input type="email"  id="email" onchange="email1(this.value)" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pwd">Password:</label>
                            <input type="password" class="form-control" id="password"  name="password">
                            
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pwd">Role :</label>
                            <!-- <input type="password" class="form-control" id="pwd"> -->
                            <select name="role"  id="role" class="form-control" required>
                            <option value="">Select Role</option>
                            <option value="1" >Admin</option>
                            <option value="2" >Operator</option>
                        </select>
                        </div>
                        <!-- <div class="checkbox mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                <label class="form-check-label" for="flexCheckDefault3">
                                    Remember me
                                </label>
                            </div>
                        </div> -->
                        <button type="submit" name="submit" style="font-size:12px" class="btn btn-primary">Create</button>
                        <!-- <button type="submit" class="btn btn-danger">cancel</button> -->
                    </form>
                </div>
            </div>
            </div>
            </div>
            </div>
            </div>


            <?php
include('footer.php')
?>
<script>
     
     function email1(val)
     {
           alert();
   $.ajax({
   url: "ajax_data.php",
   type: "post",
   data: {email : val,table : "user"},
   success: function(data){
   
     // setTimeout(function () {
     if(data ==1){
         
         alert("Already Registered Email");  
         $("#email").val("")
     }
     
          alert(data);
        
     //     location.reload(true);
     //   }, 500);
    
   }
 });
 }
 </script>
 