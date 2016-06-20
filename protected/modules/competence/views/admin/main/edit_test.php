<?php

/**
 * @var MainController         $this
 * @var competence\models\Test $test
 */

$this->pageTitle = ($test->isNewRecord ? 'Создание' : 'Редактирование').' теста';
\Yii::app()->getClientScript()->registerPackage('runetid.ckeditor');
?>

<div class="btn-toolbar clearfix">
    <a class="btn" href="<?= Yii::app()->createUrl('/competence/admin/main/index'); ?>"><i class="icon-arrow-left"></i>
        Список тестов</a>
</div>

<div class="well">
    <?= CHtml::form('', 'POST', ['class' => 'form-horizontal']) ?>

    <?= CHtml::errorSummary($test, '<div class="alert alert-error">', '</div>') ?>

    <div class="row-fluid">
        <div class="span6">
            <h3>Основные параметры</h3>

            <div class="control-group">
                <div class="controls">
                    <?= CHtml::label(
                        $test->getAttributeLabel('Enable').
                        CHtml::activeCheckBox($test, 'Enable'),
                        null,
                        ['class' => 'checkbox']
                    ) ?>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <?= CHtml::label(
                        $test->getAttributeLabel('Test').
                        CHtml::activeCheckBox($test, 'Test'),
                        null,
                        ['class' => 'checkbox']
                    ) ?>
                </div>
            </div>

            <div class="control-group">
                <?= CHtml::activeLabel($test, 'EventId', ['class' => 'control-label']) ?>
                <div class="controls">
                    <?= CHtml::textField('event-id-input') ?>
                    <?= CHtml::activeHiddenField($test, 'EventId') ?>
                </div>
            </div>

            <div class="control-group">
                <?= CHtml::activeLabel($test, 'Code', ['class' => 'control-label']) ?>
                <div class="controls">
                    <?= CHtml::activeTextField($test, 'Code') ?>
                </div>
            </div>

            <div class="control-group">
                <?= CHtml::activeLabel($test, 'Title', ['class' => 'control-label']) ?>
                <div class="controls">
                    <?= CHtml::activeTextField($test, 'Title') ?>
                </div>
            </div>

            <div class="control-group">
                <?= CHtml::activeLabel($test, 'Info', ['class' => 'control-label']) ?>
                <div class="controls">
                    <?= CHtml::activeTextArea($test, 'Info') ?>
                </div>
            </div>

            <div class="control-group">
                <?= CHtml::activeLabel($test, 'StartTime', ['class' => 'control-label']) ?>
                <div class="controls">
                    <?= CHtml::activeTextField($test, 'StartTime') ?>
                </div>
            </div>

            <div class="control-group">
                <?= CHtml::activeLabel($test, 'EndTime', ['class' => 'control-label']) ?>
                <div class="controls">
                    <?= CHtml::activeTextField($test, 'EndTime') ?>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <?= CHtml::label(
                        $test->getAttributeLabel('ParticipantsOnly').
                        CHtml::activeCheckBox($test, 'ParticipantsOnly'),
                        null,
                        ['class' => 'checkbox']
                    ) ?>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <?= CHtml::label(
                        $test->getAttributeLabel('Multiple').
                        CHtml::activeCheckBox($test, 'Multiple'),
                        null,
                        ['class' => 'checkbox']
                    ) ?>
                </div>
            </div>

            <div class="control-group">
                <?= CHtml::activeLabel($test, 'RoleIdAfterPass', ['class' => 'control-label']) ?>
                <div class="controls">
                    <?= CHtml::activeTextField($test, 'RoleIdAfterPass') ?>
                </div>
            </div>
        </div>

        <div class="span6">
            <h3>Отображение</h3>

            <div class="control-group">
                <div class="controls">
                    <?= CHtml::label(
                        $test->getAttributeLabel('UseClearLayout').
                        CHtml::activeCheckBox($test, 'UseClearLayout'),
                        null,
                        ['class' => 'checkbox']
                    ) ?>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <?= CHtml::label(
                        $test->getAttributeLabel('RenderEventHeader').
                        CHtml::activeCheckBox($test, 'RenderEventHeader'),
                        null,
                        ['class' => 'checkbox']
                    ) ?>
                </div>
            </div>

            <div class="control-group">
                <?= CHtml::activeLabel($test, 'StartButtonText', ['class' => 'control-label']) ?>
                <div class="controls">
                    <?= CHtml::activeTextField($test, 'StartButtonText') ?>
                </div>
            </div>

            <div class="control-group">
                <?= CHtml::activeLabel($test, 'BeforeText', ['class' => 'control-label']) ?>
                <div class="controls">
                    <?= CHtml::activeTextField($test, 'BeforeText') ?>
                </div>
            </div>

            <div class="control-group">
                <?= CHtml::activeLabel($test, 'AfterText', ['class' => 'control-label']) ?>
                <div class="controls">
                    <?= CHtml::activeTextField($test, 'AfterText') ?>
                </div>
            </div>

            <div class="control-group">
                <?= CHtml::activeLabel($test, 'AfterEndText', ['class' => 'control-label']) ?>
                <div class="controls">
                    <?= CHtml::activeTextArea($test, 'AfterEndText') ?>
                </div>
            </div>

            <h3>Быстрая авторизация</h3>

            <div class="control-group">
                <div class="controls">
                    <?= CHtml::label(
                        $test->getAttributeLabel('FastAuth').
                        CHtml::activeCheckBox($test, 'FastAuth'),
                        null,
                        ['class' => 'checkbox']
                    ) ?>
                </div>
            </div>

            <div class="control-group">
                <?= CHtml::activeLabel($test, 'FastAuthSecret', ['class' => 'control-label']) ?>
                <div class="controls">
                    <?= CHtml::activeTextField($test, 'FastAuthSecret') ?>
                </div>
            </div>
        </div>
    </div>

    <?= CHtml::submitButton($test->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']) ?>

    <?= CHtml::endForm() ?>
</div>
