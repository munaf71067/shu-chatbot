<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="assets/css/add.css">
<?php
include  'header.php';
?>
    <style>

/* Extra small screens (e.g., small smartphones) */

</style>

    <script>

$(document).on('click', '.btn-add', function(e)
      {

            var row_id = $(this).attr('id');
            var row_arr = row_id.split('_');
            //make new row
            var newrow_counter =  parseInt(row_arr[1]) + 1;



        var row =  '  <div class=" fvrduplicate row" style="margin-bottom:0px; margin-left:50px;">  '
        row +=      ' <div class="form-group9 col-12 col-sm-1"  style="color:black;"><p class="item_no" style="font-size:12px; font-weight:700;">1<p></div>'

        row +=      '    <div class="form-group9 col-12 col-sm-1 new3 " style="margin-left:-30px; width:740px;"> '
        row +=      '   <input style=" height:30px;" type="text" class="form-control chk-error" required row-id="'+newrow_counter+'" id="title_'+newrow_counter+'" name="title['+newrow_counter+']"  placeholder="Keyword">'
        row +=      '    </div>'

        row +=   '<div class="form-group9 col-12 col-sm-1 new3"  style="margin-left:-23px;">'
        row +=         '<button style="width:100px;" class="btn btn-primary btn-add pro-row rounded-pill add keybutton" type="button" id="r_'+newrow_counter+'";><i class="fa fa-plus" style="font-size:9px; margin-left:-5px;" ></i></button>'
        row +=   '</div>'
        row += '</div>',


        

            
        e.preventDefault();
            $( ".fvrclone" ).append(row);
                $(this).removeClass('btn-add').addClass('btn-remove').removeClass('btn-primary').addClass('btn-danger')
                .html('<i class="fa fa-minus" style="font-size:9px; margin-left:-5px;"></i> ');
                
   
            //update item no
            var $item_no = 1;
            $('.item_no').each(function(){
                $(this).html($item_no);
                $item_no++;
            });
            
        }).on('click', '.btn-remove', function(e)
        {
            $(this).parents('.fvrclonned').remove();
            $(this).parents('.fvrduplicate').remove();
        
            //update item no
            var $item_no = 1;
            $('.item_no').each(function(){
                $(this).html($item_no);
                $item_no++;
            });
            
            e.preventDefault();
            return false;
        });

    </script>


    <!--Main layout-->

    <main>
    <div class="container-fluid content-inner mt-n9 mt-2 py-0">
        <div class="row">
            <div class="col-lg-6">
            <?php
            if(isset($_GET['mesg'])) {
            ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_GET['mesg']; ?>
                <script>
                    setTimeout(function () {
                        window.location.href= 'add_replay.php'; // the redirect goes here
                    }, 5000);
                </script>
            </div>
            <?php } ?>


           <br>
           </div>

            <form method="POST" action="keyword_of_process.php" enctype="multipart/form-data">
                <!-- <h6 class="white mb-1">Intro Message &nbsp;</h6> -->
                
                <!-- <textarea id="w3review" class="form-control" name="intro_message" rows="2" cols="50" style="width:100%; margin-left:-7px;"></textarea> -->

        <div class="col-lg-6"> <!-- Right column for Add Question -->
    <div class="mx-auto mt-2"> <!-- Center the content horizontally and add top margin -->
        <h6 class="white mb-1">Add Question</h6>
        <!-- <h6 class="white">[you can create questions]</h6> -->

        <select style="margin-top:20px; margin-left:8px" class="js-example-placeholder-single js-states form-control new2" onchange="show_q(this.value)" name="question">
            <option value="0" selected>Select Question</option>
            <?php show_questions(); ?>
        </select>
    </div>
</div>




<br>

<p id="show_q"></p>

<div class="container p-2" style="border-radius:10px; background:#D3D3D3; background: #6190e8; /* fallback for old browsers */
  background: -webkit-linear-gradient(to right, #6190e8, #a7bfe8); /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(to right, #6190e8, #a7bfe8);">
    <div class="row btn-div" style="margin: 0px -33px; width:100%;">

<div class="row rounded-pill rownew" style="margin-bottom:10px; margin-left:33px; background:#3a57e8; color:#fff; padding-top:10px; height:35px;">
    <div class="col-1 col-sm-1 "><b>S.No</b></div>
    <div class="col-2 col-sm-1 new1" style="width:760px; margin-left:12px;"><b style="margin-left:20px;">Keywords</b></div>
    <div class="col-1 col-sm-1 new1" style="margin-left:-55px"><b>ACTION</b></div>
</div>

<div class="">
    <div class="fvrduplicate row" style="margin-bottom:0px; margin-left:50px;">
        <div class="form-group9 col-12 col-sm-1 " style="color:black;"><p class='item_no' style="font-size:12px; font-weight:700;">1</p></div>
        <div class="form-group9 col-12 col-sm-1 new3 " style= "width:740px; margin-left:-30px;">
            <input style="height:30px;" type="text" class="form-control chk-error" required row-id='0' id="title_0" name="title[0]" placeholder='Keyword'>
        </div>
       
        <div class="form-group9 col-12 col-sm-1 new3" style="margin-left:-23px;">
            <button style="width:100px;" class="btn btn-primary btn-add pro-row rounded-pill add keybutton" type="button" id="r_0"><i class="fa fa-plus" style="font-size:9px; margin-left:-5px;"></i></button>
        </div>
    </div>
    <div class="fvrclone"></div>
</div>

<div class="text-center btns" style="margin-top:20px;">
    <button style="width:100px; font-size:12px; font-weight:700; margin-left:-5px;" row-id="0" class="btn btn-primary rounded-pill" type="submit" name="question_submit">Submit</button>
</div>






</form>


<!-- </div>
</div>
</div>
</div>
</div> -->
    </main>
<?php
include 'footer.php';
?>
<script>

$(".js-example-placeholder-single").select2({
    placeholder: "Select a Question",
    allowClear: true
});
</script>
<script>
     var loadFile = function(event) {
    var output = document.getElementById('output');
    output.style.visibility = 'visible';

    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
  
  
   var loadFiless = function(event,id) {
    var output = document.getElementById('output_'+id);
    output.style.visibility = 'visible';

    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.style.visibility = 'visible';
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        }
    };

    var loadFiless = function(event, id) {
        var output = document.getElementById('output_' + id);
        output.style.visibility = 'visible';
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        }
    };

    function show_q(id){
    var id = id;
    var show_q="show_q"
     $.ajax({
  url: "ajax_data.php",
  type: "POST",
  data: {id:id,show_q:show_q},
  dataType: "html",
success:function(msg) {
$("#show_q").text(msg);
}
})
}
</script>
