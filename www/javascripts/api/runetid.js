var RunetId = new function() {
  var instance;


  // Конструктор
  function RunetId(){
    if (!instance)
    {
      instance = this;
    }
    else
    {
      return instance;
    }

    this.url = 'http://runetid.internetmediaholding.com/oauth/main/dialog/';
    this.width = 620;
    this.height = 662;
    this.PopUpWindow = null;

    this.apiKey = '';
    this.rState = '';
    this.backUrl = location.href;
  }

  // Публичные методы
  RunetId.prototype.init = function(options){
    this.apiKey = options.apiKey;
    this.rState = options.rState;

    if (typeof(options.backUrl) != 'undefined')
    {
      this.backUrl = options.backUrl;
    }
  };

  RunetId.prototype.login = function(){
    var windowDimensions = this.windowDimensions();
    var left = (windowDimensions.width - this.width) / 2;
    var top = (windowDimensions.height - this.height) / 2;
    if (this.PopUpWindow != null)
    {
      this.PopUpWindow.close();
    }
    this.PopUpWindow = window.open(this.getUrl(), 'RocId', 'menubar=no,width='+this.width+',height='+this.height+',toolbar=no,left='+left+',top='+top);
  };

  RunetId.prototype.getUrl = function(){
    return this.url + '?apikey=' + encodeURIComponent(this.apiKey) + '&url='+encodeURIComponent(this.backUrl) + '&r_state='+encodeURIComponent(this.rState);
  };

  RunetId.prototype.windowDimensions = function(){
    var myWidth = 0, myHeight = 0;
    if( typeof( window.innerWidth ) == 'number' ) {
      //Non-IE
      myWidth = window.innerWidth;
      myHeight = window.innerHeight;
    } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
      //IE 6+ in 'standards compliant mode'
      myWidth = document.documentElement.clientWidth;
      myHeight = document.documentElement.clientHeight;
    } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
      //IE 4 compatible
      myWidth = document.body.clientWidth;
      myHeight = document.body.clientHeight;
    }
    return {width: myWidth, height: myHeight};
  };

  return RunetId;
};
var rID = new RunetId();
window.rIDAsyncInit();
