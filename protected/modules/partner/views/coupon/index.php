<?php
/**
 * @var Controller $this
 * @var \application\modules\partner\models\search\Coupons $search
 */

use pay\models\Coupon;
use application\components\utility\Texts;
use \partner\components\Controller;

$this->setPageTitle(\Yii::t('app', 'Промо-коды'));
?>

<?$this->beginClip(Controller::PAGE_HEADER_CLIP_ID)?>
    <?=\CHtml::link('<span class="fa fa-plus btn-label"></span> ' . \Yii::t('app', 'Генерация промо-кодов'), ['generate'], ['class' => 'btn btn-primary btn-labeled'])?>
<?$this->endClip()?>

<?=\CHtml::beginForm(['give'], 'get')?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-ticket"></i> <?=\Yii::t('app', 'Промо-коды мероприятия')?></span>
        <div class="panel-heading-controls">
            <?=\CHtml::button(\Yii::t('app', 'Выдать промо-коды'), ['class' => 'btn btn-xs btn-primary hide', 'id' => 'btn-give'])?>
        </div>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="table-info">
            <?$this->widget('\application\widgets\grid\GridView', [
                'dataProvider'=> $search->getDataProvider(),
                'filter' => $search,
                'summaryCssClass' => 'table-header clearfix',
                'summaryText' => 'Промо-коды {start}-{end} из {count}.',
                'afterAjaxUpdate' => 'pageCouponIndex.init',
                'columns' => [
                    [
                        'type'  => 'raw',
                        'value' => function (Coupon $coupon) {
                            if (!$coupon->IsTicket) {
                                return \CHtml::checkBox('Coupons[]', false, ['value' => $coupon->Id]);
                            }
                        },
                        'header' => \CHtml::checkBox("", false),
                        'width' => 1
                    ],
                    [
                        'name' => 'Code',
                        'type' => 'raw',
                        'header' =>  $search->getAttributeLabel('Code'),
                        'value' => '\CHtml::tag("span", ["class" => "lead"], $data->Code)',
                        'width' => '20%'
                    ],
                    [
                        'name'  => 'Discount',
                        'header' =>  $search->getAttributeLabel('Discount'),
                        'type'  => 'raw',
                        'value' => '$data->getManager()->getDiscountString()',
                        'width' => 100
                    ],
                    [
                        'name' => 'Product',
                        'header' =>  $search->getAttributeLabel('Product'),
                        'type' => 'raw',
                        'value' => function (Coupon $coupon) {
                            if (!empty($coupon->Products)) {
                                $result = '';
                                foreach ($coupon->Products as $product) {
                                    $result .= \CHtml::tag('span', ['title' => $product->Title], Texts::cropText($product->Title, 50)) . '<br/>';
                                }
                                return $result;
                            } else {
                                return \CHtml::tag('label', ['class' => 'label label-success'], \Yii::t('app', 'Все продукты'));
                            }
                        },
                        'filter' => [
                            'class' => '\partner\widgets\grid\MultiSelect',
                            'items' => $search->getProductData()
                        ],
                        'width' => '30%'
                    ],
                    [
                        'type'  => 'raw',
                        'value' => function (Coupon $coupon) {
                            $result = '';
                            if ($coupon->IsTicket) {
                                $user = $coupon->Owner;
                                $result .= \CHtml::tag('span', ['class' => 'label label-primary'], \Yii::t('app', 'Продан'));
                                if ($coupon->Owner->Temporary) {
                                    $result .= \CHtml::tag('p', [], \CHtml::tag('span', ['class' => 'small m-top_5'], \CHtml::mailto($user->Email)));
                                } else {
                                    $result .= \CHtml::tag('p', [], \CHtml::tag('span', ['class' => 'small m-top_5'], \CHtml::link('<span class="text-light-gray">' . $user->RunetId . ',</span> ' . $user->getFullName(), ['user/edit', 'id' => $user->RunetId], ['target' => '_blank'])));
                                }
                            } elseif (empty($coupon->Recipient)) {
                                $result .= \CHtml::tag('span', ['class' => 'label'], \Yii::t('app', 'Не выдан'));
                            } else {
                                $result .= \CHtml::tag('span', ['class' => 'label label-success'], \Yii::t('app', 'Выдан'));
                                $result .= \CHtml::tag('p', ['class' => 'small m-top_5'], $coupon->Recipient);
                            }
                            return $result;
                        },
                        'width' => 150
                    ],
                    [
                        'name' => 'Owner',
                        'header' => $search->getAttributeLabel('Owner'),
                        'type' => 'raw',
                        'value' => function (Coupon $coupon) {
                            if (!$coupon->Multiple && !empty($coupon->Activations)) {
                                $user = $coupon->Activations[0]->User;
                                return \CHtml::tag('span', ['class' => 'label label-success'], \Yii::t('app', 'Активирован')).
                                    '<p class="small m-top_5">' . \CHtml::link('<span class="text-light-gray">' . $user->RunetId . ',</span> ' . $user->getFullName(), ['user/edit', 'id' => $user->RunetId], ['target' => '_blank']) . '</p>';
                            } elseif ($coupon->Multiple) {
                                return \CHtml::tag(
                                    'span',
                                    ['class' => 'label' . (!empty($coupon->Activations) ? ' label-success' : '')],
                                    \Yii::t('app', 'Активирован') . ' ' . sizeof($coupon->Activations) . ' ' . \Yii::t('app', 'из') . ' ' . $coupon->MultipleCount
                                );
                            } else {
                                return \CHtml::tag('span', ['class' => 'label'], \Yii::t('app', 'Не активирован'));
                            }
                        },
                        'width' => 150
                    ],
                    [
                        'name' => 'EndTime',
                        'header' => $search->getAttributeLabel('EndTime'),
                        'type'  => 'raw',
                        'value' => function (Coupon $coupon) {
                            if (!empty($coupon->EndTime)) {
                                $date = \Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $coupon->EndTime);
                                if ($coupon->EndTime < date('Y-m-d H:i:s')) {
                                    return \CHtml::tag('span', ['class' => 'label label-danger'], \Yii::t('app', 'Истек') . ' ' . $date);
                                } else {
                                    return \CHtml::tag('span', ['class' => 'label label-default'], \Yii::t('app', 'До') . ' ' . $date);
                                }
                            } else {
                                return \CHtml::tag('span', ['class' => 'label label-info'], \Yii::t('app', 'Безлимитный'));
                            }
                        },
                        'filter' => false,
                        'width' => 100
                    ],
                    [
                        'class' => '\application\widgets\grid\ButtonColumn',
                        'buttons' => [
                            'statistics' => [
                                'label' => '<i class="fa fa-pie-chart"></i>',
                                'url' => 'Yii::app()->controller->createUrl("statistics",["id" => $data->Id])',
                                'options' => [
                                    'class' => 'btn btn-info',
                                    'title' => 'Статистика'
                                ]
                            ],
                            'delete' => [
                                'visible' => '!$data->IsTicket && empty($data->Activations)'
                            ],
                        ],
                        'template' => '{statistics}{delete}'
                    ]
                ]
            ])?>
        </div>
    </div>
</div>
<?=\CHtml::endForm()?>