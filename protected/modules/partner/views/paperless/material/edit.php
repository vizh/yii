<?php

use application\helpers\Flash;
use application\models\paperless\Material;

/**
 * @var \partner\models\forms\paperless\Material $form
 * @var Material $material
 * @var $this \partner\components\Controller
 * @var $activeForm CActiveForm
 */

$this->setPageTitle(\Yii::t('app', 'Добавление материала'));
?>

<? $activeForm = $this->beginWidget('CActiveForm', ['htmlOptions' => ['enctype' => 'multipart/form-data']]) ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><span class="fa fa-plus"></span> <?= \Yii::t('app', 'Добавление материала') ?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?= $activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>') ?>
        <?= Flash::html() ?>
        <div class="row">
            <div class="col-md-6">
                <?= $activeForm->label($form, 'Name') ?>
                <?= $activeForm->textField($form, 'Name', ['class' => 'form-control']) ?>

                <?= $activeForm->label($form, 'Comment') ?>
                <?= $activeForm->textArea($form, 'Comment', ['class' => 'form-control', 'rows' => '6']) ?>

                <?= $activeForm->label($form, 'File') ?>
                <?= $activeForm->fileField($form, 'File', ['class' => 'form-control']) ?>

                <div class="form-group">
                    <div class="checkbox">
                        <label><?=$activeForm->checkBox($form, 'Active')?> <?=$form->getAttributeLabel('Active')?></label>
                        <label><?=$activeForm->checkBox($form, 'Visible')?> <?=$form->getAttributeLabel('Visible')?></label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <?= $activeForm->label($form, 'PartnerName') ?>
                <?= $activeForm->textField($form, 'PartnerName', ['class' => 'form-control']) ?>

                <?= $activeForm->label($form, 'PartnerSite') ?>
                <?= $activeForm->textField($form, 'PartnerSite', ['class' => 'form-control']) ?>

                <?= $activeForm->label($form, 'PartnerLogo') ?>
                <?= $activeForm->fileField($form, 'PartnerLogo', ['class' => 'form-control']) ?>

                <?= $activeForm->label($form, 'Roles') ?>
                <div class="form-group">
                    <?= $activeForm->checkBoxList($form, 'Roles', CHtml::listData($form->roles(), 'Id', 'Title')) ?>
                </div>

            </div>
        </div>
    </div>
    <div class="panel-footer">
        <?= \CHtml::submitButton($material->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<? $this->endWidget() ?>
