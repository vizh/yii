window.ContactMapKeeper = (function () {
    this.__map = null;
    var self = this;
    return {
        map:function (map) {
            if (undefined !== map) {
                self.__map = map;
            } else {
                return self.__map;
            }
        }
    }
})();

$(function () {
    $(".map-road").click(function () {
        $(".map-road").removeClass("current");
        $(this).addClass("current");
    });

    var pos = new google.maps.LatLng(55.742119, 37.609524),
        init_scale = 15,
        opts = {
            scrollwheel:false,
            zoom:init_scale,
            center:pos,
            mapTypeId:google.maps.MapTypeId.SATELLITE
        },
        map = new google.maps.Map(document.getElementById("map"), opts),

        bounds = new google.maps.LatLngBounds(
            new google.maps.LatLng(55.73876, 37.6024),
            new google.maps.LatLng(55.74631, 37.61510)
        ),
        overlays = {},
        overlay_images = {
            19:'http://digitaloctober.ru/system/map/map19.png',
            17:'http://digitaloctober.ru/system/map/map17.png',
            15:'http://digitaloctober.ru/system/map/map15.png'
        },
        overlays_map = {
            22:19,
            21:19,
            20:19,
            19:19,
            18:17,
            17:17,
            16:15,
            15:15,
            14:15,
            13:15
        },
        map_zoom = function (zoom) {
            return (overlays_map[zoom] !== undefined) ? overlays_map[zoom] : null
        },
        markerIcon = new google.maps.MarkerImage(
            'http://digitaloctober.ru/system/map/map19-marker.png',
            new google.maps.Size(160, 120),
            new google.maps.Point(0, 0),
            new google.maps.Point(160, 60)
        ),
        marker = new google.maps.Marker({
            icon:markerIcon,
            position:new google.maps.LatLng(55.740804, 37.60925),
            map:map
        });

    ContactMapKeeper.map(map);

    for (var k in overlay_images) {
        if (overlay_images.hasOwnProperty(k)) {
            img = new Image();
            img.src = overlay_images[k];
        }
    }

    overlays[init_scale] = new USGSOverlay(bounds, overlay_images[init_scale], map);

    google.maps.event.addListener(map, 'zoom_changed', function () {
        var z = parseInt(map.getZoom());
        z = map_zoom(z);
        if (z !== null) {
            if (overlays[z] === undefined)
                if (overlay_images[z] !== undefined)
                    overlays[z] = new USGSOverlay(bounds, overlay_images[z], map);
        }

        for (var key in overlays)
            if (overlays.hasOwnProperty(key)) {
                if (key == z) {
                    overlays[key].show()
                } else {
                    overlays[key].hide()
                }
            }
    });
})

// google tutorial code starts here

function USGSOverlay(bounds, image, map) {

    // Now initialize all properties.
    this.bounds_ = bounds;
    this.image_ = image;
    this.map_ = map;

    // We define a property to hold the image's
    // div. We'll actually create this div
    // upon receipt of the add() method so we'll
    // leave it null for now.
    this.div_ = null;

    // Explicitly call setMap() on this overlay
    this.setMap(map);
}

USGSOverlay.prototype = new google.maps.OverlayView();

USGSOverlay.prototype.onAdd = function () {

    // Note: an overlay's receipt of onAdd() indicates that
    // the map's panes are now available for attaching
    // the overlay to the map via the DOM.

    // Create the DIV and set some basic attributes.
    var div = document.createElement('DIV');
    div.style.border = "none";
    div.style.borderWidth = "0px";
    div.style.position = "absolute";

    // Create an IMG element and attach it to the DIV.
    var img = document.createElement("img");
    img.src = this.image_;
    img.style.width = "100%";
    img.style.height = "100%";
    div.appendChild(img);

    // Set the overlay's div_ property to this DIV
    this.div_ = div;

    // We add an overlay to a map via one of the map's panes.
    // We'll add this overlay to the overlayImage pane.
    var panes = this.getPanes();
    panes.overlayLayer.appendChild(div);
}

