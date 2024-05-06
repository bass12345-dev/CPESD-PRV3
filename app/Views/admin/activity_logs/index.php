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
                     <?php echo view('admin/activity_logs/sections/activity_log_table'); ?> 
                </div>
        </div>
    </div>     
<?php echo view('includes/scripts.php') ?>   
<script type="text/javascript">
    $('#data-table').DataTable({
      scrollY: 500,
      scrollX: true,
      "ordering": false,
      pageLength: 20,
      "ajax": {
         "url": base_url + 'api/g-a-a-l',
         "type": "POST",
         "dataSrc": "",
      },
      'columns': [{
         data: "name",
      }, {
         data: "action",
      }, {
         data: "user_type",
         }, {
         data: "date_and_time",
      }, ]
   })
</script>
</body>
</html>
