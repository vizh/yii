$(function () {
    var CSectionGrid = function () {
        var table = $('table.table');
    }

    CSectionGrid.prototype = {
        'init':function () {

        },
        'addSection':function (title, url, cellIdStart, cellIdEnd) {
            var section = $('<div>', {
                html:'<a href="' + url + '">' + title + '</a>',
            });
            $('body').append(section);
            var style = {
                'position':'absolute',
                'background':'#CCCCCC',
                'padding':'3px',
                'border':'1px solid #000000'
            };

            var
                cellStart = $('#' + cellIdStart),
                cellEnd = $('#' + cellIdEnd);

            var
                position1 = $(cellStart).offset(),
                position2 = $(cellEnd).offset();

            if (position1 !== undefined && position2 !== undefined) {
                style.left = position1.left;
                style.top = position1.top;
                style.width = position2.left + cellEnd.outerWidth() - position1.left - 10;
                style.height = position2.top + cellEnd.outerHeight() - position1.top - 10;
                section.css(style);
            }
        }
    }

    SectionGrid = new CSectionGrid();
});


