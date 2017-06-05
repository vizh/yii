// events-calendar_scroll.js
$(document).scroll(function () {
    var fixed = $('#b-fixed').offset().top
    $('.scroll').each(function () {
        var element = $(this),
            parent = element.parent(),
            parentTop = parent.offset().top,
            parentBottom = parentTop + parent.outerHeight() - element.outerHeight();
        if (fixed <= parentTop) {
            element.removeClass('p-fixed').addClass('p-static');
        } else if (element.offset().top < fixed && fixed < parentBottom) {
            element.removeClass('p-static').addClass('p-fixed');
        } else if (fixed >= parentBottom) {
            element.removeClass('p-fixed').addClass('p-absolute');
        } else if (fixed < parentBottom) {
            element.removeClass('p-absolute').addClass('p-fixed');
        }
    });
});
////

// events-calendar_position.js
var EventsLayout = function () {
    var
        COLS = 4, /* количество колонок */
        MIN_H = 200, /* высота пустой колонки */
        H = 400, /* высотка колонки с событием */
        B = 2, /* ширина бордюра */
        DAY_W = 80, /* ширина колонки с датами */
        EVENT_W = 185;
    /* ширина колонки с событиями */

    this.layout = function (selector) {
        var
            $root = $(selector),
            events = collectEvents($root),
            distributed = distributeByDays(events),
            compiled = _.template("<div class='event datetime'><div class='date scroll'><%= dateName %></div></div>"),
            totalHgt;

        _.each(distributed, function (item) {
            splitOnColumns(item.data);
        });
        totalHgt = calculatePositions(distributed);

        _.each(distributed, function (item) {
            $(compiled({dateName:item.date.split('/')[2]}))
                .css({
                    height:px(item.height),
                    left:px(0),
                    top:px(item.top)
                })
                .prependTo($root);
        });

        _.each(events, function (e) {
            if (e.duration > 1) {
                e.height -= 2 * B;
            }

            var
                left = DAY_W + B + (e.column - 1) * EVENT_W + B * (e.column - 1),
                height = e.height,
                top = e.top;

            e.el.css({
                height:px(height),
                left:px(left),
                top:px(top)
            });

            if (e.duration > 1) {
                e.el.find('.details').addClass('scroll');
            }
        });

        $root.css({height:px(totalHgt)});
    };

    function px(value) {
        return value + "px";
    }

    function collectEvents($root) {
        return $root.find('.event').map(function () {
            var $this = $(this);
            return {
                el:$this,
                startDate:new Date($this.attr('data-startdate')),
                duration:parseInt($this.attr('data-duration'))
            };
        });
    }

    function distributeByDays(events) {
        var
            map = {},
            dateKeys = {},
            dates;

        function addElement(date, entry) {
            var
                k = key(date),
                elements = map[k];

            if (elements === undefined) {
                map[k] = (elements = []);
            }
            elements.push(entry);

            dateKeys[k] = new Date(date);
        }

        function newEntry(event, type) {
            return {event:event, fillType:type};
        }

        _.each(events, function (event) {
            var
                i, date, type;

            if (event.duration == 1) {
                addElement(event.startDate, newEntry(event, 'standalone'));
            } else {
                date = event.startDate;
                for (i = 1; i <= event.duration; i++) {
                    if (i === 1) {
                        type = 'start';
                    }
                    else if (i === event.duration) {
                        type = 'end';
                    }
                    else {
                        type = 'fill';
                    }

                    addElement(date, newEntry(event, type));
                    date.setDate(date.getDate() + 1);
                }
            }
        });

        dates = _.map(_.uniq(_.sortBy(_.values(dateKeys), function (date) {
            return date;
        }), true), function (e) {
            return key(e);
        });
        return _.map(dates, function (date) {
            return {
                date:date,
                data:map[date]
            };
        });
    }

    function splitOnColumns(cells) {
        var
            longEventsCount = 0, /* количество многодневных событий */
            i, j, avail, eventEntry;

        // многодневные события должны идти в начале
        cells.sort(function (a, b) {
            return b.event.duration - a.event.duration;
        });

        for (i = 0; i < cells.length; i++) {
            if (cells[i].event.duration === 1) {
                break;
            }
            longEventsCount++;
        }

        if ((longEventsCount > COLS) || (longEventsCount == COLS && cells.length > COLS)) {
            throw new Error("can't build events");
        }

        avail = makeCols();
        _.each(cells, function (eventEntry) {
            if (eventEntry.event.column) {
                avail = _.without(avail, eventEntry.event.column);
            }
        });

        for (i = 0; i < longEventsCount; i++) {
            eventEntry = cells[i];
            if (!eventEntry.event.column) {
                eventEntry.event.column = avail.shift();
            }
        }

        i = 0;
        for (j = longEventsCount; j < cells.length; j++) {
            eventEntry = cells[j];
            if (eventEntry.event.column) {
                throw new Error("unexpected state");
            }

            eventEntry.event.column = avail[i % avail.length];
            i++;
        }
    }

    function calculatePositions(distributed) {
        return _.reduce(distributed, function (dy, item) {
                var
                    events = item.data,
                    columnHeight = calcColumnHeightForEvents(events);

                calculateBoundsForEvents(events, dy, columnHeight);

                item.top = dy;
                item.height = columnHeight - 2 * B;

                return dy + columnHeight - B;
            }, 0) + B;
    }

    function calcColumnHeightForEvents(events) {
        var
            onlyFill = !_.find(events, function (e) {
                return e.fillType != 'fill' && e.fillType != 'end';
            }),
            cols, curValue;

        if (onlyFill) {
            return MIN_H + 2 * B;
        } else {
            cols = zeroArray(COLS);
            _.each(events, function (eventEntry) {
                curValue = cols[eventEntry.event.column - 1];
                if (curValue == 0) {
                    cols[eventEntry.event.column - 1] = H + 2 * B;
                } else {
                    cols[eventEntry.event.column - 1] = curValue + H + B;
                }
            });

            return _.max(cols);
        }
    }

    function calculateBoundsForEvents(events, dy, columnHeight) {
        var hDisp = zeroArray(COLS);
        _.each(events, function (eventEntry) {
            if (eventEntry.fillType == 'standalone') {
                if (eventEntry.event.top !== undefined) {
                    throw new Error("unexpected state");
                }

                var adj = hDisp[eventEntry.event.column - 1];
                if (adj == 0) {
                    eventEntry.event.top = dy + adj;
                } else {
                    eventEntry.event.top = dy + (adj - B);
                }
                hDisp[eventEntry.event.column - 1] += (H + 2 * B);
                eventEntry.event.height = H;
            } else {
                if (eventEntry.event.top === undefined) {
                    eventEntry.event.top = dy;
                    eventEntry.event.height = columnHeight;
                } else {
                    eventEntry.event.height += (columnHeight - B);
                }
            }
        });
    }

    function makeCols() {
        var
            result = [], i;

        for (i = 1; i <= COLS; i++) {
            result.push(i);
        }
        return result;
    }

    function zeroArray(size) {
        var r = [];
        while (size--) {
            r[size] = 0;
        }
        return r;
    }

    function key(date) {
        return date.getFullYear() + "/" + date.getMonth() + "/" + date.getDate();
    }

};

$(function () {
    try {
        new EventsLayout().layout('#events-calendar_content');
    } catch (e) {
        try {
            alert(JSON.stringify(e));
        } catch (e2) {
            alert(e);
        }
    }
});
