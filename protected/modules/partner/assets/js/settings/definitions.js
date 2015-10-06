$(function () {
    $('.definition').each(function () {
        var $definition = $(this);

        $definition.find('select[name*="[ClassName]"]').change(function (e) {
            var $params = $definition.find('[data-class]');
            $params.hide();
            $params.filter('[data-class="' + $(e.currentTarget).val() + '"]').show();
        }).trigger('change');

        $definition.find('.btn.btn-delete').click(function (e) {
            $definition.find('input[name*="[Delete]"]').val(1);
            $definition.hide();
            e.preventDefault();
        });
    });

});