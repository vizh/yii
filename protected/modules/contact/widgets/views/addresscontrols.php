<?php
/**
 * @var \contact\widgets\AddressControls $this
 */

?>
<script type="text/javascript">
    var GeoPoint = [];
    var GoogleMapsApiKey = '<?= Yii::app()->params['GoogleMapsApiKey'] ?>';
    var requestCoordinatesUrl = '<?= \Yii::app()->createUrl('/geo/admin/ajax/getCoordinatesByAddress')?>';

    <? if( !empty($form->GeoPoint[0]) && !empty($form->GeoPoint[1]) ): ?>
    GeoPoint = JSON.parse('[<?= implode(',', $form->GeoPoint) ?>]');
    <? endif; ?>
</script>

<div class="widget-address-controls">
    <div class="controls">
        <?= \CHtml::activeTextField($form, 'CityLabel', ['placeholder' => $this->inputPlaceholder, 'class' => $this->inputClass, 'disabled' => $this->disabled]) ?>
    </div>
    <? if ($address): ?>
        <div class="controls m-top_5">
            <?= \CHtml::activeTextField($form, 'Street', ['placeholder' => $form->getAttributeLabel('Street'), 'class' => $this->inputClass, 'disabled' => $this->disabled]) ?>
        </div>
        <div class="controls m-top_5">
            <?= \CHtml::activeTextField($form, 'House', ['placeholder' => $form->getAttributeLabel('House'), 'class' => $this->inputClass, 'disabled' => $this->disabled]) ?>
        </div>
        <div class="controls m-top_5">
            <?= \CHtml::activeTextField($form, 'Building', ['placeholder' => $form->getAttributeLabel('Building'), 'class' => $this->inputClass, 'disabled' => $this->disabled]) ?>
        </div>
        <div class="controls m-top_5">
            <?= \CHtml::activeTextField($form, 'Wing', ['placeholder' => $form->getAttributeLabel('Wing'), 'class' => $this->inputClass, 'disabled' => $this->disabled]) ?>
        </div>
    <? endif ?>

    <? if ($place): ?>
        <div class="controls m-top_5">
            <?= \CHtml::activeTextField($form, 'Place', ['placeholder' => $form->getAttributeLabel('Place'), 'class' => $this->inputClass]) ?>
        </div>
    <? endif ?>

    <? if ($apartment): ?>
        <div class="controls m-top_5">
            <?= \CHtml::activeTextField($form, 'Apartment', ['placeholder' => $form->getAttributeLabel('Apartment'), 'class' => $this->inputClass]) ?>

        </div>
    <? endif ?>

    <? if ($geoPointCoordinates): ?>

        <div class="controls m-top_5">
            <?= CHtml::button(Yii::t('app', 'Найти место на карте'), [
                'class' => 'btn btn-success span12',
                'onClick' => 'requestCoordinates();return false;'

            ]) ?>
        </div>
        <div class="controls m-top_5">

            <?= \CHtml::textField(
                'contact\models\forms\Address[GeoPoint][]',
                $form->GeoPoint[0],
                [
                    'placeholder' => $form->getAttributeLabel('Latitude'),
                    'class' => $this->inputClass,
                    'id' => 'GeoPointCoordinatesLatitude',
                    'style' => 'width: 105px; margin-right: 9px;',
                ]
            ) ?>
            <?= \CHtml::textField(
                'contact\models\forms\Address[GeoPoint][]',
                $form->GeoPoint[1],
                [
                    'placeholder' => $form->getAttributeLabel('Longitude'),
                    'class' => $this->inputClass,
                    'id' => 'GeoPointCoordinatesLongitude',
                    'style' => 'width: 105px; margin-right: 9px;',
                ]
            ) ?>

            <?= \CHtml::textField(
                'contact\models\forms\Address[GeoPoint][]',
                $form->GeoPoint[2],
                [
                    'placeholder' => $form->getAttributeLabel('MapScale'),
                    'class' => $this->inputClass,
                    'id' => 'GeoPointCoordinatesMapScale',
                    'style' => 'width: 105px;',
                ]
            ) ?>
        </div>
        <div class="controls m-top_5" style="width: 390px;height: 350px;">
            <div style="margin: 10px 0; color: #666;">Для указания координат места проведения мероприятия установите
                маркер на карте лев. кн. мыши.<br>
                Важно: масштаб карты сохраняется и используется для карты в билете!
            </div>
            <div id="map" style="width: 100%;height: 300px;"></div>
        </div>
    <? endif ?>


    <?= \CHtml::activeHiddenField($form, 'CityId') ?>
    <?= \CHtml::activeHiddenField($form, 'CountryId') ?>
    <?= \CHtml::activeHiddenField($form, 'RegionId') ?>
</div>