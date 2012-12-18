CPageCouponIndex = function () {
    this.table  = $('.container table.table');
    
    this.headCheckbox = $('thead input[type="checkbox"]', self.table);
    this.bodyCheckbox = $('tbody input[type="checkbox"]', self.table);
    
    this.btnGiveCoupon = $('tfoot input[type="submit"]', this.table);
    this.init();
}

CPageCouponIndex.prototype.init = function () {
    var self = this;
    
   self.headCheckbox.change( function (e) {
        if ( $(e.currentTarget).prop('checked')) {
            self.bodyCheckbox.attr('checked', 'checked');
        }
        else {
            self.bodyCheckbox.removeAttr('checked');
        }
        self.bodyCheckbox.trigger('change');
    });
    
    self.bodyCheckbox.change( function () {
        if ( self.bodyCheckbox.filter(':checked').length != self.bodyCheckbox.length) {
            self.headCheckbox.removeAttr('checked');
        }
        else {
            self.headCheckbox.attr('checked', 'checked');
        }
        
        if ( self.bodyCheckbox.filter(':checked').length > 0) {
            self.btnGiveCoupon.show();
        }
        else { 
            self.btnGiveCoupon.hide();
        }
    });
}

$(function () {
    var PageCouponIndex = new CPageCouponIndex();
});
