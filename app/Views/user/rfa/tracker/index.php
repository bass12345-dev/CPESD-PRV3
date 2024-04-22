<!doctype html>
<html class="no-js" lang="en">

<head>
    <?php echo view('includes/meta.php') ?>
    <?php echo view('includes/css.php') ?> 
</head>

<body>
   
 
    <div class="page-container">       
    <?php echo view('includes/sidebar.php') ?> 
        <div class="main-content">           
            <?php echo view('includes/topbar.php') ?>           
            <?php echo view('includes/breadcrumbs.php') ?> 
                <div class="main-content-inner">
                    <div class="row">
                        <div class="col-12 mt-5">
                            <div class="card " style="border: 1px solid;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <div class="row">
                                                <div class="col-md-12"> 
                                                   
                                                    <button  class="btn  mb-3 mt-2 sub-button pull-right mr-2" id="reload_user_pending_transaction" > Reload <i class="ti-loop"></i></button>
                                                </div>
                                            </div>
                                            <div class="data-tables">
                                                <table id="pending_transactions_table" style="width:100%" class="text-center stripe">
                                                    <thead class="bg-light text-capitalize">
                                                        <tr>
                                                            <th>PMAS NO</th>
                                                            <th>Date & Time Filed</th>
                                                            <!-- <th>Responsible Section</th> -->
                                                            <th>Type of Activity</th>
                                                            <!-- <th>Responsibility Center</th> -->
                                                            <!-- <th>Date And Time</th> -->
                                                            <th>Person Responsible</th>
                                                             <th>Status</th>
                                                            <th>Actions</th>  
                                                        </tr>
                                                    </thead> 
                                                </table>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>     

<?php echo view('user/transactions/pending/modals/view_remark_modal') ?>  
<?php echo view('includes/scripts.php') ?>  
<script>
      


    $(document).on('click','button#reload_user_pending_transaction',function (e) {

        $('#pending_transactions_table').DataTable().destroy();
        fetch_user_pending_transactions()
})


     $(document).on('click','a#view-remarks',function (e) {


             $.ajax({
                    type: "POST",
                    url: base_url + 'api/view-remark',
                    data: {id : $(this).data('id')},
                    dataType: 'json',
                    beforeSend: function() {
                         
                           $('div#remarks').addClass('.loader');
                    },
                    success: function(data)
                    {            
                        $("#view_remarks_modal").modal('show');
                        $('div#remarks').find('p').html(data.remarks);
                        $('input[name=t_id]').val(data.transaction_id);

                    }
            })
   
        });



    function fetch_user_pending_transactions(){

           $.ajax({
            url: base_url + 'api/user/get-user-pending-transactions',
            type: "POST",
            dataType: "json",
            success: function(data) {

                
                    $('#pending_transactions_table').DataTable({

                    scrollY: 800,
                    scrollX: true,
                    "ordering": false,
                    "data": data,
                    'columns': [
            {
                // data: "song_title",
                data: null,
                render: function (data, type, row) {
                    return '<b><a href="javascript:;"   data-id="'+data['res_center_id']+'"  style="color: #000;"  >'+data['pmas_no']+'</a></b>';
                }

            },
             {
                // data: "song_title",
                data: null,
                render: function (data, type, row) {
                    return '<a href="javascript:;"   data-id="'+data['res_center_id']+'"  style="color: #000;"  >'+data['date_and_time_filed']+'</a>';
                }

            },
            //  {
            //     // data: "song_title",
            //     data: null,
            //     render: function (data, type, row) {
            //         return '<a href="javascript:;"   data-id="'+data['res_center_id']+'"  style="color: #000;"  >'+data['responsible_section']+'</a>';
            //     }

            // },
             {
                // data: "song_title",
                data: null,
                render: function (data, type, row) {
                    return '<a href="javascript:;"   data-id="'+data['res_center_id']+'"  style="color: #000;"  >'+data['type_of_activity_name']+'</a>';
                }

            },
            //  {
            //     // data: "song_title",
            //     data: null,
            //     render: function (data, type, row) {
            //         return '<a href="javascript:;"   data-id="'+data['res_center_id']+'"  style="color: #000;"  >'+data['responsibility_center']+'</a>';
            //     }

            // },
            //  {
            //     // data: "song_title",
            //     data: null,
            //     render: function (data, type, row) {
            //         return '<a href="javascript:;"   data-id="'+data['res_center_id']+'"  style="color: #000;"  >'+data['date_and_time']+'</a>';
            //     }

            // },
            {
                // data: "song_title",
                data: null,
                render: function (data, type, row) {
                    return '<a href="javascript:;"   data-id="'+data['res_center_id']+'"  style="color: #000;"  >'+data['name']+'</a>';
                }

            },

              {
                // data: "song_title",
                data: null,
                render: function (data, type, row) {
                    return row.s;
                }

            },
            
             

            {
                // data: "song_title",
                data: null,
                render: function (data, type, row) {
                    return row.action;
                }

            },
          ]

                })


            }

        })
    }

      $(document).on('click','button#btn-done-remarks',function (e) {
            e.preventDefault();

        var id = $('input[name=t_id]').val();

             Swal.fire({
        title: "",
        text: "Confirm",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {



         $.ajax({
            type: "POST",
            url: base_url + 'api/accomplished',
            data: {id : id},
            dataType: 'json',
            beforeSend: function() {
               $('button#btn-done-remarks').html('<div class="loader"></div>');
                $('button#btn-done-remarks').prop("disabled", true);
            },
            success: function(data)
            {            
                if (data.response) {
             
                    $('button#btn-done-remarks').prop("disabled", false);
                    $('button#btn-done-remarks').text('Done');
                        Toastify({
                                  text: 'Success',
                                  className: "info",
                                  style: {
                                    "background" : "linear-gradient(to right, #00b09b, #96c93d)",
                                    "height" : "60px",
                                    "width" : "350px",
                                    "font-size" : "20px"
                                  }
                                }).showToast();

                      
                        $('#view_remarks_modal').modal('hide')
                       $('#pending_transactions_table').DataTable().destroy();
                       fetch_user_pending_transactions();
                         
                         
                        
                           
             
                }else {
                    $('button#btn-done-remarks').prop("disabled", false);
                    $('button#btn-done-remarks').text('Submit');
                      Toastify({
                                  text: data.message,
                                  className: "info",
                                  style: {
                                    "background" : "linear-gradient(to right, #00b09b, #96c93d)",
                                    "height" : "60px",
                                    "width" : "350px",
                                    "font-size" : "20px"
                                  }
                                }).showToast();

                       
                   
                }

                
           },

            error: function(xhr) { // if error occured
                alert("Error occured.please try again");
                 $('.button#btn-done-remarks').prop("disabled", false);
                 $('.button#btn-done-remarks').text('Submit');
            },
            
            })
         
       



        } else if (result.dismiss === "cancel") {
           swal.close()

        }
    });

        });



  

    fetch_user_pending_transactions();
</script> 
</body>
</html>
