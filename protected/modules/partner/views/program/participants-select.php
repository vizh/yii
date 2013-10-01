<?php
/**
 * @var \partner\models\forms\program\Participant $form
 */
?>
<div class="row">
  <div class="span6">
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'RunetId', ['class' => 'control-label']);?>
      <div class="controls">
        <?$this->widget('\application\widgets\AutocompleteInput', [
          'form' =>  $form,
          'field' => 'RunetId',
          'source' => '/user/ajax/search/',
          'addOn' => 'RUNET-ID',
          'class' => '\user\models\User'
        ]);?>
      </div>
    </div>
  </div>
  <div class="span6">
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'CompanyId', ['class' => 'control-label']);?>
      <div class="controls">
        <?$this->widget('\application\widgets\AutocompleteInput', [
          'form' =>  $form,
          'field' => 'CompanyId',
          'source' => '/company/ajax/search/',
          'addOn' => 'ID компании',
          'class' => '\company\models\Company'
        ]);?>
      </div>
    </div>
  </div>
</div>

<div class="control-group">
  <div class="controls">
    <strong>или</strong>
  </div>
</div>

<div class="control-group">
  <?=\CHtml::activeLabel($form, 'CustomText', ['class' => 'control-label']);?>
  <div class="controls">
    <?=CHtml::activeTextArea($form, 'CustomText', ['rows' => '1', 'class' => 'span9']);?>
  </div>
</div>