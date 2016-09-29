<?php
/**
 * @var \pay\models\Order $order
 * @var \pay\models\OrderJuridicalTemplate $template
 * @var array $billData
 * @var int $total
 * @var int $nds
 * @var bool $withSign
 * @var \application\components\controllers\BaseController $this
 */
?>

<?$this->renderPartial('pay.views.order.bills.base', [
  'order' => $order,
  'template' => $template,
  'billData' => $billData,
  'nds' => $nds,
  'total' => $total
])?>

<?if($withSign):?>
  <img src="/img/pay/bill/imh.jpg"/>
<?else:?>
  <table class="sign">
    <tr>
      <td>Руководитель предприятия</td>
      <td>__________________________</td>
      <td>(Гребенников С. В.)</td>
    </tr>
    <tr>
      <td>Главный бухгалтер</td>
      <td>__________________________</td>
      <td>(Гулина Н. А.)</td>
    </tr>
  </table>
<?endif?>

<p>Оплата данного счета-оферты (ст. 432 ГК РФ) свидетельствует о заключении с ООО «Интернет Медиа Холдинг» договора подписки в письменной форме (п.3 ст.434 и п.5 ст.438 ГК РФ).<br>
  Накладные и счета-фактуры оформляются одновременно с выпуском журнала.</p>
