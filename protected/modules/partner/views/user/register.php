<?php
/**
 * @var \partner\models\forms\user\Register $form
 * @var \user\models\User $user
 * @var \partner\components\Controller $this
 * @var CActiveForm $activeForm
 */
$this->setPageTitle(\Yii::t('app', 'Регистрация нового пользователя'));
\Yii::app()->getClientScript()->registerPackage('runetid.jquery.inputmask-multi');
use application\helpers\Flash;
?>

<?$activeForm = $this->beginWidget('CActiveForm')?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-plus-circle"></i> <?=\Yii::t('app', 'Новый пользователь')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?=Flash::html()?>
        <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
        <div class="form-group">
            <?=$activeForm->label($form, 'LastName')?>
            <?=$activeForm->textField($form, 'LastName', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?=$activeForm->label($form, 'FirstName')?>
            <?=$activeForm->textField($form, 'FirstName', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?=$activeForm->label($form, 'FatherName')?>
            <?=$activeForm->textField($form, 'FatherName', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?=$activeForm->label($form, 'Email')?>
            <?=$activeForm->textField($form, 'Email', ['class' => 'form-control'])?>
            <p class="help-block"><?=\Yii::t('app', 'Оставьте поле пустым для генерации случайного e-mail')?></p>
        </div>
        <div class="form-group">
            <?=$activeForm->label($form, 'Role')?>
            <?=$activeForm->dropDownList($form, 'Role', $form->getRoleData(), ['class' => 'form-control'])?>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?=$activeForm->label($form, 'Company')?>
                    <?=$activeForm->textField($form, 'Company', ['class' => 'form-control'])?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?=$activeForm->label($form, 'Position')?>
                    <?=$activeForm->textField($form, 'Position', ['class' => 'form-control'])?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?=$activeForm->label($form, 'Phone')?>
            <?=$activeForm->textField($form, 'Phone', ['class' => 'form-control'])?>
        </div>
        <div class="checkbox">
            <label>
                <?=$activeForm->checkBox($form, 'Hidden', ['uncheckValue' => null])?> <?=$form->getAttributeLabel('Hidden')?>
            </label>
        </div>
    </div>
    <div class="panel-footer">
        <?=\CHtml::submitButton(\Yii::t('app', 'Зарегистрировать'), ['class' => 'btn btn-primary'])?>
    </div>
</div>
<?$this->endWidget()?>

