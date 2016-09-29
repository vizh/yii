<?php
/**
 * @var $this \partner\components\Controller
 * @var $form \partner\models\forms\orderitem\Refund
 * @var $activeForm CActiveForm
 */

use pay\models\OrderItem;
use application\helpers\Flash;

$this->setPageTitle(\Yii::t('app', 'Возврат заказа'));

/** @var OrderItem $orderItem */
$orderItem = $form->getActiveRecord();
?>
<?$activeForm = $this->beginWidget('CActiveForm')?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><span class="fa fa-undo"></span> <?=\Yii::t('app', 'Возврат заказа')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
        <?=Flash::html()?>
        <div class="note">
            <h4 class="note-title"><?=$orderItem->Product->Title?></h4>
            <p>
            <?if($orderItem->Refund):?>
                <span class="label label-danger"><?=\Yii::t('app', 'Отменен')?></span>
            <?php else:?>
                <span class="label label-success"><?=$orderItem->getPriceDiscount()?> <?=\Yii::t('app', 'руб.')?></span>
            <?endif?>
            </p>
            <p class="clear-indents">
               <?=$this->renderPartial('../partial/grid/user', ['user' => $orderItem->getCurrentOwner()], true)?>
            </p>
        </div>
        <?if(!$orderItem->Refund):?>
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <?=$activeForm->checkBox($form, 'Agree')?> <?=$form->getAttributeLabel('Agree')?>
                    </label>
                </div>
            </div>
        <?endif?>
    </div>
    <div class="panel-footer">
        <?=\CHtml::submitButton(\Yii::t('app', 'Отменить заказ'), ['class' => 'btn btn-primary', 'disabled' => $orderItem->Refund])?>
    </div>
</div>
<?$this->endWidget()?>
