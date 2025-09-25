<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<?php
include  'header.php';
?>
    <style>
#pdf_label{
    padding: 10px;
    background: none;
    display: table;
    color: black;
    font-size:15px;
     }
     #image_label{
    padding: 10px;
    background: none;
    display: table;
    color: black;
    font-size:15px;
     }



#image[type="file"] {
    display: none;
}

#pdf[type="file"] {
    display: none;
}
#pdf_label,
    #image_label {
        padding: 10px;
        background: none;
        display: table;
        color: black;
    }

    #image[type="file"],
    #pdf[type="file"] {
        display: none;
    }


    @media (max-width: 576px) {
    .form-group9 {
        flex-direction: column;
    }

    .row.rounded-pill {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    .text-center {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
}

/* Extra small screens (e.g., small smartphones) */
@media (min-width: 375px) and  (max-width:479px) {
    /* Hide certain elements on smaller screens */
    .new1 {
        display: none;
    }

    .new2 {
        /* margin-left: -20px; */
        margin-bottom: 20px;
    }
  .new3{
    position: relative;
    left:70px;
  }
  .rownew{
    position: relative;
    left:34px;
  }
  .btns{
    position: relative;
    left:34px;
  }
  .camera{
    position: relative;
    top:10px;
    left:-10px;


  }
  .pdf{
    position:relative;
    bottom:30px;
    left:60px;

  }
  .status{
    position:relative;
    left:25px;
    bottom:20px;

  }
  .add{
    position:relative;
    left:30px;
  }
  #image_label{
    font-size:20px;
  }
  #pdf_label{
    font-size:20px;
  }
}
@media (min-width:480px) and (max-width:767px){
    /* Hide certain elements on smaller screens */
    .new1 {
        display: none;
    }

    .new2 {
        /* margin-left: -20px; */
        margin-bottom: 20px;
    }
  .new3{
    position: relative;
    left:70px;
  }
  .rownew{
    position: relative;
    left:34px;
  }
  .btns{
    position: relative;
    left:34px;
  }
  .camera{
    position: relative;
    top:10px;
    left:-10px;


  }
  .pdf{
    position:relative;
    bottom:30px;
    left:60px;

  }
  .status{
    position:relative;
    left:25px;
    bottom:20px;

  }
  .add{
    position:relative;
    left:30px;
  }
  #image_label{
    font-size:20px;
  }
  #pdf_label{
    font-size:20px;
  }
}
</style>

    <script>

