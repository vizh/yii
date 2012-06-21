<div id="ymaps-map-id_13401960168727002685" style="width: 245px; height: 332px;"></div>
<script type="text/javascript">
function fid_13401960168727002685(ymaps) {     
    var geocoder = ymaps.geocode("<?php echo addslashes($this->Place);?>", {result : 1}); 
    geocoder.then(
        function (response) {
            var map = new ymaps.Map("ymaps-map-id_13401960168727002685", {
                center : response.geoObjects.get(0).geometry.getCoordinates(),
                zoom: 14,
                type: "yandex#map"
            });
            map.geoObjects
                .add(new ymaps.Placemark(
                    response.geoObjects.get(0).geometry.getCoordinates(), {
                        balloonContent: "<strong><?php echo htmlspecialchars($this->Name);?></strong><p><?php echo htmlspecialchars($this->Place);?></p>"
                    }, { preset: "twirl#redDotIcon"}
                ));
            map.controls.add('smallZoomControl', {top : 5, left : 5});
        }
    );
};
</script>
<script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?coordorder=longlat&load=package.full&wizard=constructor&lang=ru-RU&onload=fid_13401960168727002685"></script>
<!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту (конец) -->