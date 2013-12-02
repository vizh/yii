<div class="widget-address-controls">
  <div class="controls">
    <?=\CHtml::activeTextField($form, 'CityLabel', array('placeholder' => $form->getAttributeLabel('CityLabel'), 'class' => $this->inputClass));?>
  </div>

  <?if ($address):?>
  <div class="controls m-top_5">
    <?=\CHtml::activeTextField($form, 'Street', array('placeholder' => $form->getAttributeLabel('Street'), 'class' => $this->inputClass));?>
  </div>
  <div class="controls m-top_5">
    <?=\CHtml::activeTextField($form, 'House', array('placeholder' => $form->getAttributeLabel('House'), 'class' => $this->inputClass));?>
  </div>
  <div class="controls m-top_5">
    <?=\CHtml::activeTextField($form, 'Building', array('placeholder' => $form->getAttributeLabel('Building'), 'class' => $this->inputClass));?>
  </div>
  <div class="controls m-top_5">
    <?=\CHtml::activeTextField($form, 'Wing', array('placeholder' => $form->getAttributeLabel('Wing'), 'class' => $this->inputClass));?>
  </div>
  <?endif;?>
  
  <?if ($place):?>
  <div class="controls m-top_5">
    <?=\CHtml::activeTextField($form, 'Place', array('placeholder' => $form->getAttributeLabel('Place'), 'class' => $this->inputClass));?>
  </div>
  <?endif;?>
  
  <?=\CHtml::activeHiddenField($form, 'CityId');?>
  <?=\CHtml::activeHiddenField($form, 'CountryId');?>
  <?=\CHtml::activeHiddenField($form, 'RegionId');?>
</div>
