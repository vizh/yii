<?php
/**
 * @var \partner\models\forms\orderitem\Create $form
 * @var $this \partner\components\Controller
 * @var $activeForm CActiveForm
 */

use application\helpers\Flash;

$this->setPageTitle(\Yii::t('app', 'Добавление заказа'));
?>
<?$activeForm = $this->beginWidget('CActiveForm')?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><span class="fa fa-plus"></span> <?=\Yii::t('app', 'Добавление заказа')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
        <?=Flash::html()?>
        <div class="row">
            <div class="col-md-4">
                <?$this->widget('\partner\widgets\UserAutocompleteInput', [
                    'form' => $form,
                    'attribute' => 'Payer'
                ])?>
            </div>
            <div class="col-md-4">
                <?$this->widget('\partner\widgets\UserAutocompleteInput', [
                    'form' => $form,
                    'attribute' => 'Owner'
                ])?>
            </div>
            <div class="col-md-4">
                <?=$activeForm->label($form, 'ProductId')?>
                <?=$activeForm->dropDownList($form, 'ProductId', $form->getProductData(), ['class' => 'form-control'])?>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <?=\CHtml::submitButton(\Yii::t('app', 'Создать заказ'), ['class' => 'btn btn-primary'])?>
    </div>
</div>
<?$this->endWidget()?>
