/**
 * Created by artem on 20/01/2017.
 */

/**
 * How to use. Need to have initMap function
 *
 * function initMap(){
                    var gMap = new GoogleMapsUtil('map');
                    gMap.setInitPoint(-25.363, 131.044);
                    gMap.setApiKey('api-key');
                    gMap.onClick(function(event){
                        var pos = gMap.getMarkerPos();
                        console.log( pos.lat(),pos.lng() );
                    });
                    gMap.init();
                }
 * */
var GoogleMapsUtil = function (idElem) {
    this.idElem = idElem;
    this.map = null;
    this.marker = null;
    this.initPoint = null;
    this.initMarker = null;
    this.onClickFnc = null;
    this.apiKey = '';
    this.initZoom = 7;
    this.scriptAdded = false;

    return this;
}

GoogleMapsUtil.prototype.constructor = GoogleMapsUtil;
GoogleMapsUtil.prototype.setInitZoom = function (initZoom) {
    this.initZoom = initZoom;
    return this;
};
GoogleMapsUtil.prototype.init = function () {
    if (!this.scriptAdded) {
        return this;
    }
    this.initMap();
    this.bindEvents();
    return this;
};

GoogleMapsUtil.prototype.setApiKey = function (apiKey) {
    this.apiKey = apiKey;
    return this;
}
GoogleMapsUtil.prototype.appendApiScript = function () {

    if (!this.apiKey) {
        return;
    }

    var script = document.createElement('script');
    script.type = "text/javascript";
    script.setAttribute('src', 'https://maps.googleapis.com/maps/api/js?key=' + this.apiKey + '&callback=initMap');
    script.setAttribute('async', '');
    script.setAttribute('defer', '');

    document.head.appendChild(script);
    this.scriptAdded = true;
}
/**
 * @param initPoint //-25.363, 131.044
 */
GoogleMapsUtil.prototype.setInitMarker = function (point) {
    if (!point[0] || !point[1]) {
        return this;
    }

    this.initMarker = {lat: point[0], lng: point[1]};
    return this;
};
GoogleMapsUtil.prototype.setDefaultPoint = function (lat, lng) {
    this.initPoint = {lat: lat, lng: lng};
    return this;
};
GoogleMapsUtil.prototype.bindEvents = function () {
    var self = this;
    google.maps.event.addListener(this.map, 'click', function (event) {
        if (self.marker) {
            self.marker.setMap(null);
        }
        self.placeMarker(event.latLng);
        self.onClick(event);

        event.stop();
    });

    map.addListener('center_changed', function () {
        window.setTimeout(function () {
            map.panTo(marker.getPosition());
        }, 3000);
    });
    return this;
};
GoogleMapsUtil.prototype.placeMarker = function (location) {
    var self = this;
    this.marker = new google.maps.Marker({
        position: location,
        map: self.map
    });

    return this;
}
GoogleMapsUtil.prototype.drawInitMarker = function () {
    if (this.initMarker) {
        this.placeMarker(this.initMarker);
    }
    return this;
}
GoogleMapsUtil.prototype.getMarkerPos = function () {
    return this.marker.getPosition();
}
/**
 * On map click
 * @param fnc
 * @returns {GoogleMapsUtil}
 */
GoogleMapsUtil.prototype.onClick = function (fnc) {
    if (typeof fnc == 'function') {
        this.onClickFnc = fnc;
        return this;
    }
    if (typeof this.onClickFnc == 'function') {
        this.onClickFnc(fnc);
    }
}

GoogleMapsUtil.prototype.initMap = function () {
    var self = this;

    var defaultParams = {
        zoom: this.initZoom,
    };

    if (this.initMarker) {
        defaultParams.center = this.initMarker;
    } else if (this.initPoint) {
        defaultParams.center = this.initPoint;
    }

    this.map = new google.maps.Map(document.getElementById(this.idElem), defaultParams);

    this.drawInitMarker();
    return this;
};