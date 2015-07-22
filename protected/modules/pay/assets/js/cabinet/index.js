$(function () {
    var container = $('.event-register');
    var eventIdName = container.data('event-idname');

    $('.icon-trash', container).css('opacity', '0.2');
    $('td', container).hover(
        function (e) {
            $(e.currentTarget).parent('tr').find('.icon-trash').css('opacity', '0.7');
        },
        function (e) {
            $(e.currentTarget).parent('tr').find('.icon-trash').css('opacity', '0.2');
        }
    );

    var payButtons = $('.actions a:not(.juridical)', container);
    var offerCheckbox = $('input[name="agreeOffer"]', container);
    offerCheckbox.change(function (e) {
        var $label = offerCheckbox.parent('label');
        if ($(e.currentTarget).prop('checked')) {
            payButtons.removeAttr('disabled');
            payButtons.addClass('btn-primary');
            $label.removeClass('text-error');
        }
        else {
            payButtons.attr('disabled','disabled');
            payButtons.removeClass('btn-primary');
            $label.addClass('text-error');
        }
        $.cookie('offerCheckboxEnabled'+eventIdName, $(e.currentTarget).prop('checked'), {expires:7});
    });
    if ($.cookie('offerCheckboxEnabled'+eventIdName) == 'true') {
        offerCheckbox.attr('checked', 'checked');
    }
    offerCheckbox.trigger('change');

    payButtons.on('click', function () {
        return offerCheckbox.prop('checked');
    });


    $('.pay-buttons a').click(function (e) {
        var $target = $(e.currentTarget);
        var $form = $('form.additional-attributes');
        if ($form.size() > 0 && $target.attr("disabled") != "disabled") {
            if (!$form.data('valid')) {
                var $alert = $form.find('.alert-error');
                if ($alert.size() == 0) {
                    $alert = $('<div/>', {'class' : 'alert alert-error errorSummary'});
                    $form.prepend($alert);
                }
                $alert.hide().html('');
                $.post('?checkAdditionalAttributes=true', $form.serialize(), function (response) {
                    if (response.success) {
                        $form.data('valid', true);
                        $target.trigger('click');
                    } else {
                        var $ul = $('<ul/>');
                        $.each(response.errors, function (attr, errors) {
                            $.each(errors, function (i, error) {
                                $ul.append('<li>' + error + '</li>')
                            });
                        });
                        $alert.append($ul).show();
                    }
                },'json');
                return false;
            }
            window.location = $target.attr('href');
        }
    });
});