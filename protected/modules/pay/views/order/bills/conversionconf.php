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
  <td><b>Индивидуальный предприниматель Довжиков Алексей Андреевич</b><BR>Адрес: 194223, Санкт-Петербург, Пр. Тореза, д. 40 к. 2, кв. 58<BR>тел. +7 (965) 001-74-96</td>
</tr>
<tr>
  <td colspan="2">
    <P style="TEXT-ALIGN: center"><B>Образец заполнения платежного поручения</B></P>
    <table style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; WIDTH: 100%; BORDER-TOP: 1px solid; BORDER-RIGHT: 1px solid" cellSpacing="0" cellPadding="3">
      <tbody>
      <tr>
        <td style="BORDER-BOTTOM: 1px solid;" colSpan="4">ИНН 780214994920</td>
      </tr>
      <tr>
        <td style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"	colSpan=2>Получатель<BR>Индивидуальный предприниматель Довжиков Алексей Андреевич</td>
        <td	style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"><BR>Сч.	№</td>

        <td style="BORDER-BOTTOM: 1px solid"><BR>40802810302100008190</td></tr>
      <tr>
        <td style="BORDER-RIGHT: 1px solid" colSpan=2>Банк получателя<BR>ОАО АКБ «АВАНГАРД»</td>
        <td style="BORDER-RIGHT: 1px solid">БИК<BR>Сч. №</td>
        <td>044525201<BR>30101810000000000201</td>

      </tr>
      </tbody>
    </table>
  </td>
</tr>
<tr>
  <td style="TEXT-ALIGN: center" colspan="2">
    <div style="MARGIN-TOP: 20px; FONT-SIZE: 24px"><B>CЧЕТ № <?=$order->Id;?> от <?=date('d.m.Y', strtotime($order->CreationTime));?></B></div>

    (Счет действителен в течение 5-и банковских дней)
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

      <?
      $i = 1;
      foreach ($billData as $data):
        ?>
        <tr>
          <td style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"><?=$i;?></td>
          <td style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"><?=$data['Title'];?></td>
          <td style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: center; BORDER-RIGHT: 1px solid"><?=$data['Unit'];?></td>
          <td style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: center; BORDER-RIGHT: 1px solid"><?=$data['Count'];?></td>
          <td style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: center; BORDER-RIGHT: 1px solid" nowrap="nowrap"><?=number_format(round($data['DiscountPrice'] / 1.18, 2, PHP_ROUND_HALF_UP), 2, ',', ' ');?></td>

          <td style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: right" nowrap="nowrap"><?=number_format(round($data['DiscountPrice'] * $data['Count'] / 1.18, 2, PHP_ROUND_HALF_UP), 2, ',', ' ');?></td>
        </tr>
        <?
        $i++;
      endforeach;?>

      <tr>
        <td style="TEXT-ALIGN: right; FONT-WEIGHT: bold; BORDER-RIGHT: 1px solid" colSpan="4">Итого:<br/><i>НДС не облагается</i></td>
        <td style="TEXT-ALIGN: right; FONT-WEIGHT: bold" colspan="2"><?=number_format($total, 2, ',', ' ');?></td>

      </tr>
      </tbody>
    </table>
  </td>
</tr>
<tr>
  <td colspan="2">
    Всего на сумму <?=number_format($total, 0, ',', ' ');?> руб. 00 коп.
    <div><span><?=Texts::mb_ucfirst(mb_strtolower(Texts::NumberToText($total, true)));?></span> рублей 00 копеек</div><BR><BR>

  </td>
</tr>
<?if ($withSign):?>
      <TR>
        <TD colspan="2">
          <IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-TOP: medium none; BORDER-RIGHT: medium none;"
               src="/img/pay/bill/conversionconf/sign.jpg"
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
               src="/img/pay/bill/conversionconf/nosign.jpg"
              />
        </td>
      </tr>
    <?endif;?>
</tbody>
</table>
</div>
</body>
</html>

 
