<?php
/**
 * @var PayersFilter $form
 * @var int[]|null $users
 */
use pay\models\forms\admin\PayersFilter;

?>
<div class="btn-toolbar"></div>
<div class="well">
    <?=\CHtml::beginForm($this->createUrl('/pay/admin/order/payers'),'GET',['class' => 'form-horizontal']);?>
    <?=\CHtml::errorSummary($form,'<div class="alert alert-error">', '</div>');?>
    <div class="row">
        <div class="span5">
            <?=\CHtml::activeLabel($form,'EventLabel');?>
            <?=\CHtml::activeTextField($form, 'EventLabel', ['class' => 'input-block-level', 'placeholder' => $form->getAttributeLabel('EventLabel')]);?>
            <?=\CHtml::activeHiddenField($form, 'EventId');?>
        </div>
        <div class="span3">
            <?=\CHtml::activeLabel($form,'Paid');?>
            <?=CHtml::activeDropDownList($form, 'Paid', $form->getPaidValues());?>
            <button type="submit" class="btn btn-info" name="find"><i class="icon-search icon-white"></i></button>
        </div>
    </div>
    <?=\CHtml::endForm();?>
    <hr/>

    <?php if ($users !== null):?>
        <textarea class="span12" rows="10"><?=implode(',', $users);?></textarea>
    <?php endif;?>
</div>