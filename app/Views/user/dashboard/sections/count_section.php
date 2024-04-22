<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-6 mt-3 mb-2">
                <div class="card">
                    <div class="seo-fact sbg2">
                        <div class="p-3 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon">
                                Completed Transactions
                            </div>
                            <h2 id="count-c"><?php echo $count_complete_transactions; ?></h2>
                        </div>
                    </div>
                </div>
             </div>
              <div class="col-md-6 mt-3 mb-2">
                <div class="card">
                    <div class="seo-fact sbg3">
                        <div class="p-3 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon">
                                Pending Transactions
                            </div>
                            <h2 id="count-c"><?php echo $count_pending_transactions; ?></h2>
                        </div>
                    </div>
                </div>
             </div>

           
             
            
        </div>
    </div>
</div>

  <?php echo view('includes/dashboard_section/count_section'); ?>
