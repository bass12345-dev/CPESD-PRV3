<div class="row">
   <div class="col-12 mt-5">
      <div class="card" style="border: 1px solid;">
         <div class="card-body">
            <div class="row">
               <div class="col-md-12">
                  <div class="row">
                     <div class="col-md-12"> 
                        <button class="btn  mb-3 mt-2 sub-button pull-right" data-toggle="modal" data-target="#add_cso_modal" > Add CSO</button>   
                        <select  class=" custom-select mb-3 mt-2 mr-2 pull-left" id="cso_type" onchange="load_cso_by_type(this)"    style="border: 1px solid; width: 150px;" >
                           <option  value="" selected>Select CSO type</option>
                           <?php foreach ($type_of_cso as $row) { ?>
                           <option  value="<?php echo strtolower($row); ?>" ><?php echo $row; ?></option>
                           <?php } ?>
                        </select>
                        
                        <select  class=" custom-select mb-3 mt-2 mr-2 pull-left" id="cso_status" onchange="load_cso_by_status(this)"  style="border: 1px solid; width: 150px;">
                           <option  value="" selected>Select Status</option>
                           <option  value="active">Active</option>
                           <option  value="inactive">Inactive</option>
                          
                        </select>
                        <button class="btn  mb-3 mt-2 sub-button pull-left" id="reload_cso_filter" style="height: 39px;" ><i class="ti-loop"></i> Reload</button>  
                     </div>
                  </div>
                                          
                  <div class="data-tables">
                     <table id="cso_table" style="width:100%" class="text-center">
                        <thead class="bg-light text-capitalize">
                           <tr>
                              <th>Controll No.</th>
                              <th>CSO</th>
                              <th>Address</th>
                              <th>Contact Person</th>
                              <th>Contact Number</th>
                              <th>Telephone Number</th>
                              <th>Email Address</th>
                              <th>Classification</th>
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