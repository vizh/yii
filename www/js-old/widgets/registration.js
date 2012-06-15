function parseXML() {
  try {
    xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
    xmlDoc.async = "false";
    xmlDoc.loadXML(text);
  }
  catch(e) {
    try {
      parser = new DOMParser();
      xmlDoc = parser.parseFromString(text,"text/xml");
    }
    catch(e) {
      alert(e.message);
      return;
    }
  }
  document.getElementById("to").innerHTML=xmlDoc.getElementsByTagName("to")[0].childNodes[0].nodeValue;
  document.getElementById("from").innerHTML=xmlDoc.getElementsByTagName("from")[0].childNodes[0].nodeValue;
  document.getElementById("message").innerHTML=xmlDoc.getElementsByTagName("body")[0].childNodes[0].nodeValue;
}