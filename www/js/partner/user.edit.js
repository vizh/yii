$(function(){
    $('input#NameOrRocid').autocomplete({
        source: "/partner/user/ajaxget/",
        minLength: 2,
        select: function(event, ui){
            $('input#RocId').val(ui.item.id);
            $('#span_rocid')
                .html(ui.item.id).hide();
            $('input#NameOrRocid').attr('value', ui.item.label);
            
            return false; 
        }
    });
});
