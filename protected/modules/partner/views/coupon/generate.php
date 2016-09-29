<?php
/**
 * @var $form \partner\models\forms\coupon\Generate
 * @var $this \pay\components\Controller
 * @var CActiveForm $activeForm
 */

use application\helpers\Flash;

$this->setPageTitle(\Yii::t('app', 'Генерация промо-кодов'));
?>
<?$activeForm = $this->beginWidget('CActiveForm')?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <span class="panel-title"><i class="fa fa-plus-circle"></i> <?=\Yii::t('app', 'Генерация промо-кодов')?></span>
        </div> <!-- / .panel-heading -->
        <div class="panel-body">
            <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
            <?=Flash::html()?>

            <div class="form-group">
                <?=CHtml::activeCheckBox($form, 'IsMultiple')?>
                <p class="help-block">Для индивидуальной активаци / Для множественной активаци</p>
            </div>
            <hr/>
            <div class="form-group" data-for-multiple="true">
                <?=$activeForm->label($form, 'Code')?>
                <?=$activeForm->textField($form, 'Code', ['class' => 'form-control'])?>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <?=$activeForm->label($form, 'CountActivations', ['data-for-multiple' => 'true'])?>
                        <?=$activeForm->label($form, 'CountCoupons', ['data-for-multiple' => 'false'])?>
                        <?=$activeForm->textField($form, 'Count', ['class' => 'form-control'])?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <?=$activeForm->label($form, 'Discount')?>
                        <?=$activeForm->textField($form, 'Discount', ['class' => 'form-control'])?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <?=$activeForm->label($form, 'EndTime')?>
                        <?=$activeForm->textField($form, 'EndTime', ['class' => 'form-control'])?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <?=$activeForm->label($form, 'Products')?>
                <div class="checkbox">
                    <label>
                        <?=$activeForm->checkBox($form, 'ProductsAll')?> <strong><?=\Yii::t('app', 'Все типы продуктов')?></strong>
                    </label>
                    <?foreach($form->getProductData() as $id => $label):?>
                        <label>
                            <?=$activeForm->checkBox($form, 'Products[' . $id . ']', ['uncheckValue' => null])?> <?=$label?>
                        </label>
                    <?endforeach?>
                </div>
                <span class="help-block">
                    <?=\Yii::t('app', 'Для промо-кодов со скидкой 100% рекомендуется выбирать ровно один тип продукта.')?>
                </span>
            </div>
        </div>
        <div class="panel-footer">
            <?=\CHtml::submitButton(\Yii::t('app', 'Сгенерировать'), ['class' => 'btn btn-primary'])?>
        </div>
    </div>
<?$this->endWidget()?>
