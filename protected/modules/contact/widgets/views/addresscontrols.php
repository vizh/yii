<div class="controls m-top_5">
  <?=\CHtml::activeDropDownList($form, 'CountryId', array(), array('data-value' => $form->CountryId));?>
</div>
<div class="controls m-top_5">
  <?=\CHtml::activeDropDownList($form, 'RegionId', array(), array('data-value' => $form->RegionId));?>
</div>
<div class="controls m-top_5">
  <?=\CHtml::activeDropDownList($form, 'CityId', array(), array('data-value' => $form->CityId));?>
</div>
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
<div class="controls m-top_5">
  <?=\CHtml::activeTextField($form, 'Place', array('placeholder' => $form->getAttributeLabel('Place')));?>
</div>
