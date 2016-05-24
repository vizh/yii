$(function () {
    $('#event-id-input').autocomplete({
        source: '/event/ajax/search',
        select: function (event, ui) {
            $('input[name*="Test[EventId]"]').val(ui.item.value);
            $(this).val(ui.item.label);

            return false;
        }
    });

    $('input[name*="StartTime"], input[name*="EndTime"]').datepicker({});

/*    CKEDITOR.replace('competence\\models\\form\\Test[BeforeText]', {
        customConfig : 'config_admin.js'
    });
    CKEDITOR.replace('competence\\models\\form\\Test[AfterText]', {
        customConfig : 'config_admin.js'
    });*/
    CKEDITOR.replace('competence\\models\\form\\Test[AfterEndText]', {
        customConfig : 'config_admin.js'
    });
});
