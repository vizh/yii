<?php
use application\components\controllers\AdminMainController;
use user\models\forms\admin\Merge;
use application\widgets\ActiveForm;
use application\helpers\Flash;

/**
 * @var AdminMainController $this
 * @var Merge $form
 * @var ActiveForm $activeForm
 */

$this->setPageTitle('Объединение пользователей');
?>

<?$activeForm = $this->beginWidget('application\widgets\ActiveForm')?>
<div class="btn-toolbar">
    <?=\CHtml::submitButton('Объединить', ['class' => 'btn btn-success'])?>
</div>
<div class="well">
    <?=$activeForm->errorSummary($form)?>
    <?=Flash::html()?>
    <div class="row">
        <div class="span6">
            <h3>Основной</h3>
            <h5><?=$form->getActiveRecord()->getFullName()?></h5>
            <label class="radio">
                <?=$activeForm->radioButton($form, 'Email', ['uncheckValue' => null, 'value' => $form->getActiveRecord()->Email])?> <?=$form->getActiveRecord()->Email?>
            </label>
            <?if(!empty($form->getActiveRecord()->PrimaryPhone)):?>
                <label class="radio">
                    <?=$activeForm->radioButton($form, 'PrimaryPhone', ['uncheckValue' => null, 'value' => $form->getActiveRecord()->PrimaryPhone])?> <?=$form->getActiveRecord()->getPhone()?>
                </label>
            <?endif?>
            <?php
            $address = $form->getActiveRecord()->getContactAddress();
            if ($address !== null):?>
                <label class="radio">
                    <?=$activeForm->radioButton($form, 'Address', ['uncheckValue' => null, 'value' => $address->Id])?> <?=$address?>
                </label>
            <?endif?>
            <?$this->renderPartial('merge/employments', ['user' => $form->getActiveRecord(), 'activeForm' => $activeForm, 'form' => $form])?>
        </div>
        <div class="span6">
            <h3>Дубль</h3>
            <h5><?=$form->getSecondActiveRecord()->getFullName()?></h5>
            <label class="radio">
                <?=$activeForm->radioButton($form, 'Email', ['value' => $form->getSecondActiveRecord()->Email, 'uncheckValue' => null])?> <?=$form->getSecondActiveRecord()->Email?>
            </label>
            <?if(!empty($form->getSecondActiveRecord()->PrimaryPhone)):?>
                <label class="radio">
                    <?=$activeForm->radioButton($form, 'PrimaryPhone', ['uncheckValue' => null, 'value' => $form->getSecondActiveRecord()->PrimaryPhone])?> <?=$form->getSecondActiveRecord()->getPhone()?>
                </label>
            <?endif?>
            <?php
            $address = $form->getSecondActiveRecord()->getContactAddress();
            if ($address !== null):?>
                <label class="radio">
                    <?=$activeForm->radioButton($form, 'Address', ['uncheckValue' => null, 'value' => $address->Id])?> <?=$address?>
                </label>
            <?endif?>
            <?$this->renderPartial('merge/employments', ['user' => $form->getSecondActiveRecord(), 'activeForm' => $activeForm, 'form' => $form])?>
        </div>
    </div>
</div>
<?$this->endWidget()?>

