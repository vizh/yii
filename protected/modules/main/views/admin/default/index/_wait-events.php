<?php
/**
 * @var Event[] $events
 */
use event\models\Event;
use application\components\web\ArrayDataProvider;
?>
<div class="block-heading">
    <a href="#yw2">Ожидают рассмотрения</a>
</div>
<div class="block-body">
    <?$this->widget('\application\widgets\grid\GridView', [
        'dataProvider'=> new ArrayDataProvider($events),
        'columns' => [
            [
                'name' => 'Title',
                'header' => 'Название мероприятия'
            ],
            [
                'type' => 'html',
                'value' => function (Event $event) {
                    return \CHtml::link('<i class="icon icon-edit"></i>', ['/event/admin/edit/index', 'eventId' => $event->Id], ['class' => 'btn']);
                },
                'htmlOptions' => ['class' => 'text-right']
            ]
        ]
    ])?>
</div>