<?php
/**
 * @var $this \event\widgets\Location
 */
$address = $this->event->getContactAddress();
if ($address == null)
{
  return;
}
$address->setLocale('ru');
$width = !$this->event->FullWidth ? 218 : 940;
?>

<div class="location">
  <h5 style="z-index: 100;" class="title"><?=Yii::t('app', 'Место проведения');?></h5>
  <div id="ymaps-map-id_13401960168727002685" style="width: <?=$width;?>px; height: 340px;"></div>
</div>
<script type="text/javascript">
function fid_13401960168727002685(ymaps) {
    <?php
        if (!empty($address->GeoPoint)) {
            $points = explode(',', $address->GeoPoint);
            $geo = $points[1].','.$points[0];
        } else {
            $geo =  $address->getShort();
        }
    ?>


    var geocoder = ymaps.geocode("<?=$geo;?>", {result : 1});
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
                        balloonContent: "<strong><?=htmlspecialchars($this->event->Title);?></strong><p><?=htmlspecialchars($address->Place);?></p>"
                    }, { preset: "twirl#redDotIcon"}
                ));
            map.controls.add('smallZoomControl', {top : 45, left : 5});
        }
    );
};
</script>
<script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?coordorder=longlat&load=package.full&wizard=constructor&lang=<?=Yii::app()->language == 'en' ? 'en-US' : 'ru-RU';?>&onload=fid_13401960168727002685"></script>

<?
$address->resetLocale();
