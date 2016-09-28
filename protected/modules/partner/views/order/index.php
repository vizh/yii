<?php
/**
 * @var Controller $this
 * @var Orders $search
 */

use pay\models\Order;
use pay\models\OrderType;
use application\modules\partner\models\search\Orders;
use partner\components\Controller;

$this->setPageTitle(\Yii::t('app', 'Счет'));

$controller = $this;
?>

<?$this->beginClip(Controller::PAGE_HEADER_CLIP_ID)?>
    <?=CHtml::link(
        '<span class="fa fa-plus btn-label"></span> ' . Yii::t('app', 'Выставить счет'),
        ['edit'],
        ['class' => 'btn btn-primary btn-labeled']
    )?>
<?$this->endClip()?>

<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-building-o"></i> <?=Yii::t('app', 'Счета мероприятия')?></span>
    </div>
    <div class="panel-body">
        <div class="table-info">
            <?$this->widget('application\widgets\grid\GridView', [
                'dataProvider' => $search->getDataProvider(),
                'filter' => $search,
                'summaryCssClass' => 'table-header',
                'summaryText' => 'Счета {start}-{end} из {count}.',
                'columns' => [
                    [
                        'name' => 'Number',
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('Number'),
                        'value' => function (Order $order) {
                            return \CHtml::tag('span', ['class' => 'lead'], $order->Number);
                        },
                        'width' => 150
                    ],
                    [
                        'name' => 'Type',
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('Type'),
                        'value' => function (Order $order) {
                            if ($order->Type == OrderType::Juridical) {
                                $result = \CHtml::tag('span', ['class' => 'label label-info'], OrderType::getTitle($order->Type));
                                $result .= '<p class="small m-top_5">' . $order->OrderJuridical->Name . ', ' . \Yii::t('app', 'ИНН/КПП:') . ' ' . $order->OrderJuridical->INN . '/' . $order->OrderJuridical->KPP . '</p>';
                                return $result;
                            } elseif ($order->Type == OrderType::Receipt) {
                                return \CHtml::tag('span', ['class' => 'label label-warning'], OrderType::getTitle($order->Type));
                            } else {
                                return \CHtml::tag('span', ['class' => 'label label-primary'], OrderType::getTitle($order->Type));
                            }
                        },
                        'filter' => [
                            'class' => '\partner\widgets\grid\MultiSelect',
                            'items' => $search->getTypeData()
                        ]
                    ],
                    [
                        'name' => 'Payer',
                        'header' => $search->getAttributeLabel('Payer'),
                        'type' => 'raw',
                        'value' => function (Order $order) use ($controller) {
                            return $controller->renderPartial('../partial/grid/user', ['user' => $order->Payer], true);
                        },
                        'htmlOptions' => ['class' => 'text-left'],
                        'width' => '30%',
                        'filterInputHtmlOptions' => [
                            'placeholder' => \Yii::t('app', 'ФИО, компания или ИНН')
                        ],
                    ],
                    [
                        'name' => 'CreationTime',
                        'header' => $search->getAttributeLabel('CreationTime'),
                        'value' => 'Yii::app()->locale->getDateFormatter()->format("d MMMM y", $data->CreationTime)',
                        'filter' => false,
                        'width' => 100
                    ],
                    [
                        'name' => 'Status',
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('Status'),
                        'value' => function (Order $order) use ($search) {
                            if ($order->Paid) {
                                $result = \CHtml::tag('span', ['class' => 'label label-success'], $search->getStatusData()[Orders::STATUS_PAID]);
                                $result .= '<p class="small m-top_5">' . \Yii::app()->getDateFormatter()->format('d MMMM y', $order->PaidTime) . '</p>';
                                return $result;
                            } elseif ($order->Deleted) {
                                return \CHtml::tag('span', ['class' => 'label label-danger'], $search->getStatusData()[Orders::STATUS_DELETED]);
                            } else {
                                return \CHtml::tag('span', ['class' => 'label'], $search->getStatusData()[Orders::STATUS_DEFAULT]);
                            }
                        },
                        'filter' => $search->getStatusData(),
                        'width' => 100
                    ],
                    [
                        'name' => 'Price',
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('Price'),
                        'value' => '$data->getPrice() . "&nbsp;руб."',
                        'filter' => false,
                        'width' => 120
                    ],
                    [
                        'class' => '\application\widgets\grid\ButtonColumn',
                        'template' => '{view}{update}{paid}{print}',
                        'buttons' => [
                            'update' => [
                                'visible' => '$data->getIsBankTransfer() && !$data->Paid && !$data->Deleted && Yii::app()->controller->getAccessFilter()->checkAccess("partner", "order", "edit")'
                            ],
                            'print' => [
                                'label' => '<i class="fa fa-print"></i>',
                                'url' => '$data->getUrl(true)',
                                'options' => [
                                    'class' => 'btn btn-default',
                                    'target' => '_blank',
                                    'title' => 'Печать'
                                ],
                                'visible' => '$data->getIsBankTransfer()'
                            ],
                            'paid' => [
                                'label' => '<i class="fa fa-check"></i>',
                                'visible' => '!$data->Deleted && !$data->Paid && $data->getIsBankTransfer() && Yii::app()->controller->getAccessFilter()->checkAccess("partner", "order", "activate")',
                                'options' => [
                                    'class' => 'btn btn-warning',
                                    'title' => 'Отметить данный счет оплаченным'
                                ],
                                'url' => 'Yii::app()->controller->createUrl("activate",["id"=>$data->primaryKey])'
                            ]
                        ]
                    ]
                ]
            ])?>
        </div>
    </div>
</div>