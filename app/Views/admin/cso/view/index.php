<!doctype html>
<html class="no-js" lang="en">
   <head>
      <?php echo view('includes/meta.php') ?>
      <?php echo view('includes/css.php') ?> 
      <style>
        .progress{
            background-color: #8C52FF;
            margin-top: 15px;
            margin-bottom: 15px;
            height: 20px;
            border-radius: 3px;
            padding: 4px;
        }
        .progress-bar{
            width: 0%;
            height: 100%;
            background-color: #fff;
            border-radius: 3px;
        }

      </style>
   </head>
   <body>
    <?php echo view('includes/preloader') ?> 
      <div class="page-container sbar_collapsed">
         <div class="main-content">
            <?php echo view('admin/cso/view/sections/cso_topbar'); ?>
            <?php echo view('admin/cso/view/sections/cso_breadcrumbs'); ?>
            <div class="main-content-inner">
            <div class="row">
               <div class="col-12 mt-5">
                  <div class="card border" >
                     <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                
                                    <button class="btn sub-button pull-right mb-3 " data-toggle="modal" data-target="#print_option_modal"><i class="fa fa-print"></i> Print</button>         
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-12">
                                <?php echo view('admin/cso/view/sections/cso_information'); ?>  
                                
                              </div>
                           </div>   
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php echo view('admin/cso/view/modals/update_cso_information'); ?> 
      <?php echo view('admin/cso/view/modals/update_officer_modal'); ?> 
      <?php echo view('admin/cso/view_officers/modals/add_officer_modal'); ?>   



      <?php echo view('admin/cso/modals/update_cso_status_modal'); ?> 
     <?php echo view('admin/cso/view/modals/update_cor_modal'); ?> 
     <?php echo view('admin/cso/view/modals/view_file_modal'); ?> 




    <?php echo view('admin/cso/view/modals/add_project_modal'); ?> 
    <?php echo view('admin/cso/view/modals/update_project_modal'); ?> 
    <?php echo view('admin/cso/view/modals/print_option_modal'); ?> 

      <?php echo view('includes/scripts.php') ?> 
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script> 
      <script src="<?php echo base_url(); ?>assets/js/overly.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/Jquery-print.js"></script>
      <script>


$(document).on('click', 'a.view-pdf', function (e) {

   $.ajax({
      type: "GET",
      url: base_url + 'api/get-file?type=' + $(this).data('type')+'&&id=<?php echo $_GET['id'] ?>',
      cache: false,
      dataType: 'json',
      beforeSend: function () {
         $('#view_cor').html('<div class="loader"></div>');
          JsLoadingOverlay.show({
               'overlayBackgroundColor': '#666666',
               'overlayOpacity': 0.6,
               'spinnerIcon': 'ball-atom',
               'spinnerColor': '#000',
               'spinnerSize': '2x',
               'overlayIDName': 'overlay',
               'spinnerIDName': 'spinner',
            });
      },
      success: function (data) {
         if (data.resp) {
            JsLoadingOverlay.hide();
            $('#view_file_modal').modal('show');
            $('.pdf-viewer').html('<iframe src="'+data.file+'" style="width:100%;height:900px;"></iframe>');
         } else {
           JsLoadingOverlay.hide();
            alert('data')
         }
         $('#view_cor').html('View COR');
         
      },
      error: function () {
         alert('Server Error!');
         $('#view_cor').html('View COR');
          JsLoadingOverlay.hide();
      }

   });


});








function Validate_file(oInput) {

       

        if (oInput.type == "file") {
            var sFileName = oInput.value;
             if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                         
                         
                    }

                }
                 
                if (!blnValid) {
                    alert("Sorry, " + sFileName + " is invalid, allowed extension is " + _validFileExtensions.join(", ") + ' only');
                    // $('button.update-cor-cso-save').addClass('d-none')
                    oInput.value = "";
                    return false;
                    
                     
                }
            }
        }
        return true;

    }




//UPLOAD FILES

