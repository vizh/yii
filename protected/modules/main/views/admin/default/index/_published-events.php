<?php
/**
 * @var Event[] $events
 */
use event\models\Event;
use application\components\web\ArrayDataProvider;
?>
<div class="block-heading">
    <a href="#yw0">Опубликованы (10 последний мероприятий)</a>
</div>
<div class="block-body">
    <?$this->widget('\application\widgets\grid\GridView', [
        'dataProvider'=> new ArrayDataProvider($events),
        'columns' => [
            [
                'name'  => 'Title',
                'header' => 'Название мероприятия'
            ],
            [
                'type' => 'html',
                'value' => function (Event $event) {
                    $html  = \CHtml::link('<i class="icon icon-edit"></i>', ['/event/admin/edit/index', 'eventId' => $event->Id], ['class' => 'btn']);
                    $html .= \CHtml::link('<i class="icon icon-shopping-cart"></i>', ['/event/admin/edit/product', 'eventId' => $event->Id], ['class' => 'btn']);
                    return \CHtml::tag('div', ['class' => 'btn-group'], $html);
                },
                'htmlOptions' => ['class' => 'text-right']
            ]
        ]
    ])?>
</div>