jQuery(document).ready(function($){
    var tbl = jQuery('table.wp-list-table.plugins tbody tr');
    jQuery(document).on('click', '.wtbp_sort_plugins', function(e) {
        e.preventDefault();
        var btn = jQuery(this);
        if(btn.attr('data-sort') === 'active') {
            jQuery('table.wp-list-table.plugins tbody tr').sort(function (a, b) { // сортируем
                var act_class1 = jQuery(a).hasClass('active');
                var act_class2 = jQuery(b).hasClass('active');
                return +act_class2 - +act_class1;
            }).appendTo('table.wp-list-table.plugins tbody');// возвращаем в контейнер
            btn.attr('data-sort', 'deactive');
        }
        else {
            jQuery('table.wp-list-table.plugins tbody tr').sort(function (a, b) { // сортируем
                var act_class1 = jQuery(a).hasClass('active');
                var act_class2 = jQuery(b).hasClass('active');
                return +act_class1 - +act_class2;
            }).appendTo('table.wp-list-table.plugins tbody');// возвращаем в контейнер
            btn.attr('data-sort', 'active');
        }
    });

    jQuery(document).on('click', '#wtbp-delete-confirm', function(e) {
        if (!confirm(wtbp_confirm_text)) {
            e.preventDefault();
        }
    });
});