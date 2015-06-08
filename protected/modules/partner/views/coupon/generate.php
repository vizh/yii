<?php
/**
 * @var $form \partner\models\forms\coupon\Generate
 * @var $this \pay\components\Controller
 * @var CActiveForm $activeForm
 */

use application\helpers\Flash;

$this->setPageTitle(\Yii::t('app', 'Генерация промо-кодов'));
?>
<?php $activeForm = $this->beginWidget('CActiveForm');?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <span class="panel-title"><i class="fa fa-plus-circle"></i> <?=\Yii::t('app', 'Генерация промо-кодов');?></span>
        </div> <!-- / .panel-heading -->
        <div class="panel-body">
            <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>');?>
            <?=Flash::html();?>

            <div class="form-group">
                <?=CHtml::activeCheckBox($form, 'IsMultiple');?>
            </div>
            <div class="form-group" data-for-multiple="true">
                <?=$activeForm->label($form, 'Code');?>
                <?=$activeForm->textField($form, 'Code', ['class' => 'form-control']);?>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <?=$activeForm->label($form, 'CountActivations', ['data-for-multiple' => 'true']);?>
                        <?=$activeForm->label($form, 'CountCoupons', ['data-for-multiple' => 'false']);?>
                        <?=$activeForm->textField($form, 'Count', ['class' => 'form-control']);?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <?=$activeForm->label($form, 'Discount');?>
                        <?=$activeForm->textField($form, 'Discount', ['class' => 'form-control']);?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <?=$activeForm->label($form, 'EndTime');?>
                        <?=$activeForm->textField($form, 'EndTime', ['class' => 'form-control']);?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <?=$activeForm->label($form, 'Products');?>
                <?=$activeForm->dropDownList($form, 'Products', $form->getProductData(), ['class' => 'form-control', 'multiple' => true]);?>
                <span class="help-block">
                    <?=\Yii::t('app', 'Для промо-кодов со скидкой 100% рекомендуется выбирать ровно один тип продукта.');?>
                </span>
            </div>
        </div>
        <div class="panel-footer">
            <?=\CHtml::submitButton(\Yii::t('app', 'Сгенерировать'), ['class' => 'btn btn-primary']);?>
        </div>
    </div>
<?$this->endWidget();?>





<?/*
$productDropDown = array();
$productDropDown[0] = 'На все типы продуктов';
foreach ($products as $product) {
    $productDropDown[$product->Id] = $product->Title;
}
?>

    <div class="row">
        <div class="span12 indent-bottom3">
            <h2>Генерация промо-кодов</h2>
        </div>
    </div>

<?if ($form->hasErrors()):?>
    <div class="row">
        <div class="span8 offset1">
            <?=CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>', []);?>
        </div>
    </div>
<?endif;?>

<?if (count($result) > 0):?>
    <div class="row">
        <div class="span8 offset1">
            <div class="alert alert-success">
                <p>
                    <?=count($result) > 1 ? 'Сгенерированы промо-коды:' : 'Сгенерирован промо-код';?>
                </p>
                <p>
                    <?foreach ($result as $coupon):?>
                        <code><?=$coupon->Code;?></code><br>
                    <?endforeach;?>
                </p>
            </div>
        </div>
    </div>
<?endif;?>

<?=CHtml::beginForm();?>


    <div class="row">
        <div class="span10 offset1">
            <div data-coupon-type="many" class="control-group <?=$form->hasErrors('suffix') ? 'error' : '';?>">
                <?=CHtml::activeLabel($form, 'code');?>
                <?=CHtml::activeTextField($form, 'code');?>
            </div>

            <div class="control-group <?=$form->hasErrors('count') ? 'error' : '';?>">
                <?=CHtml::activeLabel($form, 'count', ['data-coupon-type' => 'solo']);?>
                <?$form->setScenario('many');?>
                <?=CHtml::activeLabel($form, 'count', ['data-coupon-type' => 'many']);?>
                <?=CHtml::activeTextField($form, 'count');?>
            </div>

            <div class="control-group <?=$form->hasErrors('discount') ? 'error' : '';?>">
                <?=CHtml::activeLabel($form, 'discount');?>
                <?=CHtml::activeTextField($form, 'discount');?>
            </div>

            <div class="control-group <?=$form->hasErrors('productIdList') ? 'error' : '';?>">
                <?=CHtml::activeLabel($form, 'productIdList');?>
                <?=CHtml::activeDropDownList($form, 'productIdList', $productDropDown, ['multiple' => true, 'size' => count($products)+1, 'class' => 'span8 m-bottom_0']);?>
                <span class="help-block">Для промо-кодов со скидкой 100% рекомендуется выбирать ровно один тип продукта.</span>
            </div>

            <div class="control-group <?=$form->hasErrors('endTime') ? 'error' : '';?>">
                <?=CHtml::activeLabel($form, 'endTime');?>
                <?=CHtml::activeTextField($form, 'endTime', ['id' => 'endTime']);?>
            </div>

            <div class="control-group">
                <button class="btn btn-success btn-large" type="submit"><i class="icon-ok icon-white"></i> Генерировать</button>
            </div>
        </div>
    </div>


<?=CHtml::endForm();?>
*/?>