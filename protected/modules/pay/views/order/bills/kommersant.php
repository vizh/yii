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
  <img src="/img/pay/bill/kommersant/sign.jpg"/>
<?else:?>
  <img src="/img/pay/bill/kommersant/nosign.jpg"/>
<?endif?>