USGSOverlay.prototype.draw = function () {

    // Size and position the overlay. We use a southwest and northeast
    // position of the overlay to peg it to the correct position and size.
    // We need to retrieve the projection from this overlay to do this.
    var overlayProjection = this.getProjection();

    // Retrieve the southwest and northeast coordinates of this overlay
    // in latlngs and convert them to pixels coordinates.
    // We'll use these coordinates to resize the DIV.
    var sw = overlayProjection.fromLatLngToDivPixel(this.bounds_.getSouthWest());
    var ne = overlayProjection.fromLatLngToDivPixel(this.bounds_.getNorthEast());

    // Resize the image's DIV to fit the indicated dimensions.
    var div = this.div_;
    div.style.left = sw.x + 'px';
    div.style.top = ne.y + 'px';
    div.style.width = (ne.x - sw.x) + 'px';
    div.style.height = (sw.y - ne.y) + 'px';
}

USGSOverlay.prototype.onRemove = function () {
    this.div_.parentNode.removeChild(this.div_);
    this.div_ = null;
}

// the next 3 methods are fixed: visibility:hidden doesn't 
// affects the browser rendering speed, so we should use display:none here

USGSOverlay.prototype.hide = function () {
    if (this.div_) {
        this.div_.style.display = "none";
    }
}

USGSOverlay.prototype.show = function () {
    if (this.div_) {
        this.div_.style.display = "block";
    }
}

USGSOverlay.prototype.toggle = function () {
    if (this.div_) {
        if (this.div_.style.display == "none") {
            this.show();
        } else {
            this.hide();
        }
    }
}

USGSOverlay.prototype.toggleDOM = function () {
    if (this.getMap()) {
        this.setMap(null);
    } else {
        this.setMap(this.map_);
    }
}