$(document).on('click','a.update_file', function(){
    const type = $(this).data('type');
    const file_title = $(this).data('title');
    $('#update_files_form').find('input[name=file_type]').val(type);
    $('#update_files_form').find('label.file_title').text(file_title);
    $('h5.modal_file_title').text('Update '+file_title);
});


$('#update_files_form').on('submit', function(e) {
e.preventDefault();

let form = new FormData(this);
let type = $(this).find('input[name=file_type]').val();
let save_btn = $('button.save_file_button');
var url = 'api/upload-cso-file';
_ajax_file(url,form,save_btn);
});


function _ajax_file(url='',form,save_btn=''){

    var startTime = new Date().getTime();
    var xhr = $.ajax({
        xhr: function () {
            var xhr = new XMLHttpRequest();
            xhr.upload.addEventListener("progress", function (e) {
                if (e.lengthComputable) {
                    var percentComplete = ((e.loaded / e.total) * 100);
                     $("#percent").html(Math.floor(percentComplete) + '%');
                     $(".progress-bar").width(percentComplete + '%');
                }
            }, false);
            return xhr;
        },

        type: "POST",
        url: base_url + url,
        data: form,
        contentType: false,
        cache: false,
        processData:false,
        dataType: 'json',
        beforeSend: function () {
                $('.prog_cent').attr('hidden',false);
                save_btn.html('<div class="loader"></div>');
                save_btn.prop("disabled", true);
                $("#percent").html('0%');
                $(".progress-bar").width('0%');
        },
        error: function(xhr) { // if error occured
                alert("Error occured.please try again");
                save_btn.prop("disabled", false);
                save_btn.text('Save Changes');
                $('.prog_cent').attr('hidden',true);
        },
        success: function (data) {

        if (data.response) {
                    $('#update_files_modal').modal('hide');
                    save_btn.prop("disabled", false);
                    save_btn.text('Save Changes');
                    ajax_toast(data.message,"info","linear-gradient(to right, #00b09b, #96c93d)");
                    $('input[name=update_file]').val('')
                   

        }else {
                      save_btn.prop("disabled", false);
                      save_btn.text('Save Changes');
                      ajax_toast(data.message,"info","red");
                }

            $('.prog_cent').attr('hidden',true);

        }
    });

}


function ajax_post(form,url,text=''){

    $.ajax({
            type: "POST",
            url: base_url + url,
            data: form.serialize(),
            cache: false,
            dataType: 'json',
            beforeSend: function() {
                form.find('button[type=submit]').text('Please wait...');
                form.find('button[type=submit]').attr('disabled','disabled');
            },
             error: function(xhr) {
                alert("Error occured.please try again");
                form.find('button[type=submit]').text(text);
                form.find('button[type=submit]').removeAttr('disabled');
            },

             success: function(data)
            {            
                if (data.response) {
                   
                    form.find('button[type=submit]').text(text);
                    form.find('button[type=submit]').removeAttr('disabled');
                    ajax_toast(data.message,"info","linear-gradient(to right, #00b09b, #96c93d)");
                      
                }else {
                    form.find('button[type=submit]').text(text);
                    form.find('button[type=submit]').removeAttr('disabled');
                    ajax_toast(data.message,"info","red");
                }
           },

    });

}

 
$('#add_project_form').on('submit', function(e) {
    e.preventDefault();
    let form    = $(this);
    let table   = $('#project_table');
    var url     = 'api/add-project';
    var text    = 'Submit';
    ajax_post(form,url,text);
    table.DataTable().destroy();
    load_projects();
     form[0].reset();
});


$('#add_officer_form').on('submit', function(e) {
    e.preventDefault();
    let form    = $(this);
    var url     = 'api/add-officer';
    var text    = 'Save Changes';
    ajax_post(form,url,text);
    $('#officers_table').DataTable().destroy();
    load_cso_officers();
     form[0].reset();

});