/**/$(document).on('click', '.btn-add', function(e)
      {

            var row_id = $(this).attr('id');
            var row_arr = row_id.split('_');
            //make new row
            var newrow_counter =  parseInt(row_arr[1]) + 1;



        var row =  '  <div class=" fvrduplicate row" style="margin-bottom:5px; margin-left:50px;">  '
        row +=      ' <div class="form-group9 col-12 col-sm-1"  style="color:black;"><p class="item_no" style="font-size:12px; font-weight:700;">1<p></div>'

        row +=      '    <div class="form-group9 col-12 col-sm-1 new3 " style="margin-left:-30px; width:180px;"> '
        row +=      '   <input style=" height:30px;" type="text" class="form-control chk-error" required row-id="'+newrow_counter+'" id="title_'+newrow_counter+'" name="title['+newrow_counter+']"  placeholder="Title">'
        row +=      '    </div>'

        row +=      '  <div class="form-group9 col-12 col-sm-2 new3" style="margin-left:-30px; width:180px;">  '
        row +=      '   <input style=" height:30px;" type="text" class="form-control chk-error"  row-id="'+newrow_counter+'" id="conv_id_'+newrow_counter+'" name="conv_id['+newrow_counter+']" placeholder="Conv_id"> '
        row +=      '   </div>'

        row +=      '  <div class="form-group9 col-12 col-sm-2 new3"  style="margin-left:-30px; width:180px;">'
        row +=      ' <input style=" height:30px;" type="text" class="form-control chk-error"  row-id="0" id="question_0"  required row-id="'+newrow_counter+'" id="ques_'+newrow_counter+'" name="question['+newrow_counter+']" placeholder="Questions">'
        row +=    '</div>'

        row +=   ' <div class="form-group9 col-12 col-sm-2 new3" style="margin-left:-30px; width:180px;"  required >'
        row +=     '<select style="height:30px;" class="form-control" name="input_type['+newrow_counter+']" required > '
        row +=        '<option  value="">Select Type</option>'
        row +=        '<option value="image">Image</option>'
        row +=        '<option value="text">Text</option>'
        row +=        '<option value="pdf">PDF</option>'
        row +=      '</select>'
        row +=       '</div>'
        row +=   '<div class="form-group9 col-12 col-sm-1 camera" style="margin-left:-15px;">'
        row +=    ' <label id="image_label" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">'
        row +=     '  <i class="fa fa-camera" aria-hidden="true"></i> '
        row +=      '<input type="file" id="image" class="form-control chk-error" onchange="loadFiless(event,'+newrow_counter+')" row-id="'+newrow_counter+'" id="image_'+newrow_counter+'" name="image['+newrow_counter+']" placeholder="Questions">'
        // row +=      '<img id="output_'+newrow_counter+'" width="30"  style="height:30"/>'
        row +=      '</label>'
        row +=   '</div>'


        row +=   '<div class="form-group9 col-12 col-sm-1 pdf" style="margin-left:-30px;" >'
        row +=  ' <label id="pdf_label" style="display: flex; justify-content: center; align-items: center; ">'
        row +=   '   <i class="fa fa-file-pdf" aria-hidden="true"></i>'
        row +=      '<input type="file" id="pdf" class="form-control chk-error" row-id="'+newrow_counter+'" id="pdf_file_'+newrow_counter+'" name="pdf_file['+newrow_counter+']" placeholder="Questions">'
        row +=   '</label>'
        row +=   '</div>'

        row +=   ' <div class="form-group9 col-12 col-sm-1  status" style="margin-left:-15px; width:100px;"  required>'
        row +=   '     <select style=" height:30px;" class="form-control new3" row-id="'+newrow_counter+'" name="status['+newrow_counter+']">'
        row +=   '       <option  value="">Status</option>'
        row +=   '      <option value="A">A</option>'
        row +=   '      <option value="D">D</option>'

        row +=   '   </select>'

        row +=   '        </div>'
        row +=   '<div class="form-group9 col-12 col-sm-1 new3"  style="margin-left:-5px;">'
        row +=         '<button style="width:40px;" class="btn btn-primary btn-add pro-row rounded-pill add" type="button" id="r_'+newrow_counter+'";><i class="fa fa-plus" style="font-size:9px; margin-left:-5px;" ></i></button>'
        row +=   '</div>'
        row += '</div>',






            e.preventDefault();
            $( ".fvrclone" ).append(row);
                $(this).removeClass('btn-add').addClass('btn-remove').removeClass('btn-primary').addClass('btn-danger')
                .html('<i class="fa fa-minus" style="font-size:9px; margin-left:-5px;" ></i>');

            var product_amt = 0;
            //Calculate Totoal of 'Amount'
            $('.product_amount').each(function(){
                if($(this).val() != '') product_amt += parseFloat($(this).val());
            });

            $('#net_total_amt').html(product_amt);

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
            var product_amt = 0;
            //Calculate Totoal of 'Amount'
            $('.product_amount').each(function(){
                if($(this).val() != '') product_amt += parseFloat($(this).val());
            });
            //console.log('.product_amount value is' + product_amt);
            $('#net_total_amt').html(product_amt);

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
            <form method="POST" action="question_process.php" enctype="multipart/form-data">
                <h6 class="white mb-1">Intro Message &nbsp;</h6>
                <br>
                <textarea id="w3review" class="form-control" name="intro_message" rows="2" cols="50" style="width:100%; margin-left:-7px;"></textarea>
            </div>

        <div class="col-lg-6"> <!-- Right column for Add Question -->
    <div class="mx-auto mt-3"> <!-- Center the content horizontally and add top margin -->
        <h6 class="white mb-1">Add Question</h6>
        <!-- <h6 class="white">[you can create questions]</h6> -->

        <select style="margin-top:20px; margin-left:8px" class="js-example-placeholder-single js-states form-control new2" name="parent">
            <option value="0" selected>Select Question</option>
            <?php show_questions(); ?>
        </select>
    </div>
</div>



<br>


<div class="container rounded" style="background: #6190e8; /* fallback for old browsers */
  background: -webkit-linear-gradient(to right, #6190e8, #a7bfe8); /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(to right, #6190e8, #a7bfe8); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */ "> ">



    <div class="row btn-div" style="margin: 0px -33px; width:100%;">

        <!-- <div class="row rounded-pill" style="margin-bottom:10px; margin-left:33px; background:#3a57e8; color:#fff; padding-top:10px; height:35px;">
            <div class="col-xs-2 col-sm-1"><b >S.No</b></div>
            <div class="col-xs-2 col-sm-1 new1" style="width:160px; margin-left:12px;" ><b style="margin-left:20px;" >Title</b></div>
            <div class="col-xs-2 col-sm-1 new1" style="width:160px; margin-left:-28px;" ><b style="margin-left:40px;">Conv_id</b></div>
            <div class="col-xs-2 col-sm-1 new1" style="width:190px; margin-left:-30px;"><b style="margin-left:70px;" >Questions</b></div>
            <div class="col-xs-2 col-sm-1 new1" style="width:170px; margin-left:-29px;"><b style="margin-left:80px;">Input</b></div>
            <div class="col-xs-2 col-sm-1 new1" style="width:60px; margin-left:-20px;"><b style="margin-left:20px;">Image</b></div>
            <div class="col-xs-2 col-sm-1 new1" style="width:60px; margin-left:-4px;" ><b style="margin-left:20px;">PDF</b></div>
            <div class="col-xs-2 col-sm-1 new1" style="width:150px; margin-left:-4px;" ><b style="margin-left:20px;">Status</b></div>
            <div class="col-xs-2 col-sm-1 new1" style="margin-left:-35px"><b>ACTION</b></div>
        </div> -->
        <!-- <div class="row rounded-pill" style="margin-bottom:10px; margin-left:33px; background:#3a57e8; color:#fff; padding-top:10px; height:35px;">
    <div class="col-1 col-sm-1"><b>S.No</b></div>
    <div class="col-2 col-sm-1 new1" style="width:160px; margin-left:12px;"><b style="margin-left:20px;">Title</b></div>
    <div class="col-2 col-sm-1 new1" style="width:160px; margin-left:-28px;"><b style="margin-left:40px;">Conv_id</b></div>
    <div class="col-2 col-sm-1 new1" style="width:190px; margin-left:-30px;"><b style="margin-left:70px;">Questions</b></div>
    <div class="col-2 col-sm-1 new1" style="width:170px; margin-left:-29px;"><b style="margin-left:80px;">Input</b></div>
    <div class="col-1 col-sm-1 new1" style="width:60px; margin-left:-20px;"><b style="margin-left:20px;">Image</b></div>
    <div class="col-1 col-sm-1 new1" style="width:60px; margin-left:-4px;"><b style="margin-left:20px;">PDF</b></div>
    <div class="col-1 col-sm-1 new1" style="width:150px; margin-left:-4px;"><b style="margin-left:20px;">Status</b></div>
    <div class="col-1 col-sm-1 new1" style="margin-left:-35px"><b>ACTION</b></div>
</div>


<div class="">
            <div class="fvrduplicate row" style="margin-bottom:5px;  margin-left:40px;" >
                <div class="form-group9 col-xs-2 col-sm-1" style="color:black; width:20px; margin-right:-10px;"><p class='item_no' style="font-size:12px; font-weight:700;">1</p></div>
                <div class="form-group9 col-xs-2 col-sm-1" style="width:200px;  margin-left:12px;">
                    <input style=" height:30px; "  type="text" class="form-control chk-error" required row-id='0' id="title_0" name="title[0]" placeholder='Title'>
                </div>
                <div class="form-group9 col-xs-2 col-sm-1" style="width:190px; margin-left:-28px;">
                    <input style=" height:30px;" type="text" class="form-control chk-error"  row-id='0' id="conv_id_0" name="conv_id[0]" placeholder="Conv_id">
                </div>
                <div class="form-group9 col-xs-2 col-sm-1" style="width:190px; margin-left:-30px;">
                    <input style=" height:30px;" type="text" class="form-control chk-error"  row-id='0' id="question_0" name="question[0]" placeholder="Questions">
                </div>
                <div class="form-group9 col-xs-2 col-sm-1" style="width:180px; margin-left:-29px;">
                    <select style="height:30px;" class="form-control" name="input_type[0]">
                        <option  value="">Select Type</option>
                        <option value="image">Image</option>
                        <option value="text">Text</option>
                        <option value="pdf">PDF</option>
                    </select>
                </div>
                <div class="form-group9 col-xs-2 col-sm-1" style="width:60px; margin-left:-28px;">
                    <label id="image_label" style="display: flex; justify-content: center; align-items: center;">
                        <i class="fa fa-camera" aria-hidden="true"></i>
                        <input type="file" class="form-control" name="image[0]" onchange="loadFile(event)" style="display: none;">
                    </label>
                </div>
                <div class="form-group9 col-xs-2 col-sm-1"style="width:60px; margin-left:-4px;">
                    <label id="pdf_label" style="display: flex; justify-content: center; align-items: center;">
                        <i class="fa fa-file-pdf" aria-hidden="true"></i>
                        <input type="file" class="form-control" name="pdf_file[0]" style="display: none;">
                    </label>
                </div>
                <div class="form-group9 col-xs-2 col-sm-1"  style="width:120px; margin-left:-25px;">
                    <select style="height:30px;" class="form-control" name="status[0]">
                        <option  value="">Status</option>
                        <option value="A">A</option>
                        <option value="D">D</option>
                    </select>
                </div>
                <div class="form-group9 col-xs-2 col-sm-1" style="margin-left:-9px;">
                    <button style="width:40px;" class="btn btn-primary btn-add pro-row rounded-pill" type="button" id="r_0"><i class="fa fa-plus" style="font-size:9px; margin-left:-5px;"></i></button>
                </div>
            </div>
            <div class="fvrclone"></div>
        </div>

    </div>

    <div class="text-center" style="margin-top:20px;">
        <button style="width:100px; font-size:12px; font-weight:700; margin-left:-5px;" class="btn btn-primary rounded-pill" type="submit" name="question_submit">Submit</button>
    </div>

</div> -->
<div class="row rounded-pill rownew" style="margin-bottom:10px; margin-left:33px; background:#3a57e8; color:#fff; padding-top:10px; height:35px;">
    <div class="col-1 col-sm-1 "><b>S.No</b></div>
    <div class="col-2 col-sm-1 new1" style="width:160px; margin-left:12px;"><b style="margin-left:20px;">Title</b></div>
    <div class="col-2 col-sm-1 new1" style="width:160px; margin-left:-28px;"><b style="margin-left:40px;">Conv_id</b></div>
    <div class="col-2 col-sm-1 new1" style="width:190px; margin-left:-30px;"><b style="margin-left:70px;">Questions</b></div>
    <div class="col-2 col-sm-1 new1" style="width:170px; margin-left:-29px;"><b style="margin-left:80px;">Input</b></div>
    <div class="col-1 col-sm-1 new1" style="width:60px; margin-left:-20px;"><b style="margin-left:20px;">Image</b></div>
    <div class="col-1 col-sm-1 new1" style="width:60px; margin-left:-4px;"><b style="margin-left:20px;">PDF</b></div>
    <div class="col-1 col-sm-1 new1" style="width:150px; margin-left:-4px;"><b style="margin-left:20px;">Status</b></div>
    <div class="col-1 col-sm-1 new1" style="margin-left:-35px"><b>ACTION</b></div>
</div>

<div class="">
    <div class="fvrduplicate row" style="margin-bottom:5px; margin-left:50px;">
        <div class="form-group9 col-12 col-sm-1 " style="color:black;"><p class='item_no' style="font-size:12px; font-weight:700;">1</p></div>
        <div class="form-group9 col-12 col-sm-1 new3 " style= "width:180px; margin-left:-30px;">
            <input style="height:30px;" type="text" class="form-control chk-error" required row-id='0' id="title_0" name="title[0]" placeholder='Title'>
        </div>
        <div class="form-group9 col-12 col-sm-2 new3" style="margin-left:-30px; width:180px;">
            <input style="height:30px;" type="text" class="form-control chk-error" row-id='0' id="conv_id_0" name="conv_id[0]" placeholder="Conv_id">
        </div>
        <div class="form-group9 col-12 col-sm-2 new3" style="margin-left:-30px; width:180px;">
            <textarea style="height:0px; min-height: 31px"  type="text" class="form-control chk-error" row-id='0' id="question_0" name="question[0]" placeholder="Questions"></textarea>
        </div>
        <div class="form-group9 col-12 col-sm-2 new3" style="margin-left:-30px; width:180px;">
            <select style="height:30px;" class="form-control" name="input_type[0]">
                <option value="">Select Type</option>
                <option value="image">Image</option>
                <option value="text">Text</option>
                <option value="pdf">PDF</option>
            </select>
        </div>
        <div class="form-group9 col-12 col-sm-1 camera " style="margin-left:-15px;">
            <label id="image_label" style="display: flex; justify-content: center; align-items: center;">
                <i class="fa fa-camera" aria-hidden="true"></i>
                <input type="file" class="form-control" name="image[0]" onchange="loadFile(event)" style="display: none;">
            </label>
        </div>
        <div class="form-group9 col-12 col-sm-1 pdf" style="margin-left:-30px;">
            <label id="pdf_label" style="display: flex; justify-content: center; align-items: center;">
                <i class="fa fa-file-pdf" aria-hidden="true"></i>
                <input type="file" class="form-control" name="pdf_file[0]" style="display: none;">
            </label>
        </div>
        <div class="form-group9 col-12 col-sm-1  status" style="margin-left:-15px; width:100px;">
            <select style="height:30px;" class="form-control new3" name="status[0]">
                <option value="">Status</option>
                <option value="A">A</option>
                <option value="D">D</option>
            </select>
        </div>
        <div class="form-group9 col-12 col-sm-1 new3" style="margin-left:-5px;">
            <button style="width:40px;" class="btn btn-primary btn-add pro-row rounded-pill add" type="button" id="r_0"><i class="fa fa-plus" style="font-size:9px; margin-left:-5px;"></i></button>
        </div>
    </div>
    <div class="fvrclone"></div>
</div>

<div class="text-center btns" style="margin-top:20px;">
    <button style="width:100px; font-size:12px; font-weight:700; margin-left:-5px;" class="btn btn-primary rounded-pill" type="submit" name="question_submit">Submit</button>
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
    placeholder: "Select a parent",
    allowClear: true
});
</script>
<script>
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
</script>