$(function () {

    var directionsService = new google.maps.DirectionsService();
    var directionsDisplay = new google.maps.DirectionsRenderer({
        'map':ContactMapKeeper.map(),
        'preserveViewport':true,
        'draggable':true
    });

    var points = {
        walking:[
            new google.maps.LatLng(55.745984, 37.605515),
            new google.maps.LatLng(55.745326, 37.604281),
            new google.maps.LatLng(55.745008, 37.604914),
            new google.maps.LatLng(55.744514, 37.604536),
            new google.maps.LatLng(55.744054, 37.605663),
            new google.maps.LatLng(55.743981, 37.607057),
            new google.maps.LatLng(55.743111, 37.609289),
            new google.maps.LatLng(55.740811, 37.608538)
        ],

        driving2:[
            new google.maps.LatLng(55.749156, 37.608615),
            new google.maps.LatLng(55.74862, 37.610493),
            new google.maps.LatLng(55.743151, 37.614921),
            new google.maps.LatLng(55.742443, 37.61343),
            new google.maps.LatLng(55.740482, 37.611156),
            new google.maps.LatLng(55.741563, 37.608945)
        ],

        driving1:[
            new google.maps.LatLng(55.739465, 37.616245),
            new google.maps.LatLng(55.740542, 37.616749),
            new google.maps.LatLng(55.743242, 37.615151),
            new google.maps.LatLng(55.743859, 37.615365),
            new google.maps.LatLng(55.746414, 37.613239),
            new google.maps.LatLng(55.745709, 37.61178),
            new google.maps.LatLng(55.743128, 37.614894),
            new google.maps.LatLng(55.742443, 37.61343),
            new google.maps.LatLng(55.740482, 37.611156),
            new google.maps.LatLng(55.741563, 37.608945)
        ],

        walkingPol:[
            new google.maps.LatLng(55.736755, 37.618687),
            new google.maps.LatLng(55.736835, 37.619160),
            new google.maps.LatLng(55.737530, 37.618752),
            new google.maps.LatLng(55.737053, 37.617218),
            new google.maps.LatLng(55.737000, 37.616810),
            new google.maps.LatLng(55.738262, 37.615471),
            new google.maps.LatLng(55.738358, 37.615040),
            new google.maps.LatLng(55.738766, 37.615353),
            new google.maps.LatLng(55.739758, 37.614857),
            new google.maps.LatLng(55.741264, 37.613670),
            new google.maps.LatLng(55.741306, 37.613258),
            new google.maps.LatLng(55.741718, 37.612350),
            new google.maps.LatLng(55.740532, 37.611076),
            new google.maps.LatLng(55.741364, 37.609322),
            new google.maps.LatLng(55.741089, 37.609104)
        ],

        walkingTr:[
            new google.maps.LatLng(55.740776, 37.625591),
            new google.maps.LatLng(55.740913, 37.625591),
            new google.maps.LatLng(55.741013, 37.623631),
            new google.maps.LatLng(55.740963, 37.622917),
            new google.maps.LatLng(55.740677, 37.621674),
            new google.maps.LatLng(55.743469, 37.619694),
            new google.maps.LatLng(55.743996, 37.619095),
            new google.maps.LatLng(55.744701, 37.618038),
            new google.maps.LatLng(55.743561, 37.615387),
            new google.maps.LatLng(55.743156, 37.615185),
            new google.maps.LatLng(55.742710, 37.613815),
            new google.maps.LatLng(55.742180, 37.612900),
            new google.maps.LatLng(55.740524, 37.611080),
            new google.maps.LatLng(55.741356, 37.609325),
            new google.maps.LatLng(55.741142, 37.609077)
        ]
    }

    var path;

    $(".contact-tab").click(function (e) {
        e.preventDefault();
        $(".underneath").hide();
        $(".contact-tab").removeClass("active");
        $(this).addClass("active")
        if (undefined !== path) {
            path.setMap(null);
            delete path;
        }
    });

    $(".walking").click(function () {
        $("#walking").show()
        $('ul.contacts.underneath').show()

        if (undefined !== path) {
            path.setMap(null);
            delete path;
        }

        path = new google.maps.Polyline({
            path:points.walking,
            strokeColor:"#0000FF",
            strokeOpacity:0.5,
            strokeWeight:5
        });
        path.setMap(ContactMapKeeper.map());
        // body_h();
    });

    $(".driving1").click(function () {
        $("#driving1").show()

        path = new google.maps.Polyline({
            path:points.driving1,
            strokeColor:"#0000FF",
            strokeOpacity:0.5,
            strokeWeight:5
        });
        path.setMap(ContactMapKeeper.map());
        // body_h();
    });

    $(".driving2").click(function () {
        $("#driving2").show()

        path = new google.maps.Polyline({
            path:points.driving2,
            strokeColor:"#0000FF",
            strokeOpacity:0.5,
            strokeWeight:5
        });
        path.setMap(ContactMapKeeper.map());
        // body_h();
    });

    $("#kropotkinskaya").click(function () {
        $("#walking").show()
        if (undefined !== path) {
            path.setMap(null);
            delete path;
        }

        path = new google.maps.Polyline({
            path:points.walking,
            strokeColor:"#0000FF",
            strokeOpacity:0.5,
            strokeWeight:5
        });
        path.setMap(ContactMapKeeper.map());
        // body_h();
    });

    $("#polyanka").click(function () {
        $("#walkingPol").show()
        if (undefined !== path) {
            path.setMap(null);
            delete path;
        }

        path = new google.maps.Polyline({
            path:points.walkingPol,
            strokeColor:"#0000FF",
            strokeOpacity:0.5,
            strokeWeight:5
        });
        path.setMap(ContactMapKeeper.map());
        // body_h();
    });
    $("#tretyakovskaya").click(function () {
        $("#walkingTr").show()
        if (undefined !== path) {
            path.setMap(null);
            delete path;
        }

        path = new google.maps.Polyline({
            path:points.walkingTr,
            strokeColor:"#0000FF",
            strokeOpacity:0.5,
            strokeWeight:5
        });
        path.setMap(ContactMapKeeper.map());
        // body_h();
    });

    $(".contact-tab").eq(0).trigger("click")

    $('ul.contacts.underneath li').click(function () {
        if ($(this).children('a').length > 0) {
            $('ul.contacts.underneath li').each(function () {
                $(this).html('<a href="#">' + $(this).text() + '</a>')
            })
            $('#walking').children().not('.title_sm').hide()
            $(this).html($(this).text())
            $('.' + $(this).attr('id')).show()
        }
    })
    $('ul.contacts.underneath #kropotkinskaya').trigger('click')

})