function load_cso_officers(){

   $.ajax({
            url: base_url + 'api/get-officers',
            type: "POST",
            data : {cso_id :"<?php echo $_GET['id'] ?>"},
            dataType: "json",
            success: function(data) {
               $('#officers_table').DataTable({
                scrollY: 500,
                scrollX: true,
               "ordering" : false,
               "data": data,
               "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                                        "<'row'<'col-sm-12'tr>>" +
                                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        buttons: [
                                  {
                                     extend: 'excel',
                                     text: 'Excel',
                                     className: 'btn btn-danger',
                                     exportOptions: {
                                        columns: 'th:not(:last-child)'
                                     }
                                  },
                                   {
                                     extend: 'pdf',
                                     text: 'pdf',
                                     className: 'btn btn-default',
                                     exportOptions: {
                                        columns: 'th:not(:last-child)'
                                     }
                                  },

                                {
                                     extend: 'print',
                                     text: 'print',
                                     className: 'btn btn-default',
                                     exportOptions: {
                                        columns: 'th:not(:last-child)'
                                     }
                                  },    

                        ],
               'columns': [
                  {
                     data: null,
                     render: function (data, type, row) {
                        return row.name;
                     }

                  },
                  {
                     data: null,
                     render: function (data, type, row) {
                           return row.title;
                     }

                  },
                  {
                     data: null,
                     render: function (data, type, row) {
                           return row.contact_number;
                     }

                  },
                  {
                     data: null,
                     render: function (data, type, row) {
                           return row.email_address;
                     }

                  },
                  {
             // data: "song_title",
             data: null,
             render: function (data, type, row) {
                 return '<ul class="d-flex justify-content-center">\
                             <li class="mr-3 ">\
                             <a href="javascript:;" class="text-secondary action-icon" \
                             data-id="'+data['cso_officer_id']+'"  \
                             data-position="'+data['position']+'"  \
                             data-first-name="'+data['first_name']+'"  \
                             data-middle-name="'+data['middle_name']+'"  \
                             data-last-name="'+data['last_name']+'"  \
                             data-extension="'+data['extension']+'"  \
                             data-contact="'+data['contact_number']+'"  \
                             data-email="'+data['email_address']+'"  \
                             id="update-cso-officer"><i class="fa fa-edit"></i></a></li>\
                             <li class="mr-3 ">\
                             <a href="javascript:;" class="text-danger action-icon" \
                             data-id="'+data['cso_officer_id']+'"  \
                             id="delete-cso-officer"><i class="fa fa-trash"></i></a></li>\
                             </ul>';
             }

         },
]

})

            }


   });


}






$(document).on('click','a#delete-cso-officer',function (e) {


var id = $(this).data('id');

   
Swal.fire({
        title: "Are you sure?",
        text: "You wont be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            
                    $.ajax({
                            type: "POST",
                            url: base_url + 'api/delete-cso-officer',
                            data: {id: id},
                            cache: false,
                            dataType: 'json', 
                            beforeSend : function(){

                                  Swal.fire({
                                title: "",
                                text: "Please Wait",
                                icon: "",
                                showCancelButton: false,
                                showConfirmButton : false,
                                reverseButtons: false,
                                allowOutsideClick : false
                            })

                            },
                            success: function(data){
                               if (data.response) {

                                  Swal.fire(
                "",
                "Deleted Successfully",
                "success"
            )

                                $('#officers_table').DataTable().destroy();
                                 load_cso_officers();
                                
                               }

                              
                            }
                    })



            // result.dismiss can be "cancel", "overlay",
            // "close", and "timer"
        } else if (result.dismiss === "cancel") {
           swal.close()

        }
    });

})


$('#update_cso_information_form').on('submit', function(e) {
    e.preventDefault();
    let form    = $(this);
    var url     = 'api/update-cso-information';
    var text    = 'Save Changes';
    ajax_post(form,url,text);
    $('#update_cso_information_modal').modal('hide');
    setTimeout(function() {get_cso_information()}, 1000);
    ;


});





