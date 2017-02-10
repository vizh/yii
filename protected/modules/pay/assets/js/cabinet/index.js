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

    payButtons.on('click', function (e) {
        if (offerCheckbox.prop('checked')){
            return true;
        }
        else {
            e.stopPropagation();
            e.stopImmediatePropagation();
            return false;
        }
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
            e.preventDefault();
            window.location = $target.attr('href');
        }
    });

    payButtons.on('click', function(e) {
        if (!$(this).hasClass("iframe")){
            return true;
        }

        var $modal = $("#payonline-modal");

        var $iframe = $("<iframe></iframe>")
            .css({

            })
            .load(function(){
                $("#payonline-modal .modal-body .loading").remove();
            })
            .attr("src", this.href);

        $modal
            .find(".modal-body")
            .html("<div class='loading'><img src='/img/pay/loading.gif' alt='loading'></div>")
            .append($iframe);
        $modal.modal({"backdrop": "static"});
        return false;
    });

    $('.pay-buttons .payonline-save-card').on("change", function(){
        var url = $('.pay-buttons .btn.payonline').get(0).search.substr(1);
        var params = JSON.parse('{"' + decodeURI(url).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g,'":"') + '"}');
        params.save = this.checked ? 1 : undefined;
        $('.pay-buttons .btn.payonline').get(0).search = '?' + $.param(params);
    });
});