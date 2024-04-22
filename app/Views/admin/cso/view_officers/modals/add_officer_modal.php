<div class="modal fade" id="add_officers_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Officer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form id="add_officer_form" class="p-2">
            <div class="modal-body">
               <input type="hidden" name="cso_id" value="<?php echo $_GET['id'] ?>">
            <div class="form-group">
                  <div class="col-12">Position<span class="text-danger">*</span></div>
                  <select class="custom-select"  name="cso_position" style="border: 1px solid;height: 45px;" required>
                           <option  value="" selected>Select Position</option>
                             <?php foreach ($positions as $row) { ?>
                              <option  value="<?php echo $row['position'] ?>-<?php echo $row['number'] ?>"><?php echo $row['position']; ?></option>
                              <?php } ?>
                  </select>
               </div>
               <div class="form-group">
                  <div class="col-12">First Name<span class="text-danger">*</span></div>
                  <input type="text" class="form-control input" name="first_name"  placeholder="" required>
               </div>
               <div class="form-group">
                  <div class="col-12">Middle Name<span class="text-danger">*</span></div>
                  <input type="text" class="form-control input" name="middle_name"  placeholder="" required>
               </div>
               
               <div class="form-group">
                    <div class="col-12">Last Name<span class="text-danger">*</span></div>
                  <input type="text" class="form-control input" name="last_name"  placeholder="">
               </div>
               <div class="form-group">
                    <div class="col-12">Extension<span class="text-danger">*</span></div>
                  <input type="text" class="form-control input" name="extension"  placeholder="">
               </div>
               <div class="form-group">
                  <div class="col-12">Contact Number<span class="text-danger">*</span></div>
                  <input type="text" value="09" class="form-control input" name="officer_contact_number"  placeholder=""  data-mask="09000000000" required>
               </div>
               <div class="form-group">
                <div class="col-12">Email<span class="text-danger">*</span></div>
                  <input type="email" class="form-control input" name="email"  placeholder=""  >
               </div>
               <!-- <div class="form-group">
                <div class="col-12">Profile_picture<span class="text-danger">*</span></div>
                  <input type="text" class="form-control input" name="telephone_number"  placeholder=""  >
               </div>    -->
            </div>
            <div class="modal-footer" id="update_cso_footer">
               <button type="button" class="btn btn-danger update-cso-close" data-dismiss="modal">Close</button>
               <button type="submit" class="btn   sub-button btn-add" >Save changes</button>
            </div>
         </form>
      </div>
   </div>
</div>