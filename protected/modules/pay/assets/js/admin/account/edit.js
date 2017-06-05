$(function () {
    var form = $('form.form-horizontal');

    form.find('input[id*="Account_EventTitle"]').autocomplete({
        'source':'/event/ajax/search',
        'select':function (event, ui) {
            form.find('input[id*="Account_EventId"]').val(ui.item.value);
            $(this).val(ui.item.label);
            return false;
        }
    });

    form.find('input[id*="Account_OrderLastTime"], input[id*="ReceiptLastTime"]').datepicker();
});

