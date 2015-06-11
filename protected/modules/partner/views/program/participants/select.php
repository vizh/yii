<?php
/**
 * @var \partner\models\forms\program\Participant $form
 */
?>

<?$this->widget('\partner\widgets\UserAutocompleteInput', [
    'form' =>  $form,
    'attribute' => 'RunetId'
]);?>
<div class="text-center text-light-gray">или</div>

<div class="form-group">
    <?=\CHtml::activeLabel($form, 'CompanyId');?>
    <?$this->widget('\application\widgets\AutocompleteInput', [
        'form' =>  $form,
        'field' => 'CompanyId',
        'source' => '/company/ajax/search/',
        'addOn' => 'ID компании',
        'class' => '\company\models\Company',
        'htmlOptions' => ['class' => 'form-control']
    ]);?>
</div>

<div class="text-center text-light-gray">или</div>

<div class="form-group">
    <?=\CHtml::activeLabel($form, 'CustomText');?>
    <?=CHtml::activeTextArea($form, 'CustomText', ['rows' => '1', 'class' => 'form-control']);?>
</div>