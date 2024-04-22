<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left"><?php echo esc($title) ?></h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="<?= site_url() ?>">Home</a></li>
                        <li><a href=""><?php echo esc($title) ?></a></li>                      
                    </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            <div class=" pull-right">
                <?php if (session()->get('user_type') == 'user') { ?>
                <a href="javascript:;" id="request_for_assistance" class="btn sub-button mb-2 mt-2 mr-2" >Request for Assistance</a>       
                 <a href="javascript:;" id="add_transactions" class="btn sub-button mb-2 mt-2 mr-2" >Add PMAS Transaction</a>  
                 <?php } ?>              
                <a href="javascript:;" data-id="<?php echo session()->get('user_id') ?>" id="view_user" style="color: #000; font-size: 20px;"><?php echo session()->get('username') ?></a> 

            </div>
        </div>
    </div>
