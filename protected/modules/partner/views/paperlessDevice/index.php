<?php

use partner\components\Controller;

/**
 * @var partner\components\Controller $this
 * @var \partner\models\search\PaperlessDevice $search
 */

$this->setPageTitle(Yii::t('app', 'Paperless - Настройки'));
?>

<? $this->beginClip(Controller::PAGE_HEADER_CLIP_ID) ?>
<?= \CHtml::link('<span class="btn-label fa fa-plus"></span> ' . \Yii::t('app', 'Добавить'), ['edit'], ['class' => 'btn btn-primary btn-labeled']) ?>
<? $this->endClip() ?>

<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title">
            <i class="fa fa-list-alt"></i> <?= Yii::t('app', 'Paperless - Настройки') ?>
        </span>
    </div>

    <div class="panel-body">
        <div class="table-info">
            <? $this->widget('application\widgets\grid\GridView', [
                'dataProvider' => $search->getDataProvider(),
                'filter' => $search,
                'summaryText' => 'Устройства {start}-{end} из {count}.',
                'columns' => [
                    ['name' => 'Id'],
                    ['name' => 'Name'],
                    ['name' => 'Type', 'value' => function($data){ return $data->typeLabel; }],
                    [
                        'name' => 'activeLabel',
                        'filter' => ['1' => 'Активна', '0' => 'Неактивна']
                    ],
                    [
                        'class' => '\application\widgets\grid\ButtonColumn',
                        'template' => '{update}{delete}',
                    ]
                ]
            ]) ?>
        </div>
    </div>
</div>

