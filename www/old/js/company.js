$(document).ready(function()
{
	var map = new YMaps.Map($("#YMapsID"));
	var place = $("#YMapsID").attr("addr");
	
	map.addOverlay(new YMaps.Geocoder(place, {results: 1, boundedBy: map.getBounds()}));
	var geocoder = new YMaps.Geocoder(place);
	YMaps.Events.observe(geocoder, geocoder.Events.Load, function () {
			if (this.length()) {
				map.setZoom(15, {smooth: 1, centering: 1});
				map.addOverlay(this.get(0));
				map.panTo(this.get(0).getGeoPoint());
			}
	});
	
});