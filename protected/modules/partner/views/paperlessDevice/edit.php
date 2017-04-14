<?php

use application\helpers\Flash;
use paperless\models\Device;

/**
 * @var \partner\models\forms\paperless\Device $form
 * @var Device $device
 * @var $this \partner\components\Controller
 * @var $activeForm CActiveForm
 */

$this->setPageTitle(\Yii::t('app', 'Добавление устройства'));
?>

<? $activeForm = $this->beginWidget('CActiveForm') ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><span class="fa fa-plus"></span> <?= \Yii::t('app', 'Добавление устройства') ?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
		<?=$activeForm->hiddenField($form, 'Id')?>
        <?= Flash::html() ?>
        <div class="row">
            <div class="col-md-6">
                <?= $activeForm->label($form, 'DeviceId') ?>
                <?= $activeForm->textField($form, 'Id', ['class' => 'form-control']) ?>

                <?= $activeForm->label($form, 'Type') ?>
                <?= $activeForm->dropDownList($form, 'Type', Device::types(), ['prompt' => '', 'class' => 'form-control']) ?>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <?= $activeForm->checkBox($form, 'Active') ?> <?= $form->getAttributeLabel('Active') ?>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <?= $activeForm->label($form, 'Name') ?>
                <?= $activeForm->textField($form, 'Name', ['class' => 'form-control']) ?>

                <?= $activeForm->label($form, 'Comment') ?>
                <?= $activeForm->textArea($form, 'Comment', ['class' => 'form-control', 'rows' => '6']) ?>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <?= \CHtml::submitButton($device->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<? $this->endWidget() ?>
