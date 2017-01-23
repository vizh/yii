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

<?if(!empty($template->OfferText)):?>
  <h4 class="offer-title">Публичная оферта на оказание услуг</h4>
  <div class="offer">
    <?=$template->OfferText?>
  </div>
<?endif?>

<?if($withSign):?>
  <img src="/img/pay/bill/conversionconf/sign.jpg"/>
<?else:?>
  <img src="/img/pay/bill/conversionconf/nosign.jpg"/>
<?endif?>

