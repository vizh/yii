<?
/**
 * @var Event[] $waitEvents
 * @var Event[] $publishedEvents
 * @var User $users
 * @var Order[] $orders
 * @var Statistics $statistics
 */

use application\components\web\ArrayDataProvider;
use application\components\helpers\Url;
use event\models\Event;
use user\models\User;
use \pay\models\Order;
use main\components\admin\Statistics;

$numberFormatter = \Yii::app()->getNumberFormatter();
?>
<div class="row-fluid">
    <div class="row-fluid">
        <div class="block">
            <a class="block-heading" href="#">Статистика</a>
            <div class="block-body in collapse">
                <div class="stat-widget-container">
                    <div class="stat-widget" style="width:33%;">
                        <div class="stat-button">
                            <p class="title"><?=$numberFormatter->formatDecimal($statistics->users->all);?></p>
                            <p class="detail">Пользователей</p>
                        </div>
                    </div>

                    <div class="stat-widget" style="width:33%;">
                        <div class="stat-button">
                            <p class="title"><?=$numberFormatter->formatDecimal($statistics->events);?></p>
                            <p class="detail">Мероприятий</p>
                        </div>
                    </div>

                    <div class="stat-widget" style="width:33%;">
                        <div class="stat-button">
                            <p class="title"><?=$numberFormatter->formatDecimal($statistics->company);?></p>
                            <p class="detail">Компаний</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span6 block">
        <div class="block-heading">
            <a href="#yw4">Опубликованы (10 последний мероприятий)</a>
        </div>
        <div class="block-body">
            <?$this->widget('\application\widgets\grid\GridView', [
                'dataProvider'=> new ArrayDataProvider($publishedEvents),
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
            ]);?>
        </div>
    </div>
    <div class="span6 block">
        <div class="block-heading">
            <a href="#yw4">Ожидают рассмотрения (10 последний мероприятий)</a>
        </div>
        <div class="block-body">
            <?$this->widget('\application\widgets\grid\GridView', [
                'dataProvider'=> new ArrayDataProvider($waitEvents),
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
            ]);?>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="block span6">
        <div class="block-heading">
            <a href="#yw4">Пользователи (10 последних)</a>
        </div>
        <div class="block-body">
            <?$this->widget('\application\widgets\grid\GridView', [
                'dataProvider'=> new ArrayDataProvider($users),
                'columns' => [
                    [
                        'header' => 'ФИО',
                        'value' => function (User $user) {
                            return $user->getFullName();
                        }
                    ],
                    [
                        'type' => 'raw',
                        'value' => function (User $user) {
                            $html  = \CHtml::link('<i class="icon icon-edit"></i>', ['/user/admin/edit/index', 'runetId' => $user->RunetId], ['class' => 'btn']);
                            $html .= \CHtml::link('<i class="icon icon-eye-open"></i>', $user->getUrl(), ['target' => '_blank', 'class' => 'btn']);
                            return \CHtml::tag('div', ['class' => 'btn-group'], $html);
                        },
                        'htmlOptions' => ['class' => 'text-right']
                    ]
                ]
            ]);?>
        </div>
    </div>
    <div class="block span6">
        <div class="block-heading">
            <a href="#yw6">Финансовые операции (10 последних)</a>
        </div>
        <div class="block-body">
            <?$this->widget('\application\widgets\grid\GridView', [
                'dataProvider'=> new ArrayDataProvider($orders),
                'columns' => [
                    [
                        'header' => 'Мероприятие',
                        'value' => function (Order $order) {
                            return $order->Event->Title;
                        }
                    ],
                    [
                        'name' => 'Number',
                        'header' => 'Номер счета'
                    ],
                    [
                        'header' => 'Сумма',
                        'value' => function (Order $order) {
                            return \Yii::app()->getNumberFormatter()->formatCurrency($order->Total, 'RUB');
                        }
                    ],
                    [
                        'header' => 'Дата оплаты',
                        'value' => function (Order $order) {
                            return \Yii::app()->getDateFormatter()->format('dd MMM yyyy HH:mm', $order->PaidTime);
                        }
                    ],

                ],
            ]);?>
        </div>
    </div>
</div>