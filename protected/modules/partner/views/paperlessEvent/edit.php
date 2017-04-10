<?php

use application\helpers\Flash;
use paperless\models\Event;

/**
 * @var \partner\models\forms\paperless\Event $form
 * @var Event $event
 * @var $this \partner\components\Controller
 * @var $activeForm CActiveForm
 */

$this->setPageTitle(\Yii::t('app', 'Добавление события'));
?>

<? $activeForm = $this->beginWidget('CActiveForm', ['htmlOptions' => ['enctype' => 'multipart/form-data']]) ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><span class="fa fa-plus"></span> <?= \Yii::t('app', 'Добавление события') ?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?= $activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>') ?>
        <?= Flash::html() ?>
        <div class="row">
            <div class="col-md-6">
                <?= $activeForm->label($form, 'Subject') ?>
                <?= $activeForm->textField($form, 'Subject', ['class' => 'form-control']) ?>

                <?= $activeForm->label($form, 'Text') ?>
                <?= $activeForm->textArea($form, 'Text', ['class' => 'form-control', 'rows' => '6']) ?>

                <?= $activeForm->label($form, 'File') ?>
                <?= $activeForm->fileField($form, 'File', ['class' => 'form-control']) ?>
            </div>
            <div class="col-md-6">
                <?= $activeForm->label($form, 'FromName') ?>
                <?= $activeForm->textField($form, 'FromName', ['class' => 'form-control']) ?>

                <?= $activeForm->label($form, 'FromAddress') ?>
                <?= $activeForm->textField($form, 'FromAddress', ['class' => 'form-control']) ?>

                <?= $activeForm->label($form, 'Roles') ?>
                <div class="form-group">
                    <?= $activeForm->checkBoxList($form, 'Roles', CHtml::listData($form->roles(), 'Id', 'Title')) ?>
                </div>

                <?= $activeForm->label($form, 'Devices') ?>
                <div class="form-group">
                    <?= $activeForm->checkBoxList($form, 'Devices', CHtml::listData($form->devices(), 'Id', 'Name')) ?>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <?= $activeForm->checkBox($form, 'SendOnce') ?> <?= $form->getAttributeLabel('SendOnce') ?>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <?= $activeForm->checkBox($form, 'ConditionLike') ?> <?= $form->getAttributeLabel('ConditionLike') ?>
                        </label>
                        <?= $activeForm->textField($form, 'ConditionLikeString') ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <?= $activeForm->checkBox($form, 'ConditionNotLike') ?> <?= $form->getAttributeLabel('ConditionNotLike') ?>
                        </label>
                        <?= $activeForm->textField($form, 'ConditionNotLikeString') ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <?= $activeForm->checkBox($form, 'Active') ?> <?= $form->getAttributeLabel('Active') ?>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <?= \CHtml::submitButton($event->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<? $this->endWidget() ?>
