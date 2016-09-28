<?php
/**
 * @var $import \pay\models\Import
 * @var $this \pay\components\Controller
 */

$this->setPageTitle(\Yii::t('app', 'Импорт выписки из банка'));
?>

<div class="row-fluid">

    <div class="well">
        <table class="table">
            <thead>
            <tr>
                <th>Номер счета</th>
                <th>Дата поступления</th>
                <th>ИНН плательщика</th>
                <th>Наименование плательщика</th>
                <th>Сумма платежа</th>
                <th>Номер счета</th>
                <th>Дата выставления счета</th>
                <th>ИНН плательщика</th>
                <th>Наименование плательщик</th>
                <th>Сумма счета</th>
                <th>Статус</th>
            </tr>
            </thead>
            <tbody>
            <?foreach($import->orders as $order) {
                $this->renderPartial('row', ['order' => $order]);
            }?>
            </tbody>
        </table>
    </div>

</div>