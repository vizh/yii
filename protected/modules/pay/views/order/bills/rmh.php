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

<?$this->renderPartial('bills/base', [
  'order' => $order,
  'template' => $template,
  'billData' => $billData,
  'nds' => $nds,
  'total' => $total
]);?>

<h4>Публичная оферта на оказание услуг</h4>
<div class="offer">
  <?=$this->renderPartial('bills/offer/rmh');?>
</div>

<?if ($withSign):?>
  <img src="/img/pay/bill/rmh.jpg"/>
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
      <td>(Гребенников С. В.)</td>
    </tr>
  </table>
<?endif;?>