function get_cso_information(){

          $.ajax({
                            type: "POST",
                            url: base_url + 'api/get-cso-infomation',
                            data : {'id' : '<?php echo $_GET['id'] ?>'},
                            cache: false,
                            dataType: 'json',  
                            success: function(data){
                               $('.cso_code').text(data.cso_code)
                                $('.cso_name').text(data.cso_name)
                                $('.cso_address').text(data.address)
                                $('.contact_person').text(data.contact_person)
                                $('.contact_number').text(data.contact_number)
                                $('.telephone_number').text(data.telephone_number)
                                $('.email').text(data.email_address)
                                $('.classification').html('<span class="status-p sub-button">'+data.type_of_cso+'<span>')
                                $('.cso_status').html(data.cso_status+' '+'<a href="javascript:;" data-id="'+data.cso_id+'" data-status="'+data.status+'"  id="update-cso-status"  class=" text-center ml-3  btn-rounded  pull-right"><i class = "fa fa-edit" aria-hidden = "true"></i> Update Status</a>')
                                $('#update-cso-information').data('id',data.cso_id);



                                $('input[name=cso_idd]').val(data.cso_id);
                                $('input[name=cso_name]').val(data.cso_name);
                                $('input[name=cso_code]').val(data.cso_code);
                                // $('#cso_type option[value='+data.type_of_cso.toString().toLowerCase()+']').attr('selected','selected'); 
                                $('input[name=purok]').val(data.purok_number);
                                $('select[name=barangay]').val(data.barangay);
                                $('select[name=cso_type]').val(data.type_of_cso);

                               
                                $('input[name=contact_person]').val(data.contact_person);
                                $('input[name=contact_number]').val(data.contact_number);
                                $('input[name=telephone_number]').val(data.telephone_number);
                                $('input[name=email_address]').val(data.email_address);
                                




                                       
                            }

                    })

                }

$(document).on('click','a#update-cso-status',function (e) {

      const id = $(this).data('id');
      const status = $(this).data('status');
      $('#update_cso_status_modal').modal('show');
      $('#cso_status option[value='+status+']').attr('selected','selected'); 
      $('input[name=cso_id]').val(id);
});


$(document).on('click','a#update-cso-officer',function (e) {

const id = $(this).data('id'); 
const position = $(this).data('position');  
$('#update_officer_modal').modal('show');
$('select[name=update_cso_position]').val(position);
// $('#cso_status option[value='+position+']').attr('selected','selected'); 
$('input[name=officer_id]').val(id);
$('input[name=cso_id]').val('<?php echo $_GET['id'] ?>');
$('input[name=update_first_name]').val($(this).data('first-name'));
$('input[name=update_middle_name]').val($(this).data('middle-name'));
$('input[name=update_last_name]').val($(this).data('last-name'));
$('input[name=update_extension]').val($(this).data('extension'));
$('input[name=update_contact_number]').val($(this).data('contact'));
$('input[name=update_email]').val($(this).data('email'));
});



