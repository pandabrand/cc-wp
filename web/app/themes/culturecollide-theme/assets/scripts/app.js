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

function mediaSize() {
 /* Set the matchMedia */
 if (window.matchMedia('(max-width: 480px)').matches) {
   /* Changes when we reach the min-width  */
   jQuery('.cc-img-media-wrapper, .editorial__detail__feature_media').each(function() {
     var left_offset = jQuery(this).offset();
     jQuery(this).css('margin-left', left_offset.left * -1);
   });
 } else {
   /* Reset for CSS changes – Still need a better way to do this! */
   jQuery('.cc-img-media-wrapper, .editorial__detail__feature_media').each(function() {
     jQuery(this).css('margin-left', 0);
   });
 }
}
