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

<?php $this->beginClip(Controller::PAGE_HEADER_CLIP_ID);?>
    <?=\CHtml::link('<span class="fa fa-plus"></span> ' . \Yii::t('app', 'Генерация промо-кодов'), ['generate'], ['class' => 'btn btn-primary']);?>
<?php $this->endClip();?>

<?=\CHtml::beginForm(['give'], 'get');?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-ticket"></i> <?=\Yii::t('app', 'Промо-коды мероприятия');?></span>
        <div class="panel-heading-controls">
            <?=\CHtml::button(\Yii::t('app', 'Выдать промо-коды'), ['class' => 'btn btn-xs btn-primary hide', 'id' => 'btn-give']);?>
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
                        'htmlOptions' => ['style' => 'width: 1px;'],
                        'header' => \CHtml::checkBox("", false)
                    ],
                    [
                        'name' => 'Code',
                        'type' => 'raw',
                        'header' =>  $search->getAttributeLabel('Code'),
                        'value' => '\CHtml::tag("span", ["class" => "lead"], $data->Code)'
                    ],
                    [
                        'name'  => 'Discount',
                        'header' =>  $search->getAttributeLabel('Discount'),
                        'type'  => 'raw',
                        'value' => '$data->Discount * 100 . "%"'
                    ],
                    [
                        'name' => 'Product',
                        'header' =>  $search->getAttributeLabel('Product'),
                        'type' => 'raw',
                        'value' => function (Coupon $coupon) {
                            if (!empty($coupon->Products)) {
                                $result = '';
                                foreach ($coupon->Products as $product) {
                                    $result .= Texts::cropText($product->Title, 50) . '<br/>';
                                }
                                return $result;
                            }
                        },
                        'filter' => [
                            'class' => '\partner\widgets\grid\MultiSelect',
                            'items' => $search->getProductData()
                        ]
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
                                    $result .= \CHtml::tag('p', [], \CHtml::tag('span', ['class' => 'small m-top_5'], \CHtml::link($user->getFullName() . ' (' . $user->RunetId . ')', ['user/edit', 'id' => $user->RunetId], ['target' => '_blank'])));
                                }
                            } elseif (empty($coupon->Recipient)) {
                                $result .= \CHtml::tag('span', ['class' => 'label'], \Yii::t('app', 'Не выдан'));
                            } else {
                                $result .= \CHtml::tag('span', ['class' => 'label label-success'], \Yii::t('app', 'Выдан'));
                                $result .= \CHtml::tag('p', ['class' => 'small m-top_5'], $coupon->Recipient);
                            }
                            return $result;
                        }
                    ],
                    [
                        'name' => 'Owner',
                        'header' => $search->getAttributeLabel('Owner'),
                        'type' => 'raw',
                        'value' => function (Coupon $coupon) {
                            if (!$coupon->Multiple && !empty($coupon->Activations)) {
                                $user = $coupon->Activations[0]->User;
                                return \CHtml::tag('span', ['class' => 'label label-success'], \Yii::t('app', 'Активирован')).
                                    '<p class="small">' . \CHtml::link($user->getFullName() . ' (' . $user->RunetId . ')', ['user/edit', 'id' => $user->RunetId], ['target' => '_blank']) . '</p>';
                            } elseif ($coupon->Multiple) {
                                return \CHtml::tag(
                                    'span',
                                    ['class' => 'label' . (!empty($coupon->Activations) ? ' label-success' : '')],
                                    \Yii::t('app', 'Активирован') . ' ' . sizeof($coupon->Activations) . ' ' . \Yii::t('app', 'из') . ' ' . $coupon->MultipleCount
                                );
                            } else {
                                return \CHtml::tag('span', ['class' => 'label'], \Yii::t('app', 'Не активирован'));
                            }
                        }
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
                        'filter' => false
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
                            ]
                        ],
                        'template' => '{statistics}'
                    ]
                ]
            ]);?>
        </div>
    </div>
