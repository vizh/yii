<?php
/**
 * @var $this \partner\components\Controller
 * @var $form \partner\models\forms\orderitem\Redirect
 * @var $activeForm CActiveForm
 */

use pay\models\OrderItem;
use application\helpers\Flash;

$this->setPageTitle(\Yii::t('app', 'Перенос заказа'));

/** @var OrderItem $orderItem */
$orderItem = $form->getActiveRecord();
?>
<?php $activeForm = $this->beginWidget('CActiveForm');?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <span class="panel-title"><span class="fa fa-exchange"></span> <?=\Yii::t('app', 'Перенос заказа');?></span>
        </div> <!-- / .panel-heading -->
        <div class="panel-body">
            <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>');?>
            <?=Flash::html();?>
            <div class="note">
                <h4 class="note-title"><?=$orderItem->Product->Title?></h4>
                <?$owner = $orderItem->getCurrentOwner();?>
                <p class="clear-indents">
                    <?=\CHtml::link($owner->getFullName(), ['user/edit', 'id' => $owner->RunetId]);?>&nbsp;<sup><?=$owner->RunetId;?></sup>
                    <?php if (($employment = $owner->getEmploymentPrimary()) !== null):?>
                        <br/><?=$employment;?>
                    <?php endif;?>
                </p>
            </div>
            <?$this->widget('\partner\widgets\UserAutocompleteInput', [
                'form' => $form,
                'attribute' => 'Owner'
            ]);?>
        </div>
        <div class="panel-footer">
            <?=\CHtml::submitButton(\Yii::t('app', 'Перенести'), ['class' => 'btn btn-primary']);?>
        </div>
    </div>
<?php $this->endWidget();?>
