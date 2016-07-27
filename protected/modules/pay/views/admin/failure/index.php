<?php
/**
 * @var array $report
 * @var \pay\components\Controller $this
 */

$this->setPageTitle(\Yii::t('app', 'Список неудачных попыток оплаты заказа'));
?>

<div class="row-fluid">

    <div class="btn-toolbar clearfix">
        <?= CHtml::beginForm(['index'], 'get', ['enctype' => 'multipart/form-data']); ?>
        <?= CHtml::endForm(); ?>
    </div>

    <div class="well">
        <table class="table">
            <thead>
            <tr>
                <th><?= Yii::t('app', 'Заказ №'); ?></th>
                <th><?= Yii::t('app', 'Дата'); ?></th>
                <th><?= Yii::t('app', 'Событие'); ?></th>
                <th><?= Yii::t('app', 'Сумма'); ?></th>
                <th><?= Yii::t('app', 'ФИО'); ?></th>
                <th><?= Yii::t('app', 'Телефон'); ?></th>
                <th><?= Yii::t('app', 'Email'); ?></th>
                <th><?= Yii::t('app', 'Описание ошибки'); ?></th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($report as $row): ?>
                <tr>
                    <td><?= !empty($row['OrderId']) ? CHtml::link($row['OrderId'], $this->createUrl('/pay/admin/order/view', ['orderId'=>$row['OrderId']]), ['target'=>'_blank']) : null?></td>
                    <td><?= Yii::app()->getDateFormatter()->format('dd MMMM yyyy, HH:mm', $row['CreationTime']); ?></td>
                    <td><?= CHtml::link($row['EventName'], $this->createUrl('/event/admin/edit/index', ['eventId'=>$row['EventId']]), ['target'=>'_blank']) ?></td>
                    <td><?= number_format((float)$row['Total'], 2, '.', ' ') ?></td>
                    <td><?= $row['FIO'] ?></td>
                    <td><?= $row['Phone'] ?></td>
                    <td><?= $row['Email'] ?></td>
                    <td><?= $row['Message'] ?></td>
                </tr>
            <? endforeach; ?>
            </tbody>
        </table>
    </div>

</div>