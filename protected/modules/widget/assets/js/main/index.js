window.onload = function () {
  var iframe;
  var socket = new easyXDM.Socket({
    onReady : function() {
      iframe = document.createElement("iframe");
      iframe.frameBorder = 0;
      document.body.appendChild(iframe);
      iframe.src = easyXDM.query.url;

      var timer;
      iframe.onload = function() {
        function getDocumentHeight(d) {
          return d.body.clientHeight || d.body.offsetHeight || d.body.scrollHeight;
        }

        iframe.style.visibility = 'hidden';
        iframe.style.height = "1px";
        var originalHeight = getDocumentHeight(iframe.contentWindow.document);
        iframe.style.height = originalHeight+"px";
        iframe.style.visibility = 'visible';

        if(!timer) {
          timer = setInterval(function() {
            try {
              var newHeight = getDocumentHeight(iframe.contentWindow.document);
              if(newHeight != originalHeight) {
                originalHeight = newHeight;
                iframe.style.height = originalHeight+"px";
                socket.postMessage(originalHeight);
              }
            } catch(e) {}
          }, 75);
        }
        socket.postMessage(originalHeight);
      };
    },
    onMessage : function(url, origin) {
      iframe.src = url;
    }
  });
}