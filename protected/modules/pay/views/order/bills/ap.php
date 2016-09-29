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
  <img src="/img/pay/bill/ap/sign.jpg"/>
<?else:?>
  <table class="sign">
    <tr>
      <td>Руководитель предприятия</td>
      <td>__________________________</td>
      <td>(Аникина М.П.)</td>
    </tr>
    <tr>
      <td>Главный бухгалтер</td>
      <td>__________________________</td>
      <td>(Морозова Е.В.)</td>
    </tr>
  </table>
<?endif?>