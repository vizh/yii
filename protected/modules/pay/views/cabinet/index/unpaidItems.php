<?php
/**
 * @var $unpaidItems array
 * @var $hasRecentPaidItems bool
 * @var $this CabinetController
 * @var $account \pay\models\Account
 * @var $formAdditionalAttributes \pay\models\forms\AddtionalAttributes
 */

$total = 0;
?>

<?if (sizeof($unpaidItems->all) > 0 || sizeof($unpaidItems->tickets) > 0 || sizeof($unpaidItems->callbacks) > 0):?>

    <table class="table thead-actual">
        <thead>
        <tr>
            <th><?=\Yii::t('app', 'Тип билета');?></th>
            <th class="col-width t-right"><?=\Yii::t('app', 'Цена');?></th>
            <th class="col-width t-right"><?=\Yii::t('app', 'Кол-во');?></th>
            <th class="col-width t-right last-child"><?=\Yii::t('app', 'Сумма');?></th>
        </tr>
        </thead>
    </table>

    <?foreach ($unpaidItems->all as $items):?>
        <?
        /** @var $items \pay\components\OrderItemCollectable[] */
        $product = $items[0]->getOrderItem()->Product;
        ?>
        <table class="table">
            <thead>
            <tr>
                <th colspan="2"><h4 class="title"><?=$product->Title;?> <i class="icon-chevron-up"></i></h4></th>
                <th class="col-width t-right"><span class="number"><?=$product->getPrice();?></span> <?=Yii::t('app', 'руб.');?></th>
                <th class="col-width t-right"><b class="number"><?=sizeof($items);?></b></th>
                <th class="col-width t-right last-child"><b class="number"><?=$product->getPrice()*sizeof($items);?></b> <?=Yii::t('app', 'руб.');?></th>
            </tr>
            </thead>
            <tbody>
            <?foreach ($items as $item):?>
                <?$total += $item->getPriceDiscount();?>
                <tr>
                    <td style="padding-left: 10px; width: 15px;">
                        <?= \CHtml::beginForm(array('/pay/cabinet/deleteitem', 'orderItemId' => $item->getOrderItem()->Id), 'post', array('class' => 'button-only')); ?>
                        <?= \CHtml::htmlButton('<i class="icon-trash"></i>', array('type' => 'submit')); ?>
                        <?= \CHtml::endForm(); ?>
                    </td>
                    <td>
                        <?=$item->getOrderItem()->Owner->getFullName();?>
                    </td>
                    <td colspan="3" class="t-right muted last-child">
                        <?if ($item->getPriceDiscount() < $item->getOrderItem()->getPrice()):?>
                            <?if (!$item->getIsGroupDiscount()):?>
                                <?if ($item->getOrderItem()->getCouponActivation() !== null):?>
                                    <?=\Yii::t('app', 'Промо код');?> <?=$item->getOrderItem()->getCouponActivation()->Coupon->Code;?>
                                <?elseif ($item->getOrderItem()->Owner->hasLoyaltyDiscount()):?>
                                    <?=\Yii::t('app', 'RUNET-ID CARD');?>
                                <?endif;?>
                            <?else:?>
                                <?=\Yii::t('app', 'Групповая скидка');?>:
                            <?endif;?>
                            <b class="number">-<?=$item->getOrderItem()->getPrice() - $item->getPriceDiscount();?></b> <?=Yii::t('app', 'руб.');?>
                        <?elseif ($item->getOrderItem()->Product->ManagerName == 'RoomProductManager'):?>
                            <?$dateFormatter = Yii::app()->getLocale()->getDateFormatter();?>
                            с <?=$dateFormatter->format('dd MMMM' , strtotime($item->getOrderItem()->getItemAttribute('DateIn')));?> по <?=$dateFormatter->format('dd MMMM' , strtotime($item->getOrderItem()->getItemAttribute('DateOut')));?> за  <b class="number"><?=$item->getPriceDiscount();?></b> <?=Yii::t('app', 'руб.');?>
                        <?endif;?>
                    </td>
                </tr>
            <?endforeach;?>
            </tbody>
        </table>
    <?endforeach;?>

    <?foreach ($unpaidItems->callbacks as $items):?>
        <?
        /** @var $items \pay\components\OrderItemCollectable[] */
        $product = $items[0]->getOrderItem()->Product;
        ?>
        <table class="table">
            <thead>
            <tr>
                <th colspan="5"><h4 class="title"><?=$product->Title;?> <i class="icon-chevron-up"></i></h4></th>
            </tr>
            </thead>
            <tbody>
            <?foreach ($items as $item):?>
                <?$total += $item->getPriceDiscount();?>
                <tr>
                    <td style="padding-left: 10px; width: 15px;">
                        <?= \CHtml::beginForm(array('/pay/cabinet/deleteitem', 'orderItemId' => $item->getOrderItem()->Id), 'post', array('class' => 'button-only')); ?>
                        <?= \CHtml::htmlButton('<i class="icon-trash"></i>', array('type' => 'submit')); ?>
                        <?= \CHtml::endForm(); ?>
                    </td>
                    <td><?=$item->getOrderItem()->Product->getManager()->getTitle($item->getOrderItem());?></td>
                    <td class="col-width t-right"><?=$item->getOrderItem()->getPrice();?> <?=Yii::t('app', 'руб.');?></td>
                    <td class="col-width t-right"><?=$item->getOrderItem()->Product->getManager()->getCount($item->getOrderItem());?></td>
                    <td class="col-width t-right last-child"><b class="number"><?=$item->getOrderItem()->getPrice();?>  <?=Yii::t('app', 'руб.');?></b></td>
                </tr>
            <?endforeach;?>
            </tbody>
        </table>
    <?endforeach;?>

    <?foreach ($unpaidItems->tickets as $items):?>
        <table class="table">
            <thead>
            <tr>
                <th colspan="5"><h4 class="title"><?=\Yii::t('app', 'Билеты');?> <i class="icon-chevron-up"></i></h4></th>
            </tr>
            </thead>
            <tbody>
            <?foreach ($items as $item):?>
                <?$total += $item->getPriceDiscount();?>
                <tr>
                    <td style="padding-left: 10px; width: 15px;">
                        <?= \CHtml::beginForm(array('/pay/cabinet/deleteitem', 'orderItemId' => $item->getOrderItem()->Id), 'post', array('class' => 'button-only')); ?>
                        <?= \CHtml::htmlButton('<i class="icon-trash"></i>', array('type' => 'submit')); ?>
                        <?= \CHtml::endForm(); ?>
                    </td>
                    <td><?=$item->getOrderItem()->Product->getManager()->getTitle($item->getOrderItem());?></td>
                    <td class="col-width t-right"><?=$item->getOrderItem()->Product->getPrice();?> <?=Yii::t('app', 'руб.');?></td>
                    <td class="col-width t-right"><?=$item->getOrderItem()->getItemAttribute('Count');?></td>
                    <td class="col-width t-right last-child"><b class="number"><?=$item->getOrderItem()->getPrice();?>  <?=Yii::t('app', 'руб.');?></b></td>
                </tr>
            <?endforeach;?>
            </tbody>
        </table>
    <?endforeach;?>

    <div class="total">
        <span><?=\Yii::t('app', 'Итого');?>:</span> <b class="number"><?=\Yii::app()->numberFormatter->format('#,##0.00', $total);?></b> <?=Yii::t('app', 'руб.');?>
    </div>

    <div style="width: 500px; margin: 0 auto; margin-bottom: 40px;">
        <?if (!$formAdditionalAttributes->getIsEmpty()):?>
            <div class="well m-bottom_30">
                <h4><?=($formAdditionalAttributes->FormTitle !== null ? $formAdditionalAttributes->FormTitle : \Yii::t('app', 'Дополнительные данные'));?></h4>
                <?=\CHtml::errorSummary($formAdditionalAttributes, '<div class="alert alert-error">', '</div>');?>
                <?=\CHtml::form('','POST',['class' => 'additional-attributes']);?>
                <?foreach($formAdditionalAttributes->attributeNames() as $attr):?>
                    <div class="control-group">
                        <?=\CHtml::activeLabel($formAdditionalAttributes, $attr, ['class' => 'control-label']);?>
                        <div class="controls">
                            <?=$formAdditionalAttributes->getHtmlActiveField($attr);?>
                        </div>
                    </div>
                <?endforeach;?>
                <?=\CHtml::activeHiddenField($formAdditionalAttributes, 'SuccessUrl');?>
                <?=\CHtml::endForm();?>
            </div>
        <?endif;?>

        <label class="checkbox">
            <input type="checkbox" name="agreeOffer" value="1"/><?=\Yii::t('app', 'Я согласен с условиями <a target="_blank" href="{url}">договора-оферты</a> и готов перейти к оплате', array('{url}' => $this->createUrl('/pay/cabinet/offer')));?>
        </label>
    </div>

    <?$this->renderPartial('index/payments', ['account' => $account, 'total' => $total]);?>
<?else:?>

    <style type="text/css">
        .event-register .alert {
            margin: 0 40px 40px;
        }
    </style>
    <?if (!$hasRecentPaidItems):?>
        <div class="alert alert-error"><?=\Yii::t('app', 'У вас нет товаров для оплаты.');?></div>
    <?else:?>
        <div class="alert alert-success"><?=\Yii::t('app', 'Вы недавно оплатили участие или активировали промо-код. Список оплаченных товаров можно посмотреть ниже.');?></div>
    <?endif;?>

    <div class="nav-buttons">
        <a href="<?=$account->ReturnUrl===null ? $this->createUrl('/pay/cabinet/register') : $account->ReturnUrl;?>" class="btn btn-large">
            <i class="icon-circle-arrow-left"></i>
            <?=\Yii::t('app', 'Назад');?>
        </a>
    </div>

<?endif;?>