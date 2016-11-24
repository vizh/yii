<?php
/**
 * @var \pay\components\Controller $this
 * @var array $active_data
 * @var \application\components\utility\Paginator $active_pager
 * @var array $past_data
 * @var \application\components\utility\Paginator $past_pager
 */

use application\components\utility\Texts;
use pay\models\OrderType;

$this->setPageTitle(\Yii::t('app', 'Сборы по мероприятиям'));

$columns = [
    [
        'header' => 'Название<br/><small>&nbsp;</small>',
        'value' => function ($data) {
            $event = $data['event'];
            return CHtml::link($event->Title, ['/event/admin/edit/index', 'eventId' => $event->Id])
            . CHtml::tag('br')
            . CHtml::tag('small', [], Texts::cropText($event->IdName, 50));
        },
        'htmlOptions' => ['width' => '50%'],
        'type' => 'raw'
    ],
    [
        'header' => 'Даты проведения<br/><small>&nbsp;</small>',
        'value' => function ($data) {
            return $this->widget('event\widgets\Date', ['event' => $data['event']], true);
        },
        'htmlOptions' => ['width' => '20%'],
        'type' => 'raw',
    ],
    [
        'header' => 'Участников<br/><small>&nbsp;</small>',
        'value' => function ($data) {
            return $data['participants'];
        },
        'htmlOptions' => ['width' => '10%'],
        'type' => 'raw'
    ],
    [
        'header' => 'Собрано средств<br/><small>юр.лица / карты / квитанции</small>',
        'value' => function ($data) {
            if ($data['total'] > 0) {
                return $data['total'] . '<br/>'
                . '<small>'
                . (int)$data['types'][OrderType::Juridical]
                . ' / '
                . (int)$data['types'][OrderType::PaySystem]
                . ' / '
                . (int)$data['types'][OrderType::Receipt]
                . '</small>';
            } else {
                return '0';
            }
        },
        'htmlOptions' => ['width' => '20%'],
        'type' => 'raw'
    ],
];
?>

<div class="row-fluid">

    <div class="btn-toolbar clearfix">
        <?= CHtml::beginForm(['index'], 'get', ['enctype' => 'multipart/form-data']) ?>
        <?= CHtml::endForm() ?>
    </div>

    <div class="well">
        <h2>Активные мероприятия</h2>
        <?php $this->widget('zii.widgets.grid.CGridView', [
            'dataProvider' => new CArrayDataProvider($active_data),
            'cssFile' => false,
            'itemsCssClass' => 'table table-bordered',
            'template' => '{items}',
            'columns' => $columns
        ]); ?>
        <?php $this->widget('application\widgets\Paginator', [
            'paginator' => $active_pager
        ]); ?>

        <h2>Прошедшие мероприятия</h2>
        <?php $this->widget('zii.widgets.grid.CGridView', [
            'dataProvider' => new CArrayDataProvider($past_data),
            'cssFile' => false,
            'itemsCssClass' => 'table table-bordered',
            'template' => '{items}',
            'columns' => $columns
        ]); ?>
        <?php $this->widget('application\widgets\Paginator', [
            'paginator' => $past_pager
        ]); ?>
    </div>

</div>