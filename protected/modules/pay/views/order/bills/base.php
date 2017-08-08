<?php
use application\components\utility\Texts;

/**
 * @var \pay\models\Order $order
 * @var \pay\models\OrderJuridicalTemplate $template
 * @var array $billData
 * @var int $total
 * @var int $nds
 */

$vatMultiply = $template->VAT ? 1.18 : 1;
?>
<table>
  <tbody>
  <tr>
    <td>
      <strong><?=$template->Recipient?></strong><br>
      Адрес: <?=$template->Address?><br>
      тел. <?=$template->Phone?>
      <?if(!empty($template->Fax)):?><br/>Факс.: <?=$template->Fax?><?endif?>
    </td>
    <td class="logo">
      <img src="/images/logo-mid.png" width="219" height="20">
    </td>
  </tr>
  </tbody>
</table>

<h4>Образец заполнения платежного поручения</h4>
<table class="payment-info" style="border:1px solid #000">
  <tbody>
  <tr style="border:1px solid #000">
    <td <?=$template->KPP == null ? 'colspan="2"' : ''?> >ИНН <?=$template->INN?></td>
    <?if($template->KPP != null):?><td>КПП <?=$template->KPP?></td><?endif?>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr style="border:1px solid #000">
    <td	colSpan=2>Получатель<br><?=$template->Recipient?></td>
    <td><br>Сч.	№</td>
    <td><br><?=$template->AccountNumber?></td></tr>
  <tr>
    <td colspan=2>Банк получателя<br><?=$template->Bank?></td>
    <td>БИК<br>Сч. №</td>
    <td><?=$template->BIK?><br><?=$template->BankAccountNumber?></td>
  </tr>
  </tbody>
</table>

<h2>
  Cчет № <?=$order->Number?> от <?=date('d.m.Y', strtotime($order->CreationTime))?><br>
  <?if($template->ShowValidity):?>
    <span>(Счет действителен в течение <?=$template->ValidityDays?>-и банковских дней)</span>
  <?endif?>
</h2>

<p>
  <strong>Заказчик:</strong> <?=$order->OrderJuridical->Name?>,
  <strong>ИНН / КПП:</strong> <?=$order->OrderJuridical->INN?>/<?=$order->OrderJuridical->KPP?><br>
  <strong>Плательщик:</strong> <?=$order->OrderJuridical->Name?><br>
  <strong>Адрес:</strong> <?=$order->OrderJuridical->Address?>
</p>


<table class="orderitems"  style="border:1px solid #000">
  <thead>
  <tr style="border:1px solid #000">
    <th>№</th>
    <th>Наименование товара (услуги)</th>
    <th>Единица<br>измерения</th>
    <th>Кол-во</th>
    <th>Цена,<br>руб.</th>
    <th>Сумма,<br>руб.</th>
  </tr>
  </thead>
  <tbody>
  <?
  $i = 1;
  foreach ($billData as $data):
   ?>
    <tr style="border:1px solid #000">
      <td><?=$i?></td>
      <td><?=$data['Title']?></td>
      <td class="center"><?=$data['Unit']?></td>
      <td class="center"><?=$data['Count']?></td>
      <td class="center nowrap"><?=number_format(round($data['DiscountPrice'] / $vatMultiply, 2, PHP_ROUND_HALF_UP), 2, ',', ' ')?></td>

      <td class="right nowrap"><?=number_format(round($data['DiscountPrice'] * $data['Count'] / $vatMultiply, 2, PHP_ROUND_HALF_UP), 2, ',', ' ')?></td>
    </tr>
    <?
    $i++;
  endforeach?>

  <?if($template->VAT):?>
    <tr style="border:1px solid #000">
      <td class="right" colspan="4">
        <strong>Итого:</strong><br>
        <strong>Итого НДС:</strong><br>
        <strong>Всего к оплате (c учетом НДС):</strong>
      </td>
      <td class="right" colspan="2">
        <strong><?=number_format($total - $nds, 2, ',', ' ')?></strong><br>
        <strong><?=number_format($nds, 2, ',', ' ')?></strong><br>
        <strong><?=number_format($total, 2, ',', ' ')?></strong>
      </td>
    </tr>
  <?else:?>
    <tr style="border:1px solid #000">
      <td class="right" colspan="4">
        <strong>Итого:</strong><br>
        <strong><i>НДС не облагается</i></strong>
      </td>
      <td class="right" colspan="2">
        <strong><?=number_format($total, 2, ',', ' ')?></strong>
      </td>
    </tr>
  <?endif?>
  </tbody>
</table>

<p>
  Всего на сумму <?=number_format($total, 0, ',', ' ')?> руб. 00 коп.<br>
<?=Texts::mb_ucfirst(mb_strtolower(Texts::NumberToText($total, true)))?> рублей 00 копеек
</p>