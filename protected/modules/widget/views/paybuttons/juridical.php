<?php
/**
 * @var \widget\components\Controller $this
 * @var \pay\models\forms\Juridical $form
 * @var \application\widgets\ActiveForm $activeForm
 */

use application\helpers\Flash;
?>

<?php
/**
 * @var CActiveForm $activeForm
 */
?>

<?$activeForm = $this->beginWidget('\application\widgets\ActiveForm')?>
    <?=Flash::html()?>
    <?=$activeForm->errorSummary($form)?>
    <div class="form-group">
        <?=$activeForm->label($form, 'Name')?>
        <?=$activeForm->textField($form, 'Name', ['class' => 'form-control'])?>
        <?=$activeForm->help($form, 'Name')?>
    </div>
    <div class="form-group">
        <?=$activeForm->label($form, 'Address')?>
        <?=$activeForm->textField($form, 'Address', ['class' => 'form-control'])?>
        <?=$activeForm->help($form, 'Address')?>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?=$activeForm->label($form, 'INN')?>
                <?=$activeForm->textField($form, 'INN', ['class' => 'form-control'])?>
                <?=$activeForm->help($form, 'INN')?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?=$activeForm->label($form, 'KPP')?>
                <?=$activeForm->textField($form, 'KPP', ['class' => 'form-control'])?>
                <?=$activeForm->help($form, 'KPP')?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?=$activeForm->label($form, 'Phone')?>
        <?=$activeForm->textField($form, 'Phone', ['class' => 'form-control'])?>
        <?=$activeForm->help($form, 'Phone')?>
    </div>
    <div class="form-group">
        <?=$activeForm->label($form, 'PostAddress')?>
        <?=$activeForm->textField($form, 'PostAddress', ['class' => 'form-control'])?>
        <?=$activeForm->help($form, 'PostAddress')?>
    </div>
    <div class="form-group">
        <?=CHtml::submitButton(\Yii::t('app', 'Выставить счет'), ['class' => 'btn btn-primary'])?>
    </div>
<?$this->endWidget()?>
