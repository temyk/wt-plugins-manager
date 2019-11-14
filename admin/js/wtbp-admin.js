jQuery(document).ready(function($){
    jQuery(document).on('click', '#wtbp-delete-confirm', function(e) {
        if (!confirm(wtbp_confirm_text)) {
            e.preventDefault();
        }
    });
});