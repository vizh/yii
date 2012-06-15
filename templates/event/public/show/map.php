<script src="http://api-maps.yandex.ru/1.1/index.xml?key=AALEwk0BAAAAEa_5EwIAvRMrqS5OTlCVonGim9-DFyUmyYYAAAAAAAAAAADcDy3TT0owKhCZ7GexLgGYR8E94g==" type="text/javascript"></script>
<script type="text/javascript">
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
</script>

<div id="YMapsID" style="width:242px;height:280px" addr="<?=$this->Place;?>"></div>