</div>
<?=\CHtml::endForm();?>

<?/*
<?if (!empty($coupons)):?>
<form action="<?=Yii::app()->createUrl('/partner/coupon/give');?> " method="GET">
<table class="table table-striped">
    <thead>
    <tr>
        <th><input type="checkbox" name="" value="" /></th>
        <th>Промо-код</th>
        <th>Скидка</th>
        <th>Продукт</th>
        <th>Выдан</th>
        <th>Активация</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($coupons as $coupon):?>
    <tr>
        <td>
          <?if (!$coupon->IsTicket):?>
            <input type="checkbox" name="Coupons[]" value="<?=$coupon->Code;?>" />
          <?endif;?>
        </td>
        <td><strong><?=$coupon->Code;?></strong></td>
        <td><strong><?=($coupon->Discount * 100);?> %</strong></td>
        <td>
            <?if (!empty($coupon->Products)):?>
                <?foreach ($coupon->Products as $product):?>
                    <span title="<?=$product->Title;?>">
                        <?=\application\components\utility\Texts::cropText($product->Title, 20);?>
                    </span><br>
                <?endforeach;?>
            <?else:?>
                &ndash;
            <?endif;?>
        </td>
        <td>
            <?if ($coupon->IsTicket):?>
              <span class="label label-important"><?=\Yii::t('app', 'Продан');?></span>
              <?if ($coupon->Owner->Temporary):?>
                <br/><span class="small"><?=$coupon->Owner->Email;?>, <?=$coupon->Owner->RunetId;?>
              <?else:?>
                <br/><a target="_blank" href="<?=\Yii::app()->createUrl('/user/view/index', array('runetId' => $coupon->Owner->RunetId));?>" class="small"><strong><?=$coupon->Owner->getFullName();?>, <?=$coupon->Owner->RunetId;?></strong></a>
              <?endif;?>
            <?elseif ($coupon->Recipient == null):?>
                <span class="label"><?=\Yii::t('app', 'Не выдан');?></span>
            <?else:?>
                <span class="label label-info"><?=\Yii::t('app', 'Выдан');?></span>
                <p>
                  <em><?=$coupon->Recipient;?></em>
                </p>
            <?endif;?>
        </td>
        <td>
            <?php if (!$coupon->Multiple && sizeof($coupon->Activations) > 0):?>
                <span class="label label-success">Активирован</span> 
                <br/><a target="_blank" href="<?=Yii::app()->createUrl('/user/view/index', array('runetId' => $coupon->Activations[0]->User->RunetId));?>" class="small"><strong><?=$coupon->Activations[0]->User->getFullName();?>, <?=$coupon->Activations[0]->User->RunetId;?></strong></a>
            <?php elseif ($coupon->Multiple):?>
                <span class="label <?=count($coupon->Activations) > 0 ? 'label-success' : '';?>">
                    Активирован <?=sizeof($coupon->Activations);?> из <?=$coupon->MultipleCount;?>
                </span>
            <?php else:?>
                <span class="label">Не активирован</span>
            <?php endif;?>
        </td>
        <td>
            <a target="_blank" title="Статистика" class="btn" href="<?=Yii::app()->createUrl('/partner/coupon/statistics', ['eventIdName' => $event->IdName, 'code' => $coupon->Code, 'hash' => $coupon->getHash()]);?>"><i class="icon-share"></i></a>
        </td>
    </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr>
        <td></td>
        <td><input type="submit" value="Выдать промо-коды" style="display: none;" class="btn btn-mini btn-success"/></a></td>
        <td colspan="4"></td>
      </tr>
    </tfoot>
</table>
</form>
<?php else:?>
    <div class="alert">По Вашему запросу нет ни одного участника.</div>
<?php endif;?>

<?$this->widget('\application\widgets\Paginator', array('paginator' => $paginator));?>
*/?>