$('#update_project_form').on('submit', function(e) {
        e.preventDefault();

         $.ajax({
            type: "POST",
            url: base_url + 'api/update-project',
            data: $(this).serialize(),
            cache: false,
            dataType: 'json',
            beforeSend: function() {
                $('.btn-update-project_').text('Please wait...');
                $('.btn-update-project_').attr('disabled','disabled');
            },
             success: function(data)
            {            
                if (data.response) {
                    $('#update_project_modal').modal('hide');
                    $('.btn-update-project_').text('Save Changes');
                    $('.btn-update-project_').removeAttr('disabled');
                    
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
                    
                    $('#project_table').DataTable().destroy();
                    load_projects();
                }else {
                    
                     $('.btn-update-project_').text('Save Changes');
                    $('.btn-update-project_').removeAttr('disabled');
                      
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
                $('.btn-update-project_').text('Save Changes');
                $('.btn-update-project_').removeAttr('disabled');
            },


        });

    });


      


$('#update_officer_form').on('submit', function(e) {
        e.preventDefault();

         $.ajax({
            type: "POST",
            url: base_url + 'api/update-officer-information',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            dataType: 'json',
            beforeSend: function() {
                $('.btn-update-cso').text('Please wait...');
                $('.btn-update-cso').attr('disabled','disabled');
            },
             success: function(data)
            {            
                if (data.response) {
                    $('#update_officer_modal').modal('hide')
                    $('.btn-update-cso').text('Save Changes');
                    $('.btn-update-cso').removeAttr('disabled');
                    
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
                     $('#officers_table').DataTable().destroy();
                   load_cso_officers();

                }else {
                    
                     $('.btn-update-cso').text('Save Changes');
                    $('.btn-update-cso').removeAttr('disabled');
                      
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
                $('.btn-update-cso').text('Save Changes');
                $('.btn-update-cso').removeAttr('disabled');
            },


        });

    });


      $('#update_cso_status_form').on('submit', function(e) {
        e.preventDefault();

         $.ajax({
            type: "POST",
            url: base_url + 'api/update-cso-status',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            dataType: 'json',
            beforeSend: function() {
                $('.btn-update-cso-status').text('Please wait...');
                $('.btn-update-cso-status').attr('disabled','disabled');
            },
             success: function(data)
            {            
                if (data.response) {
                    $('#update_cso_status_modal').modal('hide')
                    $('.btn-update-cso-status').text('Save Changes');
                    $('.btn-update-cso-status').removeAttr('disabled');
                    
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
                  get_cso_information();
                }else {
                    
                     $('.btn-update-cso-status').text('Save Changes');
                    $('.btn-update-cso-status').removeAttr('disabled');
                      
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
                $('.btn-update-cso-status').text('Save Changes');
                $('.btn-update-cso-status').removeAttr('disabled');
            },


        });

    });
    
$(".numbers").keyup(function (e) {
   checkNumbersOnly($(this));
});

function checkNumbersOnly(myfield) {
   if (/[^\d\.]/g.test(myfield.val())) {
      myfield.val(myfield.val().replace(/[^\d\.]/g, ''));
   }
}



function load_projects(){

   $.ajax({
            url: base_url + 'api/get-projects',
            type: "POST",
            data : {cso_id :"<?php echo $_GET['id'] ?>"},
            dataType: "json",
            success: function(data) {

            


               $('#project_table').DataTable({
                scrollY: 500,
                scrollX: true,
               "ordering" : false,
               "data": data,
               "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                                        "<'row'<'col-sm-12'tr>>" +
                                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        buttons: [
                                  {
                                     extend: 'excel',
                                     text: 'Excel',
                                     className: 'btn btn-default ',
                                     exportOptions: {
                                        columns: 'th:not(:last-child)'
                                     }
                                  },
                                   {
                                     extend: 'pdf',
                                     text: 'pdf',
                                     className: 'btn btn-default',
                                     exportOptions: {
                                        columns: 'th:not(:last-child)'
                                     }
                                  },

                                {
                                     extend: 'print',
                                     text: 'print',
                                     className: 'btn btn-default',
                                     exportOptions: {
                                        columns: 'th:not(:last-child)'
                                     }
                                  },    

                        ],
               'columns': [
                  {
                
                     data: null,
                     render: function (data, type, row) {
                        return row.project_title;
                     }

                  },
                  {
                
                     data: null,
                     render: function (data, type, row) {
                           return row.amount;
                     }

                  },
                  {
                
                     data: null,
                     render: function (data, type, row) {
                           return row.year;
                     }

                  },
                  {
                
                     data: null,
                     render: function (data, type, row) {
                           return row.funding_agency;
                     }

                  },
                   {
                
                     data: null,
                     render: function (data, type, row) {
                           return row.status;
                     }

                  },
                  {
        
             data: null,
             render: function (data, type, row) {
                 return '<ul class="d-flex justify-content-center">\
                             <li class="mr-3 ">\
                             <a href="javascript:;" class="text-secondary action-icon" \
                             data-id="'+data['cso_project_id']+'"  \
                             data-project-title="'+data['project_title']+'"  \
                             data-amount="'+data['amount']+'"  \
                             data-year1="'+data['year1']+'"  \
                             data-funding-agency="'+data['funding_agency']+'"  \
                             data-status="'+data['status1']+'"  \
                             id="update-cso-project"><i class="fa fa-edit"></i></a></li>\
                             <li class="mr-3 ">\
                             <a href="javascript:;" class="text-danger action-icon" \
                            data-id="'+data['cso_project_id']+'"  \
                             data-project-title="'+data['project_title']+'"  \
                             id="delete-cso-project"><i class="fa fa-trash"></i></a></li>\
                             </ul>';
             }

         },
]

})

            }


   });

}


$(document).on('click','a#update-cso-project',function (e) {

$('#update_project_modal').modal('show');
 
$('input[name=cso_project_id]').val($(this).data('id'));
$('input[name=update_title_of_project]').val($(this).data('project-title'));
$('input[name=update_amount]').val($(this).data('amount'));
$('input[name=update_year]').val($(this).data('year1'));
$('input[name=update_funding_agency]').val($(this).data('funding-agency'));

$('select[name=update_status]').val($(this).data('status'));

});



$(document).on('click','a#delete-cso-project',function (e) {


var id = $(this).data('id');
var project = $(this).data('project-title');

   
Swal.fire({
        title: "",
        text: "Delete Project " + project,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            
                    $.ajax({
                            type: "POST",
                            url: base_url + 'api/delete-cso-project',
                            data: {id: id},
                            cache: false,
                            dataType: 'json', 
                            beforeSend : function(){

                                JsLoadingOverlay.show({
                                    'overlayBackgroundColor': '#666666',
                                    'overlayOpacity': 0.6,
                                    'spinnerIcon': 'ball-atom',
                                    'spinnerColor': '#000',
                                    'spinnerSize': '2x',
                                    'overlayIDName': 'overlay',
                                    'spinnerIDName': 'spinner',
                                  });

                            },
                            success: function(data){
                               if (data.response) {

                                JsLoadingOverlay.hide();

                                  Swal.fire(
                "",
                "Deleted Successfully",
                "success"
            )

                                
                            $('#project_table').DataTable().destroy();
                            load_projects();
                                
                               }

                              
                            }
                    })



            // result.dismiss can be "cancel", "overlay",
            // "close", and "timer"
        } else if (result.dismiss === "cancel") {
           swal.close()

        }
    });

});


$('#cso_project_option').change(function() {
    if ($(this).is(':checked')) {
        $('#select_year_section').removeAttr('hidden','hidden');
       
    }else {
        $('#select_year_section').attr('hidden','hidden');
        
    }
  });




$(document).on('click','button#generate_for_print',function (e) {

    var selectedValues = [];


    $('input[name=options]:checked').map(function() {
                    selectedValues.push($(this).val());
        });

    var select_year = $('#select_year_cso_project option:selected').val();


    if (selectedValues.length > 0) {

         $('#print_button').removeAttr('hidden','hidden');

         $.ajax({
            url: base_url + 'api/generate-for-print',
            type: "POST",
            data : {options : selectedValues , year : select_year, cso_id :"<?php echo $_GET['id'] ?>"},
            dataType: "html",
             beforeSend : function(){

                                JsLoadingOverlay.show({
                                    'overlayBackgroundColor': '#666666',
                                    'overlayOpacity': 0.6,
                                    'spinnerIcon': 'ball-atom',
                                    'spinnerColor': '#000',
                                    'spinnerSize': '2x',
                                    'overlayIDName': 'overlay',
                                    'spinnerIDName': 'spinner',
                                  });

                            },
        success: function(data) {

             JsLoadingOverlay.hide();
            $('.print_generated').html(data);

            }

        })





    }else {

         

        Swal.fire(
                "",
                "Please select an Option",
                "warning"
            );
        $('#print_button').attr('hidden','hidden');
         $('.print_generated').html('');

    }

})


  function print(){

     $(".print_generated").print({
            globalStyles: true,
            mediaPrint: false,
            stylesheet: null,
            noPrintSelector: ".no-print",
            iframe: true,
            append: null,
            prepend: null,
            manuallyCopyFormValues: true,
            deferred: $.Deferred(),
            timeout: 750,
            title: null,
            doctype: '<!doctype html>'
    });


  }





$(document).ready(function(){
   load_projects();
    get_cso_information();
    load_cso_officers(); 
})




      </script>
   </body>
</html>