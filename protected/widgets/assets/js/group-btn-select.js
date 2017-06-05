(function () {
    $(function () {
        $('.btn-group .btn').click(function () {
            var $this = $(this),
                $widget = $this.closest('.widget-btn-group'),
                $hidden = $widget.find('div.hidden');

            if ($this.hasClass('active')) {
                $hidden.find('input[value="' + $this.data('value') + '"]').remove();
            } else {
                var $input = $('<input/>');
                $input.attr('type', 'hidden').attr('name', $widget.data('model')).val($this.data('value'));
                $hidden.append($input);
            }
        });
    });
})(jQuery);