function DivMarker(latlng,  map, value) {
    this.latlng_ = latlng;
    this.value = value;
    /*Do this or nothing will happen:*/
    this.setMap(map);
}

DivMarker.prototype = new google.maps.OverlayView();
DivMarker.prototype.draw = function() {
    var me = this;
    var div = this.div_;
    if (!div) {
        // Create a overlay text DIV
        div = this.div_ = document.createElement('DIV');
        div.style.border = "none";
        div.style.position = "absolute";
        div.style.paddingLeft = "0px";
        div.style.cursor = 'pointer';

        var span = document.createElement("span");
        span.style.color = "#000000";
        span.style.fontWeight = "bolder";
        span.style.fontSize = "1em";
        span.style.paddingLeft = "0px";
        span.style.position = "absolute";
        span.className = "markerOverlay";
        span.appendChild(document.createTextNode(this.value));
        div.appendChild(span);
        google.maps.event.addDomListener(div, "click", function(event) {
        google.maps.event.trigger(me, "click");
    });

    // Then add the overlay to the DOM
    var panes = this.getPanes();
        panes.overlayImage.appendChild(div);
    }

    // Position the overlay
    var point = this.getProjection().fromLatLngToDivPixel(this.latlng_);
    if (point) {
      div.style.left = point.x + 'px';
      div.style.top = point.y + 'px';
    }
};

DivMarker.prototype.remove = function() {
    // Check if the overlay was on the map and needs to be removed.
    if (this.div_) {
        this.div_.parentNode.removeChild(this.div_);
        this.div_ = null;
    }
};

DivMarker.prototype.getPosition = function() {
    return this.latlng_;
};
