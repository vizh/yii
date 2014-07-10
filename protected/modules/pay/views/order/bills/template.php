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
]);?>

<?if (!empty($template->OfferText)):?>
<h4 class="offer-title">Публичная оферта на оказание услуг</h4>
<div class="offer">
    <?=$template->OfferText;?>
</div>
<?endif;?>

<div style="margin-top: 100px;">
  <?if ($withSign):?>
    <div style="position: absolute; margin-left: <?=$template->SignFirstImageMargin[1];?>px; margin-top:<?=$template->SignFirstImageMargin[0];?>px">
      <?=\CHtml::image($template->getFirstSignImagePath());?>
    </div>
    <?if (!empty($template->SignSecondTitle) && !empty($template->SignSecondName)):?>
      <div style="position: absolute; margin-left: <?=$template->SignSecondImageMargin[1];?>px; margin-top:<?=$template->SignSecondImageMargin[0];?>px">
        <?=\CHtml::image($template->getSecondSignImagePath());?>
      </div>
    <?endif;?>
    <div style="position: absolute; margin-left: <?=$template->StampImageMargin[1];?>px; margin-top:<?=$template->StampImageMargin[0];?>px">
      <?=\CHtml::image($template->getStampImagePath());?>
    </div>
  <?endif;?>

  <table style="width: 720px; position: absolute; border:0;" cellspacing="0" cellpadding="3">
    <tr>
      <td style="width: 1px; overflow: visible;white-space:nowrap;"><?=$template->SignFirstTitle;?></td>
      <td style="border-bottom: 1px solid #000;"></td>
      <td style="width: 1px; overflow: visible;white-space:nowrap;">(<?=$template->SignFirstName;?>)</td>
    </tr>
    <?if (!empty($template->SignSecondTitle) && !empty($template->SignSecondName)):?>
      <tr><td style="height: 20px;" colspan="3"></td></tr>
      <tr>
        <td style="width: 1px; overflow: visible;white-space:nowrap;"><?=$template->SignSecondTitle;?></td>
        <td style="border-bottom: 1px solid #000; padding: 0 10px;"></td>
        <td style="width: 1px; overflow: visible;white-space:nowrap;">(<?=$template->SignSecondName;?>)</td>
      </tr>
    <?endif;?>
  </table>
</div>

<br>
<br>
<br>
<br>

