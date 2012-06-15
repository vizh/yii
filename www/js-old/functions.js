var buffer = null;

var wu = {

  Ajax: function (url, log, loading, complete) {
    var log = $(log).addClass('ajax-loading');
    var req = new Ajax(url, {
                    method: 'get',
                    update: log,
                    onComplete: function () {
                      if (loading) log.removeClass('ajax-loading');
                      if (complete != '') complete();
                      buffer = null;
                    }
                  }).request();
  },
  
  AjaxTimed: function (interval, url, log, loading, complete) {
    var log = $(log).addClass('ajax-loading');
    var action = function () {
      wu.Ajax(url, log, loading, complete);
    }
    buffer = (buffer == null) ? setTimeout(action, interval) : buffer;
  },
  
  buildOptions: function (defValue, defText, items, element) {

    element.empty();
    element.options[0] = new Option(defText, defValue);
    if (items.value != 0) {
      for (var i = 0; i < items.length; i++) {
        element.options[i+1] = new Option(items[i].name, items[i].id);
      }
    }

  }

};