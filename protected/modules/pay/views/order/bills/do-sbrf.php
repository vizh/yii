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
  <img src="/img/pay/bill/digital-october/bill_withsign.png"/>
<?else:?>
  <table class="sign">
    <tr>
      <td>Руководитель</td>
      <td>__________________________</td>
      <td>(Репин Д.В.)</td>
    </tr>
    <tr>
      <td>Бухгалтер</td>
      <td>__________________________</td>
      <td>(Репин Д.В.)</td>
    </tr>
  </table>
<?endif?>