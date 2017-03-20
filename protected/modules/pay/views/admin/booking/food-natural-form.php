<?php

use application\components\controllers\AdminMainController;
use pay\models\forms\admin\FoodNaturalForm;
use pay\models\search\admin\booking\FoodNaturalSearch;
use application\helpers\Flash;

/** @var AdminMainController $this */
/** @var FoodNaturalForm $model */
?>


<div class="row-fluid">
    <div class="btn-toolbar clearfix">
        <?= \CHtml::link('← Назад', ['foodNatural'], ['class' => 'btn btn-default']) ?>
    </div>

    <div class="well">
        <?= Flash::html() ?>
        <?= \CHtml::errorSummary($model, '<div class="alert alert-error">', '</div>') ?>
        <?= \CHtml::form('', 'POST') ?>

        <div class="control-group">
            <div class="controls">
                <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', [
                    'id' => 'User',
                    'name' => CHtml::activeName($model, 'User'),
                    'source' => '/user/ajax/search?eventId=3016',
                    'htmlOptions' => [
                        'class' => 'span4'
                    ],
                    'scriptFile' => false,
                    'cssFile' => false
                ]); ?>
            </div>
        </div>

        <?php foreach (FoodNaturalSearch::$productIds as $date => $meals): ?>
            <?php foreach ($meals as $meal => $id): ?>
                <div class="control-group">
                    <?= \CHtml::label($model->products[$date][$meal]->Title .
                        CHtml::activeCheckBox($model, 'ProductIds[' . $id . ']', [
                            'value' => $id,
                            'uncheckValue' => null,
                        ])
                        , null, ['class' => 'checkbox']
                    ) ?>
                </div>
            <?php endforeach; ?>
            <hr>
        <?php endforeach; ?>

        <div class="control-group">
            <div class="controls">
                <?= \CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?= \CHtml::endForm() ?>
    </div>
</div>
