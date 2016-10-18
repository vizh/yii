<?php
/**
 * @var \user\models\User $user
 * @var \partner\components\Controller $this
 * @var \partner\models\forms\user\Translate[] $forms
 * @var \CActiveForm $activeForm
 */

use application\helpers\Flash;

$this->setPageTitle(\Yii::t('app', 'Редактирование персональных данных'));
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-user"></i> <?=\Yii::t('app', 'Персональные данные')?></span>
        <div class="panel-heading-controls">
            <?=\CHtml::link('<span class="fa fa-arrow-left"></span>&nbsp;&nbsp;' . \Yii::t('app', 'Назад'), ['edit', 'id' => $user->RunetId], ['class' => 'btn btn-xs btn-info'])?>
        </div>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?$activeForm = $this->beginWidget('CActiveForm')?>
            <?=Flash::html()?>
            <?foreach($forms as $form):?>
                <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
                <?foreach($form->getSafeAttributeNames() as $attr):?>
                    <div class="form-group">
                        <?=$activeForm->label($form, $attr)?>
                        <div class="input-group">
                            <div class="input-group-addon"><?=$form->getLocale()?></div>
                            <?=$activeForm->textField($form, $attr. '[' . $form->getLocale() . ']', ['class' => 'form-control', 'value' => $form->$attr])?>
                        </div>
                    </div>
                <?endforeach?>
                <hr/>
            <?endforeach?>
            <div class="form-group">
                <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-info'])?>
            </div>
        <?$this->endWidget()?>
    </div>
</div>