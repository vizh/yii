<?php

/**
 * @var $import \pay\models\Import
 * @var $this \pay\components\Controller
 */

use application\components\helpers\ArrayHelper;

$this->setPageTitle(Yii::t('app', 'Импорт выписки из банка'));

?>

<div class="row-fluid">
    <div class="well">
        <table class="table">
            <thead>
            <tr>
                <th>Дата поступления</th>
                <th>ИНН плательщика</th>
                <th>Наименование плательщика</th>
                <th>Сумма платежа</th>
                <th>Детали</th>
            </tr>
            </thead>
            <tbody>
            <?foreach ($import->entries as $entry):?>
                <tr id="entry-<?=$entry->Id?>" class="info">
                    <td><?=ArrayHelper::getValue($entry, 'Data.Дата')?></td>
                    <td><?=ArrayHelper::getValue($entry, 'Data.ПлательщикИНН')?></td>
                    <td><?=ArrayHelper::getValue($entry, 'Data.Плательщик')?></td>
                    <td><?=ArrayHelper::getValue($entry, 'Data.Сумма')?></td>
                    <td>
                        <?php
                        $this->beginWidget('\application\widgets\bootstrap\Modal', [
                            'header' => 'Детали платежа',
                            'toggleButton' => ['label' => '<i class="icon-search"></i>', 'class' => 'btn btn-default']
                        ]);
                        $this->renderPartial('modal', ['entry' => $entry]);
                        $this->endWidget();
                        ?>
                    </td>
                </tr>
                <tr id="entry-detail-<?= $entry->Id ?>" class="info">
                    <td colspan="5"><?= ArrayHelper::getValue($entry, 'Data.НазначениеПлатежа') ?></td>
                </tr>
                <tr id="entry-orders-<?= $entry->Id ?>">
                    <td colspan="5">
                        <?if(false === empty($entry->orders)):?>
                            <table class="table table-bordered table-condensed">
                                <thead>
                                <tr>
                                    <th>Номер счета</th>
                                    <th>Дата выставления счета</th>
                                    <th>ИНН плательщика</th>
                                    <th>Наименование плательщик</th>
                                    <th>Сумма счета</th>
                                    <th>Статус</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?foreach ($entry->orders as $order):?>
                                    <?$this->renderPartial('order', ['order' => $order])?>
                                <?endforeach?>
                                </tbody>
                            </table>
                        <?endif?>
                    </td>
                </tr>
            <?endforeach?>
            </tbody>
        </table>
    </div>
</div>