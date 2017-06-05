$(function () {
    var title = $('.b-event-promo .title');
    var words = title.text().split(' ');
    var buffer = '';
    var lines = [];

    title.html(words[0]);
    var height = title.height();
    title.html('');

    $.each(words, function (i, word) {
        title.html(buffer + ' ' + word);
        if (title.height() == height) {
            buffer += (buffer.length != 0 ? ' ' : '') + word;
        }
        else {
            lines.push(buffer);
            buffer = word;
        }
    });
    lines.push(buffer);

    title.html('');
    $.each(lines, function (i, line) {
        title.append('<span>' + line + '</span>');
        if ((i + 1) !== lines.length) {
            title.append('<br/>');
        }
    });
    title.css('font-size', '25px');
});
