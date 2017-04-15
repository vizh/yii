<?php

use partner\components\Controller;

/**
 * @var partner\components\Controller $this
 * @var \partner\models\search\PaperlessMaterial $search
 */

$this->setPageTitle(Yii::t('app', 'Paperless - Правила обработки'));
?>

<? $this->beginClip(Controller::PAGE_HEADER_CLIP_ID) ?>
<?= \CHtml::link('<span class="btn-label fa fa-plus"></span> ' . \Yii::t('app', 'Добавить'), ['materialEdit'], ['class' => 'btn btn-primary btn-labeled']) ?>
<? $this->endClip() ?>

<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title">
            <i class="fa fa-list-alt"></i> <?= Yii::t('app', 'Paperless - Материалы') ?>
        </span>
    </div>

    <div class="panel-body">
        <div class="table-info">
            <? $this->widget('application\widgets\grid\GridView', [
                'dataProvider' => $search->getDataProvider(),
                'filter' => $search,
                'summaryText' => 'Материалы {start}-{end} из {count}.',
                'columns' => [
                    ['name' => 'Name'],
                    ['name' => 'activeLabel', 'filter' => ['1' => 'Активен', '0' => 'Неактивен']],
                    [
                        'class' => '\application\widgets\grid\ButtonColumn',
                        'template' => '{update}{delete}',
                        'updateButtonUrl' => 'Yii::app()->getController()->createUrl("materialEdit",["id"=>$data->primaryKey])',
                        'deleteButtonUrl' => 'Yii::app()->getController()->createUrl("materialDelete",["id"=>$data->primaryKey])'
                    ]
                ]
            ]) ?>
        </div>
    </div>
</div>

