<?php
/**
 * @var $this Controller
 * @var \partner\models\search\OrderItems $search
 */

use pay\models\OrderItem;
use pay\components\managers\RoomProductManager;
use partner\models\search\OrderItems;
use pay\models\Order;
use partner\components\Controller;

$this->setPageTitle(\Yii::t('app', 'Заказы'));
?>


<?php $this->beginClip(Controller::PAGE_HEADER_CLIP_ID);?>
    <?=\CHtml::link('<span class="fa fa-plus"></span> ' . \Yii::t('app', 'Создание заказа'), ['create'], ['class' => 'btn btn-primary']);?>
<?php $this->endClip();?>

<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-shopping-cart"></i> <?=\Yii::t('app', 'Заказы мероприятия');?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="table-info">
            <?$this->widget('\application\widgets\grid\GridView', [
                'dataProvider'=> $search->getDataProvider(),
                'filter' => $search,
                'summaryText' => 'Заказы {start}-{end} из {count}.',
                'columns' => [
                    [
                        'name' => 'Id',
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('Id'),
                        'value' => '"<span class=\"lead\">" . $data->Id . "</span>"',
                        'width' => 120
                    ],
                    [
                        'name' => 'CreationTime',
                        'header' => $search->getAttributeLabel('CreationTime'),
                        'value' => '\Yii::app()->getDateFormatter()->format("dd MMMM yyyy HH:mm", $data->CreationTime)',
                        'filter' => false,
                        'width' => 120
                    ],
                    [
                        'name' => 'Product',
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('Product'),
                        'value' => function (OrderItem $orderItem) {
                            $result = $orderItem->Product->Title;
                            if ($orderItem->Product->ManagerName === 'RoomProductManager') {
                                /** @var RoomProductManager $manager */
                                $manager = $orderItem->Product->getManager();
                                $result .= '<p class="small m-top_5">
                                    <strong>Пансионат: ' . $manager->Hotel . '</strong><br>
                                    <strong>Номер: ' . $manager->Number . '</strong> <span class="muted">(Id: ' . $orderItem->Product->Id . ')</span><br>
                                    ' . $manager->Housing . ', ' . $manager->Category . '<br>
                                    Всего мест: ' . $manager->PlaceTotal . ' (основных - ' . $manager->PlaceBasic . ', доп. - ' . $manager->PlaceMore . ')<br>
                                    <em>' . $manager->DescriptionBasic . ', ' . $manager->DescriptionMore . '</em>
                                </p>';
                            }
                            return $result;
                        },
                        'htmlOptions' => ['class' => 'text-left'],
                        'filter' => [
                            'class' => '\partner\widgets\grid\MultiSelect',
                            'items' => $search->getProductData()
                        ],
                        'width' => 120
                    ],
                    [
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('Total'),
                        'value' => '$data->getPriceDiscount() . "&nbsp;руб."',
                        'width' => 120
                    ],
                    [
                        'type' => 'raw',
                        'name' => 'Status',
                        'header' => $search->getAttributeLabel('Status'),
                        'value' => function (OrderItem $orderItem) use ($search) {
                            if ($orderItem->Paid) {
                                return \CHtml::tag('span', ['class' => 'label label-success'], $search->getStatusData()[OrderItems::STATUS_PAID]);
                            } elseif ($orderItem->Deleted) {
                                return \CHtml::tag('span', ['class' => 'label label-danger'], $search->getStatusData()[OrderItems::STATUS_DELETED]);
                            } else {
                                return \CHtml::tag('span', ['class' => 'label'], $search->getStatusData()[OrderItems::STATUS_DEFAULT]);
                            }
                        },
                        'filter' => $search->getStatusData(),
                        'width' => 100
                    ],
                    [
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('PaidType'),
                        'value' => function (OrderItem $orderItem) {
                            $order = $orderItem->getPaidOrder();
                            if ($order !== null) {
                                $type = $order->getPayType();
                                if ($type == Order::PayTypeJuridical) {
                                    $result = \CHtml::tag('span', ['class' => 'label label-info'], \Yii::t('app', 'Юр. счет'));
                                } elseif (strpos($type, 'pay\components\systems\\') !== false) {
                                    $result = \CHtml::tag('span', ['class' => 'label label-warning'], str_replace('pay\components\systems\\', '', $type));
                                } else {
                                    $result = \CHtml::tag('span', ['class' => 'label'], \Yii::t('app', 'Не задан'));
                                }
                                $result.=\CHtml::tag('p', ['class' => 'small m-top_5'], \CHtml::link(\Yii::t('app', 'счет'), ['order/view', 'id' => $order->Id]));
                                return $result;
                            } elseif ($orderItem->CouponActivationLink !== null && $orderItem->CouponActivationLink->CouponActivation->Coupon->Discount == 1) {
                                return \CHtml::tag('span', ['class' => 'label label-warning'], \Yii::t('app', 'Промо-код 100%'));
                            } else {
                                return \CHtml::tag('span', ['class' => 'label'], \Yii::t('app', 'Не задан'));
                            }
                        },
                        'width' => 100
                    ],
                    [
                        'name'  => 'Payer',
                        'type'  => 'raw',
                        'header'=> $search->getAttributeLabel('Payer'),
                        'value' => '\CHtml::link(\CHtml::tag("span", ["class" => "lead"], $data->Payer->RunetId), ["user/edit", "id" => $data->Payer->RunetId], ["target" => "_blank"]);',
                        'headerHtmlOptions' => [
                            'colspan' => 2
                        ],
                        'filterHtmlOptions' => [
                            'colspan' => 2
                        ],
                        'width' => 120
                    ],
                    [
                        'type' => 'raw',
                        'value' => function (OrderItem $orderItem) {
                            $user = $orderItem->Payer;
                            $result = \CHtml::tag('strong', [], $user->getFullName());
                            if (($employment = $user->getEmploymentPrimary()) !== null) {
                                $result .= '<br/>' . $employment;
                            }
                            $result.='<p class="m-top_5"><i class="fa fa-envelope-o"></i>&nbsp;' . $user->Email . '</p>';
                            return $result;
                        },
                        'htmlOptions' => ['class' => 'text-left'],
                        'width' => '20%'
                    ],
                    [
                        'name'  => 'Owner',
                        'type'  => 'raw',
                        'header'=> $search->getAttributeLabel('Owner'),
                        'value' => '\CHtml::link(\CHtml::tag("span", ["class" => "lead"], $data->getCurrentOwner()->RunetId), ["user/edit", "id" => $data->getCurrentOwner()->RunetId], ["target" => "_blank"]);',
                        'headerHtmlOptions' => [
                            'colspan' => 2
                        ],
                        'filterHtmlOptions' => [
                            'colspan' => 2
                        ],
                        'width' => 120
                    ],
                    [
                        'type' => 'raw',
                        'value' => function (OrderItem $orderItem) {
                            $user = !empty($orderItem->ChangedOwner) ? $orderItem->ChangedOwner : $orderItem->Owner;
                            $result = \CHtml::tag('strong', [], $user->getFullName());
                            if (($employment = $user->getEmploymentPrimary()) !== null) {
                                $result .= '<br/>' . $employment;
                            }
                            $result.='<p class="m-top_5"><i class="fa fa-envelope-o"></i>&nbsp;' . $user->Email . '</p>';

                            if (!empty($orderItem->ChangedOwner)) {
                                $result.='
                                    <p class="m-top_5 small text-danger">' . \Yii::t('app', 'Перенесено с пользователя') . ':<br/>' . \CHtml::link($orderItem->Owner->getFullName(), ["user/edit", "id" => $orderItem->Owner->RunetId]) . '</p>';
                            }

                            return $result;
                        },
                        'htmlOptions' => ['class' => 'text-left'],
                        'width' => '20%'
                    ],
                    [
                        'class' => '\application\widgets\grid\ButtonColumn',
                        'template' => '{redirect}',
                        'buttons' => [
                            'redirect' => [
                                'label' => '<i class="fa fa-exchange"></i>',
                                'url' => 'Yii::app()->controller->createUrl("redirect",["id"=>$data->primaryKey])',
                                'options' => [
                                    'class'   => 'btn btn-default',
                                    'title'   => 'Перенести',
                                ],
                                'visible' => '$data->Paid'
                            ]
                        ]
                    ]
                ]
            ]);?>
        </div>
    </div>
</div>
