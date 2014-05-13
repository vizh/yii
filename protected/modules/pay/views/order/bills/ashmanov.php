<?php
use application\components\utility\Texts;

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
<table>
  <tr>
    <td>
      <div style="float: left; margin-right: 30px;"><img src="/img/pay/bill/ashmanov/logo.png" style="height: 110px;"/></div>
      123022, Москва, ул. 2-я Звенигородская,<br/>
      д.13, стр.43, 2 этаж<br/>
      Т: +7 (495) 258-28-10<br/>
      Е: info@ashmanov.com<br/>
      <a href="http://www.ashmanov.com">www.ashmanov.com</a><br/>
      <strong>Юридический адрес: 117463, г. Москва, ул. Паустовского д.3, кв. 553</strong>
    </td>
  </tr>
</table>

<h4>Образец заполнения платежного поручения</h4>
<table class="payment-info">
  <tbody>
  <tr>
    <td>ИНН <?=$template->INN;?></td>
    <td>КПП <?=$template->KPP;?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td	colSpan=2>Получатель<br><?=$template->Recipient;?></td>
    <td><br>Сч.	№</td>
    <td><br><?=$template->AccountNumber;?></td></tr>
  <tr>
    <td colspan=2>Банк получателя<br><?=$template->Bank;?></td>
    <td>БИК<br>Сч. №</td>
    <td><?=$template->BIK;?><br><?=$template->BankAccountNumber;?></td>
  </tr>
  </tbody>
</table>

<h2>
  Cчет № <?=$order->Number;?> от <?=date('d.m.Y', strtotime($order->CreationTime));?><br>
  <span>(Счет действителен в течение 5-и банковских дней)</span>
</h2>

<p style="text-align: center; font-size: 10px; margin-bottom: 35px;">
  Наличие в платежно-расчетном документе ссылки на номер выставленного счета обязательно!<br/>
  Денежные средства в оплату счета должны поступить на расчетный счет ЗАО «Ашманов и партнеры» <strong>не позднее 5 (пяти) банковских дней</strong> с даты выставления счета.<br/>
  Денежные средства возвращаются в 60 (шестидесяти) дневный срок на расчетный счет Плательщика, на основании официального письма направленного в адрес ЗАО «Ашманов и партнеры».<br/>
  Убедительно просим Вас заблаговременно связаться с нами по тел. (495) 258-28-10, в случае задержки оплаты счета.
</p>

<p>
  <strong>Заказчик:</strong> <?=$order->OrderJuridical->Name;?>,
  <strong>ИНН / КПП:</strong> <?=$order->OrderJuridical->INN;?>/<?=$order->OrderJuridical->KPP;?><br>
  <strong>Плательщик:</strong> <?=$order->OrderJuridical->Name;?><br>
  <strong>Адрес:</strong> <?=$order->OrderJuridical->Address;?>
</p>

<table class="orderitems">
  <thead>
  <tr>
    <th>№</th>
    <th>Наименование товара (услуги)</th>
    <th>Единица<br>измерения</th>
    <th>Кол-во</th>
    <th>Цена,<br>руб.</th>
    <th>Сумма,<br>руб.</th>
  </tr>
  </thead>
  <tbody>

  <tr>
    <td>1</td>
    <td>Участие в конференции "Internet Business Conference (IBC Russia 2014)" 27-28 ноября 2014 г.</td>
    <td class="center">-</td>
    <td class="center">1</td>
    <td class="center nowrap"><?=number_format(round($total, 2, PHP_ROUND_HALF_UP), 2, ',', ' ');?></td>
    <td class="right nowrap"><?=number_format(round($total, 2, PHP_ROUND_HALF_UP), 2, ',', ' ');?></td>
  </tr>

  <tr>
    <td class="right" colspan="4">
      <strong>Итого:</strong><br>
      <strong>Итого НДС:</strong><br>
      <strong>Всего к оплате (c учетом НДС):</strong>
    </td>
    <td class="right" colspan="2">
      <?=number_format($total - $nds, 2, ',', ' ');?><br>
      <?=number_format($nds, 2, ',', ' ');?><br>
      <?=number_format($total, 2, ',', ' ');?>
    </td>
  </tr>
  </tbody>
</table>

<p>
  Всего наименований 1, на сумму <?=number_format($total, 0, ',', ' ');?> руб. 00 коп.<br>
  <?=Texts::mb_ucfirst(mb_strtolower(Texts::NumberToText($total, true)));?> рублей 00 копеек
</p>


<?if ($withSign):?>
  <img src="/img/pay/bill/ashmanov/sign.jpg"/>
<?else:?>
  <img src="/img/pay/bill/ashmanov/nosign.jpg"/>
<?endif;?>