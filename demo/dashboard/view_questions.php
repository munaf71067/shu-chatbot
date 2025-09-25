<?php
include('header.php')
?>
<style>
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9; /* Add striped rows */
    }

    /* Adjust table layout */
    #datatable {
        width: 100%; /* Make table full-width */
        table-layout: fixed; /* Fix table layout */
    }

    /* Set width for specific columns */
    #datatable th:nth-child(1),
    #datatable td:nth-child(1),
    #datatable th:nth-child(2),
    #datatable td:nth-child(2),
    #datatable th:nth-child(3),
    #datatable td:nth-child(3),
    #datatable th:nth-child(6),
    #datatable td:nth-child(6) {
        width: 10%; /* Adjust width for specific columns */
    }

    /* Set width for Title and Question columns */
    #datatable th:nth-child(4),
    #datatable td:nth-child(4),
    #datatable th:nth-child(5),
    #datatable td:nth-child(5) {
        width: 25%; /* Adjust width for Title and Question columns */
    }

    /* Hide overflow and apply ellipsis */
    #datatable td {
        overflow: hidden;
        text-overflow: ellipsis;
    }
    @media (max-width: 375px) {
        /* Adjust column widths */
        #datatable th,
        #datatable td {
            width: auto;
            display: block;
            text-align: left;
        }

        /* Hide table headers */
        #datatable th {
            display:block;
        }

        /* Ensure actions column takes full width */
        #datatable td:nth-child(6) {
            width: 100%;
        }
    }
    .btn 
   {
      --bs-btn-padding-y: 0.1rem;
      --bs-btn-padding-x: 0.6rem
   }
</style>

<!-- <style>
    .table-responsive {
        overflow-x: hidden;
        overflow-y: Auto; /* Disable vertical scrolling */
    }

    /* Adjust table layout */
    #datatable {
        width: 100%; /* Make table full-width */
    }

    /* Remove table cell wrapping */
    #datatable td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style> -->

