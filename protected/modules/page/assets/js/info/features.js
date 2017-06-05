$(function () {
    $('.carousel.slide').bind('slid', function (e) {
        var $target = $(e.currentTarget);
        var index = $target.find('.item.active').index();
        var $ul = $('ul[data-slider="' + $target.attr('id') + '"]');
        $ul.find('li').removeClass('active').eq(index).addClass('active');
    });

    $('ul.f-adv-thesises li').click(function (e) {
        var $target = $(e.currentTarget);
        $('#' + $target.parent('ul').data('slider')).carousel($target.index())
    });

    $('.navbar-features li a').click(function (e) {
        e.preventDefault();
        var hash = $(e.currentTarget).attr('href');
        hash = hash.replace(/^#/, '');
        var node = $('#' + hash);
        node.attr('id', '');
        document.location.hash = hash;
        node.attr('id', hash);

        $('html, body').stop(true);
        $('html, body').animate({
            'scrollTop':node.offset().top - 200
        }, 1000);
    });
});

$(window).load(function () {
    if (document.location.hash != "" && $('body ' + document.location.hash).length == 1) {
        setTimeout(function () {
            $('html, body').scrollTop($(document.location.hash).offset().top - 200);
        }, 10);
    }
});