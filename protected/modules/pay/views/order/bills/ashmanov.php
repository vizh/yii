<?php
use application\components\utility\Texts;

/**
 * @var $order \pay\models\Order
 * @var $billData array
 * @var $total int
 * @var $nds int
 * @var $withSign bool
 */
?>
<!doctype html public "-//W3C//DTD XHTML 1.1 Transitional//EN" "http://www.w3.org/tr/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang=ru xml:lang="ru" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Счёт № <?=$order->Id;?></title>
  <meta content="text/html; charset=UTF-8" http-equiv=Content-Type>
</head>
<body>
<div id=panel></div>
<div id=content>
<table cellSpacing="0" cellPadding="5" width="720" border="0">
<tbody>
<tr>
  <td>
    <div style="float: left; margin-right: 30px;"><IMG border="0" src="/img/pay/bill/ashmanov/logo.png" style="height: 110px;"/></div>
    123022, Москва, ул. 2-я Звенигородская,<br/>
    д.13, стр.43, 2 этаж<br/>
    Т: +7 (495) 258-28-10<br/>
    Е: info@ashmanov.com<br/>
    <a href="http://www.ashmanov.com">www.ashmanov.com</a><br/>
    <strong>Юридический адрес: 117463, г. Москва, ул. Паустовского д.3, кв. 553</strong>
  </td>
</tr>
<tr>
  <td colspan="2">
    <P style="TEXT-ALIGN: center"><B>Образец заполнения платежного поручения</B></P>
    <table style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; WIDTH: 100%; BORDER-TOP: 1px solid; BORDER-RIGHT: 1px solid" cellSpacing="0" cellPadding="3">
      <tbody>
      <tr>
        <td style="BORDER-BOTTOM: 1px solid;" colSpan="4">ИНН 7728240040 КПП 772801001</td>
      </tr>
      <tr>
        <td style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"	colSpan=2>Получатель ЗАО «Ашманов и партнеры»</td>
        <td	style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"><BR>Сч.	№</td>

        <td style="BORDER-BOTTOM: 1px solid"><BR>40702810000005271001</td></tr>
      <tr>
        <td style="BORDER-RIGHT: 1px solid" colSpan=2>Банк получателя<BR>ООО КБ "НЭКЛИС-БАНК" Г.МОСКВА</td>
        <td style="BORDER-RIGHT: 1px solid">БИК<BR>Сч. №</td>
        <td>044583679<BR>30101810700000000679</td>

      </tr>
      </tbody>
    </table>
  </td>
</tr>
<tr>
  <td style="TEXT-ALIGN: center" colspan="2">
    <div style="MARGIN-TOP: 20px; FONT-SIZE: 24px"><B>CЧЕТ № <?=$order->Id;?> от <?=date('d.m.Y', strtotime($order->CreationTime));?></B></div>
    <div style="FONT-SIZE: 16px; MARGIN-TOP: 20px;">(Счет действителен в течение 5-и банковских дней)</div>
    <div style="MARGIN-TOP: 20px; FONT-SIZE: 12px; margin-bottom: 20px;">
      Наличие в платежно-расчетном документе ссылки на номер выставленного счета обязательно!<br/>
      Денежные средства в оплату счета должны поступить на расчетный счет ЗАО «Ашманов и партнеры» <strong>не позднее 5 (пяти) банковских дней</strong> с даты выставления счета.<br/>
      Денежные средства возвращаются в 60 (шестидесяти) дневный срок на расчетный счет Плательщика, на основании официального письма направленного в адрес ЗАО «Ашманов и партнеры».<br/>
      Убедительно просим Вас заблаговременно связаться с нами по тел. (495) 258-28-10, в случае задержки оплаты счета.<br/>
    </div>
  </td>
</tr>
<tr>
  <td colspan="2">Заказчик: <?=$order->OrderJuridical->Name;?>,
    ИНН / КПП: <?=$order->OrderJuridical->INN;?>/<?=$order->OrderJuridical->KPP;?><BR>
    Плательщик: <?=$order->OrderJuridical->Name;?><BR>
    Адрес: <?=$order->OrderJuridical->Address;?>		</td>
</tr>

<tr>
  <td colspan="2">
    <table style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; WIDTH: 100%; BORDER-TOP: 1px solid; BORDER-RIGHT: 1px solid" cellSpacing=0 cellPadding=3>
      <tbody>
      <tr style="TEXT-ALIGN: center">
        <td style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">№</td>
        <td	style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">Наименование<BR>товара (услуги)</td>

        <td style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">Единица<BR>измерения</td>
        <td style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">Кол-во</td>
        <td style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">Цена,<br />руб.</td>
        <td style="BORDER-BOTTOM: 1px solid">Сумма,<BR>руб.</td>
      </tr>
        
        
      <tr>
        <td style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">1</td>
        <td style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">Услуги по участию в конференции "IBC Russia 2013", 5-6 декабря 2013 года</td>
        <td style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: center; BORDER-RIGHT: 1px solid">-</td>
        <td style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: center; BORDER-RIGHT: 1px solid">1</td>
        <td style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: center; BORDER-RIGHT: 1px solid" nowrap="nowrap"><?=number_format(round($total, 2, PHP_ROUND_HALF_UP), 2, ',', ' ');?></td>
        <td style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: right" nowrap="nowrap"><?=number_format(round($total, 2, PHP_ROUND_HALF_UP), 2, ',', ' ');?></td>
      </tr>  
     
      <TR>
        <TD style="TEXT-ALIGN: right; FONT-WEIGHT: bold; BORDER-RIGHT: 1px solid" colSpan="4">Итого:<BR>Итого НДС:<BR>Всего к оплате (c учетом НДС):</TD>
        <TD style="TEXT-ALIGN: right; FONT-WEIGHT: bold" colspan="2"><?=number_format($total - $nds, 2, ',', ' ');?><BR><?=number_format($nds, 2, ',', ' ');?><BR><?=number_format($total, 2, ',', ' ');?></TD>
      </TR>
      </tbody>
    </table>
  </td>
</tr>
<tr>
  <td colspan="2">
    Всего наименований 1, на сумму <?=number_format($total, 0, ',', ' ');?> руб. 00 коп.
    <div><span><?=Texts::mb_ucfirst(mb_strtolower(Texts::NumberToText($total, true)));?></span> рублей 00 копеек</div><BR><BR>

  </td>
</tr>
<?if ($withSign):?>
  <TR>
    <TD colspan="2">
      <IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-TOP: medium none; BORDER-RIGHT: medium none;"
           src="/img/pay/bill/ashmanov/sign.jpg"
          />
    </TD>
  </TR>
<?else:?>
  <tr>
    <td colspan="2" style="border-top: 4px solid #000000;"></td>
  </tr>
  <tr>
    <td colspan="2">
      <IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-TOP: medium none; BORDER-RIGHT: medium none;"
           src="/img/pay/bill/ashmanov/nosign.jpg"
          />
    </td>
  </tr>
<?endif;?>
</tbody>
</table>
</div>
</body>
</html>

 
