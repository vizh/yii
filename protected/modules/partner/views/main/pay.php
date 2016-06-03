<?php
/**
 * @var \partner\controllers\main\PayStatistics $statistics
 * @var \partner\controllers\main\PayStatistics $oldStatistics
 * @var array $productStatistics
 * @var \partner\components\Controller $this
 */

$this->setPageTitle(\Yii::t('app', 'Статистика платежей'));
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-bar-chart"></i> <?=\Yii::t('app', 'Всего зарегистрировано');?>: <strong><?=$statistics->countParticipants;?></strong></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="table-info">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td class="span2">&nbsp;</td>
                        <td class="span3">
                            <h4>Юридические лица (счета)</h4>
                        </td>
                        <td class="span3">
                            <h4>Физические лица (квитанции)</h4>
                        </td>
                        <td class="span3">
                            <h4>Физические лица (онлайн)</h4>
                        </td>
                        <td class="span1"><h4>Итого</h4></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Выставлено:</td>
                        <td><?=$statistics->countJuridicalOrders;?></td>
                        <td><?=$statistics->countReceipts;?></td>
                        <td><?=$statistics->countPaySystemOrders;?></td>
                        <td><?=$statistics->getTotalOrders();?></td>
                    </tr>
                    <tr>
                        <td>Не оплачено:</td>
                        <td><span class="text-warning"><?=$statistics->countJuridicalOrders-$statistics->countPaidJuridicalOrders;?></span></td>
                        <td><span class="text-warning"><?=$statistics->countReceipts-$statistics->countPaidReceipts;?></span></td>
                        <td><span class="text-warning"><?=$statistics->countPaySystemOrders-$statistics->countPaidPaySystemOrders;?></span></td>
                        <td><span class="text-warning"><?=$statistics->getTotalOrders() - $statistics->getTotalPaidOrders();?></span></td>
                    </tr>
                    <tr>
                        <td>Оплачено:</td>
                        <td><strong class="text-success"><?=$statistics->countPaidJuridicalOrders;?></strong></td>
                        <td><strong class="text-success"><?=$statistics->countPaidReceipts;?></strong></td>
                        <td><strong class="text-success"><?=$statistics->countPaidPaySystemOrders;?></strong></td>
                        <td><strong class="text-success"><?=$statistics->getTotalPaidOrders();?></strong></td>
                    </tr>
                    <tr>
                        <td>Людей включено:</td>
                        <td><?=$statistics->countJuridicalUsers;?></td>
                        <td><?=$statistics->countReceiptUsers;?></td>
                        <td><?=$statistics->countPaySystemUsers;?></td>
                        <td><?=$statistics->totalUsers;?></td>
                    </tr>
                    <tr>
                        <td>Людей оплачено:</td>
                        <td><strong class="text-success"><?=$statistics->countPaidJuridicalUsers;?></strong></td>
                        <td><strong class="text-success"><?=$statistics->countPaidReceiptUsers;?></strong></td>
                        <td><strong class="text-success"><?=$statistics->countPaidPaySystemUsers;?></strong></td>
                        <td><strong class="text-success"><?=$statistics->totalPaidUsers;?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-left">Активировано 100% промо-кодов:</td>
                        <td><?=$statistics->totalPromoUsers;?></td>
                    </tr>
                    <tr>
                        <td>Сумма оплат:</td>
                        <td>
                            <span class="text-success lead"><?=number_format($statistics->totalPaidJuridical, 0, ',', ' ');?> руб.</span>
                        </td>
                        <td>
                            <span class="text-success lead"><?=number_format($statistics->totalPaidReceipt, 0, ',', ' ');?> руб.</span>
                        </td>
                        <td>
                            <span class="text-success lead"><?=number_format($statistics->totalPaySystem, 0, ',', ' ');?> руб.</span>
                        </td>
                        <td>
                            <span class="text-success lead"><?=number_format($statistics->getTotal(), 0, ',', ' ');?> руб.
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr/>

            <p>
                <strong>Количество запросивших счет/квитанцию:</strong>
                <span class="label label-success"><?=$statistics->countJuridicalUsers + $statistics->countReceiptUsers - $statistics->countPaidJuridicalUsers - $statistics->countPaidReceiptUsers;?></span>
            </p>

            <p>
                <strong>Общая сумма: </strong>
                <span class="label label-success"><?= $statistics->totalJuridical + $statistics->totalReceipt; ?></span>
            </p>

            <p>
                <strong>Оплачено: </strong>
                <span class="label label-success"><?= $statistics->totalPaidJuridical + $statistics->totalPaidReceipt; ?></span>
            </p>

            <p>
                <strong>Не оплачено: </strong>
                <span class="label label-success">
                    <?= $statistics->totalJuridical - $statistics->totalPaidJuridical + $statistics->totalReceipt - $statistics->totalPaidReceipt; ?>
                </span>
            </p>
        </div>
    </div> <!-- / .panel-body -->
</div>

<div class="panel panel-warning">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-bar-chart"></i> Статистика проданных товаров</span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="table-warning">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Оплачено</th>
                    <th>100% промо-код</th>
                    <th>Сумма оплат</th>
                </tr>
                </thead>
                <tbody>
                <?foreach ($productStatistics as $row):?>
                    <tr>
                        <td><?=$row['id'];?></td>
                        <td><?=$row['title'];?></td>
                        <td><?=$row['paid'];?></td>
                        <td><?=$row['coupon'];?></td>
                        <td><?=number_format($row['total'], 0, ',', ' ')?> руб.</td>
                    </tr>
                <?endforeach;?>
                </tbody>
            </table>
        </div>
    </div> <!-- / .panel-body -->
</div>