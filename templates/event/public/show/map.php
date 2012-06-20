<div id="ymaps-map-id_13401960168727002685" style="width: 245px; height: 245px;"></div>
<script type="text/javascript">
function fid_13401960168727002685(ymaps) {
    var map = new ymaps.Map("ymaps-map-id_13401960168727002685", {
        center: [37.57385599999996, 55.84131359778454],
        zoom: 9,
        type: "yandex#map"
    });
    map.controls
        .add("smallZoomControl", {top : 5, left : 5});
        
    
    geoCoder = ymaps.geocode("<?php echo $this->Place;?>"); 
    geoCoder.get(0);
};
</script>
<script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?coordorder=longlat&load=package.full&wizard=constructor&lang=ru-RU&onload=fid_13401960168727002685"></script>