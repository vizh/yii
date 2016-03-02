(function ($) {
    'use strict';

    $(function () {
        var $rows = $('table tr[key]:not(.error)'),
            unique = {};

        $rows.each(function (i, v) {
            let val = $(v).attr('key');
            if (typeof unique[val] === 'undefined') {
                unique[val] = true;
            } else {
                unique[val] = false;
            }
        });

        Object.keys(unique).forEach(function (elem, i) {
            console.log(elem);
            console.log(unique[elem]);
            if (!unique[elem]) {
                $('table tr[key="' + elem + '"]').addClass('warning');
            }
        });
    });
})(jQuery);