<?php

/**
 * @var $order \pay\models\Order
 * @var $this \partner\components\Controller
 */

use application\helpers\Flash;
use pay\models\OrderType;

$collection = \pay\components\OrderItemCollection::createByOrder($order);
$formatter = \Yii::app()->getDateFormatter();
$this->setPageTitle('Управление счетом № ' . $order->Number)
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title">Информация о счете</span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?=Flash::html();?>
        <h2 class="clear-indents">Счет № <?=$order->Number;?></h2>
        <p class="text-xs m-top_5"><?=\Yii::t('app', 'Создан');?>: <?=$formatter->format('dd MMMM yyyy HH:mm', $order->CreationTime);?></p>
        <div class="m-top_10">
            <?php if ($order->Paid):?>
                <span class="label label-success">Оплачен <?=$formatter->format('dd MMMM yyyy HH:mm', $order->PaidTime);?></span>
            <?php else:?>
                <?php if (!$order->Deleted):?>
                    <span class="label label-warning">Не оплачен</span>
                <?php else:?>
                    <span class="label label-danger">Удален</span>
                <?php endif;?>
            <?php endif;?>
        </div>
        <hr/>
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-info panel-dark">
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <span class="panel-title"><?=\Yii::t('app', 'Данные пользователя');?></span>
                    </div>
                    <!-- List group -->
                    <ul class="list-group">
                        <li class="list-group-item"><?=\CHtml::link($order->Payer->getFullName(), ['user/edit', 'id' => $order->Payer->RunetId], ['target' => '_blank']);?> <sup><?=$order->Payer->RunetId;?></sup></li>
                        <?php
                        $employment = $order->Payer->getEmploymentPrimary();
                        if (!empty($employment)):?>
                            <li class="list-group-item"><?=$employment;?></li>
                        <?php endif;?>
                        <li class="list-group-item"><?=\CHtml::mailto($order->Payer->Email);?></li>
                        <?php
                        $phone = $order->Payer->getPhone();
                        if (!empty($phone)):?>
                            <li class="list-group-item"><?=$phone;?></li>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
            <?php if ($order->Type == OrderType::Juridical):?>
            <div class="col-sm-6">
                <div class="panel panel-info panel-dark">
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <span class="panel-title"><?=\Yii::t('app', 'Данные заказчика');?></span>
                    </div>
                    <!-- List group -->
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Название компании:</strong> <?=$order->OrderJuridical->Name;?></li>
                        <li class="list-group-item"><strong>Адрес:</strong> <?=$order->OrderJuridical->Address;?></li>
                        <li class="list-group-item"><strong>ИНН/КПП:</strong> <?=$order->OrderJuridical->INN;?>/<?=$order->OrderJuridical->KPP;?></li>
                        <li class="list-group-item"><strong>Телефон:</strong> <?=$order->OrderJuridical->Phone;?></li>
                    </ul>
                </div>
            </div>
            <?php endif;?>
        </div>
        <hr/>

        <div class="table-info">
            <div class="table-header">
                <div class="table-caption">
                    <?=\Yii::t('app', 'Состав счета');?>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?=\Yii::t('app', 'Номер');?></th>
                        <th style="width:40%"><?=\Yii::t('app', 'Наименование')?></th>
                        <th><?=\Yii::t('app', 'Плательщик');?></th>
                        <th><?=\Yii::t('app', 'Получатель');?></th>
                        <th><?=\Yii::t('app', 'Стоимость');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?foreach ($collection as $item):?>
                        <tr>
                            <td>
                                <?=$item->getOrderItem()->Id?>
                                <br>
                                <?if ($item->getOrderItem()->Paid):?>
                                    <span class="label label-success"><?=\Yii::t('app', 'Оплачен');?></span>
                                <?elseif ($item->getOrderItem()->Refund):?>
                                    <span class="label label-danger"><?=\Yii::t('app', 'Возврат');?></span>
                                <?else:?>
                                    <span class="label label-warning"><?=\Yii::t('app', 'Не оплачен');?></span>
                                <?endif?>
                            </td>
                            <td class="text-left">
                                <?=$item->getOrderItem()->Product->getManager()->getTitle($item->getOrderItem());?>
                            </td>
                            <td class="text-left">
                                <?=$this->renderPartial('../partial/grid/user', ['user' => $item->getOrderItem()->Payer], true);?>
                            </td>
                            <td>
                                <?=$this->renderPartial('../partial/grid/user', [
                                    'user' => $item->getOrderItem()->Owner,
                                    'hideContacts' => true,
                                    'hideEmployment' => true
                                ], true);?>
                                <?if ($item->getOrderItem()->ChangedOwner !== null):?>
                                    <p class="m-top_10">
                                        <strong class="text-success"><?=\Yii::t('app', 'Перенесено на пользователя');?>:</strong><br/>
                                        <?=\CHtml::link($item->getOrderItem()->ChangedOwner->getFullName(), ['user/edit', 'id' => $item->getOrderItem()->ChangedOwner->RunetId]);?>&nbsp;<sup><?=$item->getOrderItem()->ChangedOwner->RunetId;?></sup>
                                    </p>
                                <?php endif;?>
                            </td>
                            <td><?=$item->getPriceDiscount();?> руб.</td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <div class="table-footer lead">
                <?=\Yii::t('app', 'Сумма счета');?>: <?=$order->getPrice();?> руб.
            </div>
        </div>
    </div>
    <?php if (OrderType::getIsBank($order->Type)):?>
        <div class="panel-footer">
            <div class="btn-group">
                <?php if (!$order->Deleted):?>
                    <?php if (!$order->Paid && $this->getAccessFilter()->checkAccess('partner', 'order', 'activate')):?>
                        <?=\CHtml::link('<span class="fa fa-check"></span> Отметить как оплаченный', ['activate', 'id' => $order->Id], ['class' => 'btn btn-success', 'onclick' => "return confirm('" . ($order->Paid ? 'Счет уже отмечен как оплаченный. Повторить?' : 'Вы уверены, что хотите отметить данный счет оплаченным?') . "');"]);?>
                    <?php endif;?>
                    <?php if ($order->getIsBankTransfer() && !$order->Paid && $this->getAccessFilter()->checkAccess('partner', 'order', 'edit')):?>
                        <?=\CHtml::link('<span class="fa fa-pencil"></span> Редактировать', ['edit', 'id' => $order->Id], ['class' => 'btn btn-info']);?>
                    <?php endif;?>
                    <?php if (!$order->Paid  && $this->getAccessFilter()->checkAccess('partner', 'order', 'delete')):?>
                        <?=\CHtml::link('<span class="fa fa-times"></span> Удалить', ['delete', 'id' => $order->Id], ['class' => 'btn btn-danger', 'onclick' => "return confirm('Вы уверены, что хотите удалить счет?');"]);?>
                    <?php endif;?>
                <?php endif;?>
                <?=\CHtml::link('<span class="fa fa-print"></span> Счет с печатью', $order->getUrl(), ['class' => 'btn', 'target' => '_blank']);?>
                <?=\CHtml::link('<span class="fa fa-print"></span> Счет без печати', $order->getUrl(true), ['class' => 'btn', 'target' => '_blank']);?>
            </div>
        </div>
    <?php endif;?>
</div>
