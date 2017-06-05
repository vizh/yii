$(function () {
    var $searchForm = $('.search-well form');
    $searchForm.submit(function () {
        var url = $searchForm.find('select option:selected').data('url-pattern');
        url = url.replace(new RegExp('#query#', 'g'), $searchForm.find('input[type="text"]').val());
        document.location.href = url;
        return false;
    });
});