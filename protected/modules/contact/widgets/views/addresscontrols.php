<div class="widget-address-controls">
  <div class="controls">
    <?=\CHtml::activeTextField($form, 'CityLabel', array('placeholder' => $form->getAttributeLabel('CityLabel')));?>
  </div>

  <?if ($address):?>
  <div class="controls m-top_5">
    <?=\CHtml::activeTextField($form, 'Street', array('placeholder' => $form->getAttributeLabel('Street')));?>
  </div>
  <div class="controls m-top_5">
    <?=\CHtml::activeTextField($form, 'House', array('placeholder' => $form->getAttributeLabel('House')));?>
  </div>
  <div class="controls m-top_5">
    <?=\CHtml::activeTextField($form, 'Building', array('placeholder' => $form->getAttributeLabel('Building')));?>
  </div>
  <div class="controls m-top_5">
    <?=\CHtml::activeTextField($form, 'Wing', array('placeholder' => $form->getAttributeLabel('Wing')));?>
  </div>
  <?endif;?>
  
  <?if ($place):?>
  <div class="controls m-top_5">
    <?=\CHtml::activeTextField($form, 'Place', array('placeholder' => $form->getAttributeLabel('Place')));?>
  </div>
  <?endif;?>
  
  <?=\CHtml::activeHiddenField($form, 'CityId');?>
  <?=\CHtml::activeHiddenField($form, 'CountryId');?>
  <?=\CHtml::activeHiddenField($form, 'RegionId');?>
</div>
