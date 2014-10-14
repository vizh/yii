<div class="widget-address-controls">
  <div class="controls">
    <?=\CHtml::activeTextField($form, 'CityLabel', ['placeholder' => $form->getAttributeLabel('CityLabel'), 'class' => $this->inputClass, 'disabled' => $this->disabled]);?>
  </div>

  <?if ($address):?>
  <div class="controls m-top_5">
    <?=\CHtml::activeTextField($form, 'Street', ['placeholder' => $form->getAttributeLabel('Street'), 'class' => $this->inputClass, 'disabled' => $this->disabled]);?>
  </div>
  <div class="controls m-top_5">
    <?=\CHtml::activeTextField($form, 'House', ['placeholder' => $form->getAttributeLabel('House'), 'class' => $this->inputClass, 'disabled' => $this->disabled]);?>
  </div>
  <div class="controls m-top_5">
    <?=\CHtml::activeTextField($form, 'Building', ['placeholder' => $form->getAttributeLabel('Building'), 'class' => $this->inputClass, 'disabled' => $this->disabled]);?>
  </div>
  <div class="controls m-top_5">
    <?=\CHtml::activeTextField($form, 'Wing', ['placeholder' => $form->getAttributeLabel('Wing'), 'class' => $this->inputClass, 'disabled' => $this->disabled]);?>
  </div>
  <?endif;?>
  
  <?if ($place):?>
  <div class="controls m-top_5">
    <?=\CHtml::activeTextField($form, 'Place', ['placeholder' => $form->getAttributeLabel('Place'), 'class' => $this->inputClass]);?>
  </div>
  <?endif;?>
  
  <?=\CHtml::activeHiddenField($form, 'CityId');?>
  <?=\CHtml::activeHiddenField($form, 'CountryId');?>
  <?=\CHtml::activeHiddenField($form, 'RegionId');?>
</div>
