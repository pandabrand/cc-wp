var windowObjectReference = null; // g lobal variable

var makepopup = function (el) {
  event.preventDefault();
  if(windowObjectReference == null || windowObjectReference.closed) {
    var left = (screen.width/2)-(300);
    var top = (screen.height/2)-(175);
    windowObjectReference = window.open(el.attr('href'), "_target", "width=600, height=350", top="+top+", left="+left+");
  } else {
    windowObjectReference.focus();
  }
};

function getUrlVars() {
    var vars = {}, hash;
    var search_params = window.location.search;
    search_params = search_params.slice(search_params.indexOf('?')+1);
    console.log(search_params.length);
    if(search.length > 0)
    {
      var hashes = search_params.split('&');
      for(var i = 0; i < hashes.length; i++)
      {
          hash = hashes[i].split('=');
          vars[hash[0]] = hash[1];
      }
    }
    return vars;
}
