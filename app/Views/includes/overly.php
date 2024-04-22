<script src="<?php echo base_url(); ?>assets/js/overly.js"></script>
<script>
function show_overly(){
    JsLoadingOverlay.show({
                     'overlayBackgroundColor': '#666666',
                     'overlayOpacity': 0.6,
                     'spinnerIcon': 'pacman',
                     'spinnerColor': '#000',
                     'spinnerSize': '2x',
                     'overlayIDName': 'overlay',
                     'spinnerIDName': 'spinner',
                  });
}
</script>