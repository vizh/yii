CPageCouponIndex = function () {
    this.init();
}

CPageCouponIndex.prototype.init = function () {
    var $table = $('.grid-view table'),
        $btnGiveCoupon = $('input#btn-give'),
        $headCheckbox = $('thead input:checkbox', $table),
        $bodyCheckbox = $('tbody input[name*="Coupons"]:checkbox', $table);

    $btnGiveCoupon.click(function (e) {
        $table.closest('form').trigger('submit');
    }).addClass('hide');

    $headCheckbox.on('change', function (e) {
        if ($(e.currentTarget).prop('checked')) {
            $bodyCheckbox.attr('checked', 'checked');
        } else {
            $bodyCheckbox.removeAttr('checked');
        }
        $bodyCheckbox.trigger('change');
    });
    $bodyCheckbox.on('change', function () {
        if ($bodyCheckbox.filter(':checked').length != $bodyCheckbox.length) {
            $headCheckbox.removeAttr('checked');
        } else {
            $headCheckbox.attr('checked', 'checked');
        }

        if ($bodyCheckbox.filter(':checked').length > 0) {
            $btnGiveCoupon.removeClass('hide');
        } else {
            $btnGiveCoupon.addClass('hide');
        }
    });
}

$(function () {
    pageCouponIndex = new CPageCouponIndex();
});