<!-- <div class="iq-navbar-header" style="height: 215px;">
              <div class="container-fluid iq-container">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="flex-wrap d-flex justify-content-between align-items-center">
                              <div>
                                  <h1>Hello Devs!</h1>
                                  <p>We are on a mission to help developers like you build successful projects for FREE.</p>
                              </div>
                              <div>
                                  <a href="" class="btn btn-link btn-soft-light">
                                      <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M11.8251 15.2171H12.1748C14.0987 15.2171 15.731 13.985 16.3054 12.2764C16.3887 12.0276 16.1979 11.7713 15.9334 11.7713H14.8562C14.5133 11.7713 14.2362 11.4977 14.2362 11.16C14.2362 10.8213 14.5133 10.5467 14.8562 10.5467H15.9005C16.2463 10.5467 16.5263 10.2703 16.5263 9.92875C16.5263 9.58722 16.2463 9.31075 15.9005 9.31075H14.8562C14.5133 9.31075 14.2362 9.03619 14.2362 8.69849C14.2362 8.35984 14.5133 8.08528 14.8562 8.08528H15.9005C16.2463 8.08528 16.5263 7.8088 16.5263 7.46728C16.5263 7.12575 16.2463 6.84928 15.9005 6.84928H14.8562C14.5133 6.84928 14.2362 6.57472 14.2362 6.23606C14.2362 5.89837 14.5133 5.62381 14.8562 5.62381H15.9886C16.2483 5.62381 16.4343 5.3789 16.3645 5.13113C15.8501 3.32401 14.1694 2 12.1748 2H11.8251C9.42172 2 7.47363 3.92287 7.47363 6.29729V10.9198C7.47363 13.2933 9.42172 15.2171 11.8251 15.2171Z" fill="currentColor"></path>
                                          <path opacity="0.4" d="M19.5313 9.82568C18.9966 9.82568 18.5626 10.2533 18.5626 10.7823C18.5626 14.3554 15.6186 17.2627 12.0005 17.2627C8.38136 17.2627 5.43743 14.3554 5.43743 10.7823C5.43743 10.2533 5.00345 9.82568 4.46872 9.82568C3.93398 9.82568 3.5 10.2533 3.5 10.7823C3.5 15.0873 6.79945 18.6413 11.0318 19.1186V21.0434C11.0318 21.5715 11.4648 22.0001 12.0005 22.0001C12.5352 22.0001 12.9692 21.5715 12.9692 21.0434V19.1186C17.2006 18.6413 20.5 15.0873 20.5 10.7823C20.5 10.2533 20.066 9.82568 19.5313 9.82568Z" fill="currentColor"></path>
                                      </svg>
                                      Announcements
                                  </a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="iq-header-img">
                  <img src="../../assets/images/dashboard/top-header.png" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
                  <img src="../../assets/images/dashboard/top-header1.png" alt="header" class="theme-color-purple-img img-fluid w-100 h-100 animated-scaleX">
                  <img src="../../assets/images/dashboard/top-header2.png" alt="header" class="theme-color-blue-img img-fluid w-100 h-100 animated-scaleX">
                  <img src="../../assets/images/dashboard/top-header3.png" alt="header" class="theme-color-green-img img-fluid w-100 h-100 animated-scaleX">
                  <img src="../../assets/images/dashboard/top-header4.png" alt="header" class="theme-color-yellow-img img-fluid w-100 h-100 animated-scaleX">
                  <img src="../../assets/images/dashboard/top-header5.png" alt="header" class="theme-color-pink-img img-fluid w-100 h-100 animated-scaleX">
              </div>
          </div>          Nav Header Component End -->
        <!--Nav End-->
      </div>
      <div class="conatiner-fluid content-inner mt-n6 mt-2 py-0">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            
        <div class="card-body">
    <!-- <p>Images in Bootstrap are made responsive with <code>.img-fluid</code>. <code>max-width: 100%;</code> and <code>height: auto;</code> are applied to the image so that it scales with the parent element.</p> -->
    <div class="table-responsive">
        <table id="datatable" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Parent</th>
                    <th>Conv_id</th>
                    <th>Title</th>
                    <th>Question</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = view_data('questions');
                $sno = 1;
                $sql = '';
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $parent_id = $row['parent'];
                ?>
                    <tr>
                        <td><?php echo $sno++; ?></td>
                        <td><?php

                            $query2 = "SELECT * from questions WHERE parent='$parent_id'";
                            $result2 = mysqli_query($conn, $query2);
                            if ($result2->num_rows) {

                                $row2 = mysqli_fetch_assoc($result2);

                                if ($row['parent'] == '0') {
                                    echo 'hi';
                                } elseif ($row['parent'] != '0') {

                                    $query2 = "SELECT * from questions WHERE id='$parent_id'";
                                    $result2 = mysqli_query($conn, $query2);
                                    if ($result2->num_rows) {

                                        $row2 = mysqli_fetch_assoc($result2);
                                        $parent2 = $row2['parent'];
                                        $query3 = "SELECT * from questions WHERE id='$parent2'";
                                        $result3 = mysqli_query($conn, $query3);
                                        if ($result3->num_rows) {
                                            $row3 = mysqli_fetch_assoc($result3);
                                            $parent3 = $row3['parent'];

                                            $query4 = "SELECT * from questions WHERE id='$parent3'";
                                            $result4 = mysqli_query($conn, $query4);
                                            if ($result4->num_rows) {
                                                $row4 = mysqli_fetch_assoc($result4);
                                                $parent4 = $row4['parent'];

                                                $query5 = "SELECT * from questions WHERE id='$parent4'";
                                                $result5 = mysqli_query($conn, $query5);
                                                if ($result5->num_rows) {
                                                    $row5 = mysqli_fetch_assoc($result5);
                                                    $parent5 = $row5['parent'];

                                                    $query6 = "SELECT * from questions WHERE id='$parent5'";
                                                    $result6 = mysqli_query($conn, $query6);
                                                    if ($result6->num_rows) {
                                                        $row6 = mysqli_fetch_assoc($result6);
                                                        echo ' hi->' . $row6['title'] . '->' . $row5['title'] . '->' . $row4['title'] . '->' . $row3['title'] . '->' . $row2['title'] . '->' . $row['title'];
                                                    } else {
                                                        echo  ' hi->' . $row5['title'] . '->' . $row4['title'] . '->' . $row3['title'] . '->' . $row2['title'] . '->' . $row['title'];
                                                    }
                                                } else {
                                                    echo ' hi->' . $row4['title'] . '->' . $row3['title'] . '->' . $row2['title'];
                                                }
                                            } else {

                                                echo ' hi->' . $row3['title'] . '->' . $row2['title'];
                                            }
                                        } else {
                                            echo ' hi->' . $row2['title'];
                                        }
                                    }
                                }
                            }

                            ?></td>
                        <td><?php echo $row['conv_id'] ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['questions']; ?></td>
                        <td><a href="edit_questions.php?edit_id=<?php echo $id ?>" class="btn btn-primary" style="font-size: 12px">Edit </a>
                            <!-- <a href="edit_questions.php?editsingle=<?php echo $id ?>" class="btn btn-warning" >Edit single </a> -->

                            <!-- <a  class="btn btn-danger" onclick="delete_reply(<?php echo $id; ?>)" >Delete</a> -->
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            <tfoot>
            </tfoot>
        </table>
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

        <?php
        include('footer.php')
        ?>
      <script>

          $(function () {
    $("#datatable").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
        "buttons": ["csv", "excel", "pdf", "print"],
        pageLength: 10,
        "aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
});

function delete_reply(id)
{
    $.ajax({
        url: "ajax_data.php",
        cache: false,
        type: "GET",
        data: {delete_id : id},
        success: function(data){

            setTimeout(function () {
                alert(data);

                location.reload(true);
            }, 500);

        }
    });
}
</script>
