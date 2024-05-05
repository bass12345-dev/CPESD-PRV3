<!doctype html>
<html class="no-js" lang="en">

<head>
    <?php echo view('includes/meta.php') ?>
    <?php echo view('includes/css.php') ?> 
</head>

<body>
   <?php echo view('includes/preloader') ?> 
 
    <div class="page-container">       
    <?php echo view('includes/sidebar.php') ?> 
        <div class="main-content">           
            <?php echo view('includes/topbar.php') ?>           
            <?php echo view('includes/breadcrumbs.php') ?> 
                <div class="main-content-inner">
                    <div class="row">
                           <div class="col-12 mt-5">
                              <div class="card" style="border: 1px solid;">
                                 <div class="card-body">
                                    <div class="row">
                                                <div class="col-md-12"> 
                                                   
                                                    <button  class="btn  mb-3 mt-2 sub-button pull-right mr-2" id="reload_user_pending_rfa" > Reload <i class="ti-loop"></i></button>
                                                </div>
                                            </div>
                                    <div class="row">
                                       <?php echo view('user/rfa/pending/sections/pending_rfa_transactions_table'); ?>       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>  
<?php echo view('user/rfa/pending/modals/refer_to_modal'); ?>          
<?php echo view('includes/scripts.php') ?>   
<script type="text/javascript">


$(document).on('click', 'button#reload_user_pending_rfa', function (e) {
   $('#rfa_pending_table').DataTable().destroy();
   load_user_pending_rfa();
   count_total_rfa_pending();
   count_total_reffered_rfa()
});

function load_user_pending_rfa() {
   $('#rfa_pending_table').DataTable({
      responsive: false,
      "ordering": false,
      
      "ajax": {
         "url": base_url + 'api/get-user-pending-rfa',
         "type": "POST",
         "dataSrc": "",
      },

      'columns': [{
         data: "ref_number",
      }, {
         data: "name",
      }, {
         data: "address",
      }, {
         data: "type_of_request_name",
      }, {
         data: "type_of_transaction",
      }, {
         data: "date_time_filed",
      }, {
         data: "status1",
      },
      {
         data: "action1",
      }, ]
   });
}

$(document).on('click', 'a#received-document', function (e) {
   e.preventDefault();
   const id = $(this).data('id');
   Swal.fire({
      title: "",
      text: "Receive RFA",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes",
      cancelButtonText: "No, cancel!",
      reverseButtons: true
   }).then(function (result) {
      if (result.value) {
         $.ajax({
            type: "POST",
            url: base_url + 'api/received-rfa',
            data: {
               id: id
            },
            dataType: 'json',
            success: function (data) {
               if (data.response) {
                 ajax_toast(data.message,"info","linear-gradient(to right, #00b09b, #96c93d)");
               } else {
                  ajax_toast(data.message,"info","red");
               }
            },
            error: function (xhr) {
               alert("Error occured.please try again");
            },
         })
      } else if (result.dismiss === "cancel") {
         swal.close()
      }
   });
});



$(document).on('click', 'a.update_referred', function (e) {
   $('#update_refer_to_modal').modal('show');
   $('select[name=refer_to_id]').val($(this).data('user-id'));
   $('#update_refer_to_form').find('input[name=rfa_id]').val($(this).data('id'))
});


$('#update_refer_to_form').on('submit', function(e) {
    e.preventDefault();

            $.ajax({
            type: "POST",
            url: base_url + 'api/update-referral',
            data: $(this).serialize(),
            cache: false,
            dataType: 'json',
            beforeSend: function() {
                $('.btn-update-cso-status').text('Please wait...');
                $('.btn-update-cso-status').attr('disabled','disabled');
            },
             success: function(data)
            {            
                if (data.response) {
                   
                    $('.btn-update-cso-status').text('Update');
                    $('.btn-update-cso-status').removeAttr('disabled');
                    ajax_toast(data.message,"info","linear-gradient(to right, #00b09b, #96c93d)");
                    $('#update_refer_to_modal').modal('hide');
                    $('#rfa_pending_table').DataTable().destroy();
                    load_user_pending_rfa();

                }else {
                    
                    $('.btn-update-cso-status').text('Update');
                    $('.btn-update-cso-status').removeAttr('disabled');   
                    ajax_toast(data.message,"info","red");
                   
                }
           },
            error: function(xhr) { // if error occured
                alert("Error occured.please try again");
                $('.btn-update-cso-status').text('Update');
                $('.btn-update-cso-status').removeAttr('disabled');
            },


        });



    });


$(document).ready(function(){
    load_user_pending_rfa();
});


                       
                   

</script>
</body>
</html>
