<div class="modal fade" id="update_cor_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Update COR</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
        
         <form id="update_cor_form" class="p-2">
            <div class="modal-body">
              
                 <input type="hidden" name="cso_idd">
                  <div class="form-group">
                  <label for="exampleInputPassword1">COR</label><span class="text-danger">*</span><span class="pull-right text-danger">*Pdf file only</span>
                  <input type="file" class="form-control" name="update_cor"  placeholder="" onchange="Validate_file(this);" required>
               </div> 
              
              
              
            </div>
            <div class="modal-footer" id="update_cso_footer">
               <button type="button" class="btn btn-danger update-cso-close" data-dismiss="modal">Close</button>
               <button type="submit" class="btn  update-cor-cso-save sub-button " >Save changes</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="view_file_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">View File</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
        

            <div class="modal-body">

               <div class="row">
                  <div class="col-md-12">
                         <div id="navigation_controls" class="mb-3" >
                                            <button id="go_previous" class="btn sub-button btn-rounded">Previous</button>
                                            <input id="current_page" value="1" type="number" disabled />
                                            <button id="go_next" class="btn sub-button btn-rounded">Next</button>
                                           <!--   <button id="zoom_in" class="btn sub-button btn-rounded" >+</button>
                                            <button id="zoom_out" class="btn sub-button btn-rounded">-</button> -->
                                             <a href="javascript:;" id="download" class="btn btn-success btn-rounded pull-right download-file">Download</a>
                                        </div>
                  </div>
                                      
               </div>
               <div class="row align-items-center p-3">

                     <canvas id="pdf_renderer" style="width: 100%; height: 100%; border: 1px solid;"></canvas>
                  </div>
            </div>
          
         
      </div>
   </div>
</div>