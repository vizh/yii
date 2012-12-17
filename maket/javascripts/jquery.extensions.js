(function($) {
    $.id = function(id) { return $(document.getElementById(id)); };

    $.fn.maxHeight = function() {
        var max = 0;
        this.each(function() {
          max = Math.max(max, $(this).height());
        });
        return max;
    };

    $.fn.maxWidth = function() {
        var max = 0;
        this.each(function() {
          max = Math.max(max, $(this).width());
        });
        return max;
    };

    $.fn.fixMaxHeight = function() { this.css({height: this.maxHeight() + 'px'}); return this; };
    $.fn.fixMaxWidth  = function() { this.css({height: this.maxHeight() + 'px'}); return this; };

})(jQuery);