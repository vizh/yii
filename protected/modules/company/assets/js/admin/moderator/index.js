$(function () {
    $('input[name="CompanyName"]').autocomplete({
        source:'/company/ajax/search',
        select:function (event, ui) {
            window.location.href = '/company/moderator/index?companyId=' + ui.item.Id;
            return false;
        }
    });

    $('form.create-moderator input[type="text"]').autocomplete({
        'source':'/user/ajax/search'
    });
});