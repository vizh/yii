<?php

use partner\components\Controller;

/**
 * @var partner\components\Controller $this
 * @var \partner\models\search\PaperlessEvent $search
 */

$this->setPageTitle(Yii::t('app', 'Paperless - События'));
?>

<? $this->beginClip(Controller::PAGE_HEADER_CLIP_ID) ?>
<?= \CHtml::link('<span class="btn-label fa fa-plus"></span> ' . \Yii::t('app', 'Добавить'), ['eventEdit'], ['class' => 'btn btn-primary btn-labeled']) ?>
<? $this->endClip() ?>

<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title">
            <i class="fa fa-list-alt"></i> <?= Yii::t('app', 'Paperless - События') ?>
        </span>
    </div>

    <div class="panel-body">
        <div class="table-info">
            <? $this->widget('application\widgets\grid\GridView', [
                'dataProvider' => $search->getDataProvider(),
                'filter' => $search,
                'summaryText' => 'События {start}-{end} из {count}.',
                'columns' => [
                    ['name' => 'Subject'],
                    ['name' => 'activeLabel', 'filter' => ['1' => 'Активен', '0' => 'Неактивен']],
                    [
                        'class' => '\application\widgets\grid\ButtonColumn',
                        'template' => '{update}{delete}',
                        'updateButtonUrl' => 'Yii::app()->getController()->createUrl("eventEdit",["id"=>$data->primaryKey])',
                        'deleteButtonUrl' => 'Yii::app()->getController()->createUrl("eventDelete",["id"=>$data->primaryKey])'
                    ]
                ]
            ]) ?>
        </div>
    </div>
</div>

