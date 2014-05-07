var RIdWidget = new function () {
  function RIdWidget(container) {
    this.baseUrl = 'http://runet-id.com/widget/main/index';
    this.url = document.location;
    this.container = container;
    this.apiKey = container.getAttribute('data-apikey');
    this.widget = container.getAttribute('data-widget');;
    this.initSocket();
  }

  RIdWidget.prototype.initSocket = function(){
    var self = this;
    var socket = new easyXDM.Socket({
      remote : self.getUrl(),
      container : self.container,
      onMessage: function(message, origin){
        var iframe = this.container.getElementsByTagName("iframe")[0];
        iframe.style.height = message+'px';
        iframe.style.width  = '100%';
      }
    });
  };

  RIdWidget.prototype.getUrl = function(){
    var self = this;
    var url = self.baseUrl + '?url=' + encodeURIComponent('/widget/' + self.widget + '/index?' + '&apikey='+ self.apiKey + '&url=' + self.url);
    return url;
  };
  return RIdWidget;
};

window.onload = function () {
  var widgets = document.getElementsByClassName('rid-widget');
  for (var i = 0; i < widgets.length; i++){
    var widget = widgets[i];
    new RIdWidget(widget);
  }
}