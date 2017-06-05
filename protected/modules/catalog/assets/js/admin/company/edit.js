$(function () {
    $('input[name*="Edit[CompanyId]"]').autocomplete({
        source:'/company/ajax/search'
    });
});