var RIdWidget = new function () {
  function RIdWidget(container) {
    this.baseUrl = 'http://runet-id.com/widget/main/index';
    this.url = document.location;
    this.container = container;
    this.apiKey = container.getAttribute('data-apikey');
    this.widget = container.getAttribute('data-widget');
    this.action = container.getAttribute('data-action');

    this.preloader = document.createElement('div');
    this.preloader.setAttribute('style', "display:block;position:absolute;left:50%;margin-left:-50px;height:50px;width:50px;background: url('http://runet-id.com/images/api/widget-preloder.gif') no-repeat center center;");
    this.container.appendChild(this.preloader);

    this.initSocket();
  }

  RIdWidget.prototype.initSocket = function(){
    var self = this;
    var socket = new easyXDM.Socket({
      remote : self.getUrl(),
      container : self.container,
      onMessage: function(message, origin){
        self.preloader.style.display = 'none';
        var iframe = this.container.getElementsByTagName("iframe")[0];
        iframe.style.height = message+'px'; iframe.style.width  = '100%';
      }
    });
  };

  RIdWidget.prototype.getUrl = function(){
    var self = this;
    var action = self.action != null ? self.action : 'index';

    var url = '/widget/' + self.widget + '/'+action+'?' + '&apikey='+ self.apiKey + '&url=' + self.url;
    for (var i = 0; i < this.container.attributes.length; i++) {
      var attr = this.container.attributes.item(i);
      if (attr.nodeName.indexOf('data-param-') != -1) {
        url += '&'+attr.nodeName.substr(5)+'='+attr.nodeValue;
      }
    }

    url = self.baseUrl + '?url=' + encodeURIComponent(url);
    return url;
  };
  return RIdWidget;
};

window.onload = function () {
    var widgets = document.querySelectorAll('.rid-widget');
  for (var i = 0; i < widgets.length; i++){
    var widget = widgets[i];
    new RIdWidget(widget);
  }
}