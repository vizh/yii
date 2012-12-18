var Utils = {
  buildOptions: function (defValue, defText, items, element) 
  {
    element.empty();
    element = element[0];
    element.options[0] = new Option(defText, defValue);
    if (items.length != 0) 
    {
      for (var i = 0; i < items.length; i++) 
      {
        element.options[i+1] = new Option(items[i]['name'], items[i]['id']);
      }
    }
  }  
};

/**
 * Support for Object.keys function
 */
if(!Object.keys) Object.keys = function(o){
 if (o !== Object(o))
      throw new TypeError('Object.keys called on non-object');
 var ret=[],p;
 for(p in o) if(Object.prototype.hasOwnProperty.call(o,p)) ret.push(p);
 return ret;
}