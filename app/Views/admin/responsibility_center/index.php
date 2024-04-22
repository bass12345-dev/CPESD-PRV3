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
                    <?php echo view('admin/responsibility_center/sections/responsibility_center_table'); ?> 
                </div>
        </div>
    </div>
<?php echo view('admin/responsibility_center/modal/update_center') ?>     
<?php echo view('includes/scripts.php') ?> 
<script type="text/javascript">

 var res_center_table = $('#responsibility_table').DataTable({ responsive: false, "ajax" : { "url": base_url + 'api/get-responsiblity', "type" : "POST", "dataSrc": "", }, "ordering": false, 'columns': [ { data: null, render: function (data, type, row) { return '<span href="javascript:;"   data-id="'+data['responsibility_center_id']+'"  style="color: #000;" >'+data['responsibility_center_code']+'</span>'; } }, { data: null, render: function (data, type, row) { return '<a href="javascript:;"    data-id="'+data['responsibility_center_id']+'" data-code="'+data['responsibility_center_code']+'"  style="color: #000;"  >'+data['responsibility_center_name']+'</a>'; } }, { data: null, render: function (data, type, row) { return '<ul class="d-flex justify-content-center">\ <li class="mr-3 "><a href="javascript:;" class="text-secondary action-icon" data-id="'+data['responsibility_center_id']+'" data-name="'+data['responsibility_center_name']+'" data-code="'+data['responsibility_center_code']+'" id="update-center" data-toggle="modal" data-target="#update_center_modal"><i class="fa fa-edit"></i></a></li>\ <li><a href="javascript:;" data-id="'+data['responsibility_center_id']+'" data-name="'+data['responsibility_center_name']+'"  id="delete-center"  class="text-danger action-icon"><i class="ti-trash"></i></a></li>\ </ul>'; } }, ] });$(document).on('click','a#update-center',function (e) { $('input[name=center_id]').val($(this).data('id')); $('input[name=update_center_name]').val($(this).data('name')); }); $('#update_center_form').on('submit', function(e) { e.preventDefault(); $.ajax({ type: "POST", url: base_url + 'api/update-center', data: $(this).serialize(), dataType: 'json', beforeSend: function() { $('.btn-update-center').text('Please wait...'); $('.btn-update-center').attr('disabled','disabled'); }, success: function(data) { if (data.response) { $('.btn-update-center').text('Submit'); $('.btn-update-center').removeAttr('disabled'); $('#update_center_modal').modal('hide'); Swal.fire( "", data.message, "success" ); res_center_table.ajax.reload(); }else { Swal.fire( "", data.message, "error" ); $('.btn-update-center').text('Submit'); $('.btn-update-center').removeAttr('disabled'); } }, error: function(xhr) { alert("Error occured.please try again"); $('.btn-update-center').text('Submit'); $('.btn-update-center').removeAttr('disabled'); }, }); });$('#add_responsibility_center_form').on('submit', function(e) { e.preventDefault(); $.ajax({ type: "POST", url: base_url + 'api/add-responsibility', data: $(this).serialize(), dataType: 'json', beforeSend: function() { $('.btn-add-center').text('Please wait...'); $('button[type="submit"]').attr('disabled','disabled'); }, success: function(data) { if (data.response) { $('#add_responsibility_center_form')[0].reset(); $('.btn-add-center').text('Submit'); $('button[type="submit"]').removeAttr('disabled'); $('.alert').html(' <div class="alert-dismiss mt-2">\ <div class="alert alert-success alert-dismissible fade show" role="alert">\ <strong>'+data.message+'.\ <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="fa fa-times"></span>\ </button>\ </div>\ </div>'); res_center_table.ajax.reload(); setTimeout(function() { $('.alert').html('') }, 5000); }else { $('.btn-add-center').text('Submit'); $('button[type="submit"]').removeAttr('disabled'); $('.alert').html(' <div class="alert-dismiss mt-2">\ <div class="alert alert-warning alert-dismissible fade show" role="alert">\ <strong>'+data.message+'.\ <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="fa fa-times"></span>\ </button>\ </div>\ </div>'); setTimeout(function() { $('.alert').html('') }, 5000); } }, error: function(xhr) { alert("Error occured.please try again"); $('button[type="submit"]').removeAttr('disabled'); $('.btn-add-center').text('Submit'); $('button[type="submit"]').attr('disabled','disabled'); }, }); });$(document).on('click','a#delete-center',function (e) { var id = $(this).data('id'); var name = $(this).data('name'); Swal.fire({ title: "", text: "Delete " + name, icon: "warning", showCancelButton: true, confirmButtonText: "Yes", cancelButtonText: "No, cancel!", reverseButtons: true }).then(function(result) { if (result.value) { $.ajax({ type: "POST", url: base_url + 'api/delete-center', data: {id:id}, cache: false, dataType: 'json', beforeSend : function(){ Swal.fire({ title: "", text: "Please Wait", icon: "", showCancelButton: false, showConfirmButton : false, reverseButtons: false, allowOutsideClick : false }) }, success: function(data){ if (data.response) { Swal.fire( "", "Success", "success" ); res_center_table.ajax.reload() }else { Swal.fire( "", data.message, "error" ); } } }) } else if (result.dismiss === "cancel") { swal.close() } }); });

</script>  
</body>
</html>
