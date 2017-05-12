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
    this.initScale = 12;
    this.scriptAdded = false;
    this.onFinishRequestCoordinatesFnc = null;
    this.onScaleChangedFnc = null;
    this.requestCoordinatesUrl = '';

    return this;
}

GoogleMapsUtil.prototype.constructor = GoogleMapsUtil;

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

    this.map.addListener('center_changed', function () {
        window.setTimeout(function () {
            self.map.panTo(marker.getPosition());
        }, 3000);
    });

    this.map.addListener('zoom_changed', function () {
        var scale = self.map.getZoom();
        self.onScaleChanged(scale);
    });
    return this;
};

GoogleMapsUtil.prototype.onScaleChanged = function (fnc) {

    if (typeof fnc == 'function') {
        this.onScaleChangedFnc = fnc;
        return this;
    }

    if (typeof this.onScaleChangedFnc == 'function') {
        return this.onScaleChangedFnc(fnc);
    }

    return this;
}
GoogleMapsUtil.prototype.setInitScale = function (initScale) {
    this.initScale = initScale;
    return this;
};
GoogleMapsUtil.prototype.getMapScale = function () {
    return this.map.getZoom();
}
GoogleMapsUtil.prototype.setMapScale = function (scale) {
    this.map.setZoom(scale);
    return this;
}

/**
 * @param initPoint //-25.363, 131.044
 */
GoogleMapsUtil.prototype.setInitMarker = function (point) {
    if (!point[0] || !point[1]) {
        return this;
    }

    this.initMarker = {lat: point[0], lng: point[1]};
    this.initScale = point[2];
    return this;
};
GoogleMapsUtil.prototype.drawInitMarker = function () {
    if (this.initMarker) {
        this.placeMarker(this.initMarker);
    }
    if (this.initScale) {
        this.setMapScale(this.initScale);
    }
    return this;
}

GoogleMapsUtil.prototype.createMarker = function (point) {
    if (!point[0] || !point[1]) {
        return this;
    }

    return {lat: parseFloat(point[0]), lng: parseFloat(point[1])};
};
GoogleMapsUtil.prototype.clearMarker = function () {
    this.marker.setMap(null);
}
GoogleMapsUtil.prototype.placeMarker = function (location) {
    var self = this;

    this.marker = new google.maps.Marker({
        position: location,
        map: self.map
    });

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
        zoom: this.initScale,
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
/**
 *
 * @param url
 * @returns {*}
 */
GoogleMapsUtil.prototype.setRequestCoordinatesUrl = function (url) {
    this.requestCoordinatesUrl = url;
    return this;
}

GoogleMapsUtil.prototype.getRequestCoordinatesUrl = function () {
    return this.requestCoordinatesUrl;
}
/**
 *
 * @returns {GoogleMapsUtil}
 */
GoogleMapsUtil.prototype.requestCoordinates = function (geocode) {
    var self = this;
    $.ajax({
        url: this.requestCoordinatesUrl,
        dataType: "json",
        context: document.body,
        data: {
            geocode: geocode
        },
        method: 'POST'
    }).done(function (resp) {
        self.onFinishRequestCoordinates(resp);
    });

    return this;
};
/**
 *
 * @param fnc
 * @returns {*}
 */
GoogleMapsUtil.prototype.onFinishRequestCoordinates = function (fnc) {

    if (typeof fnc == 'function') {
        this.onFinishRequestCoordinatesFnc = fnc;
        return this;
    }

    if (typeof this.onFinishRequestCoordinatesFnc == 'function') {
        return this.onFinishRequestCoordinatesFnc(fnc);
    }

    return this;
};