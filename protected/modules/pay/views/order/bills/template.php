<?php
use application\components\utility\Texts;

/**
 * @var $order \pay\models\Order
 * @var $billData array
 * @var $total int
 * @var $nds int
 * @var $withSign bool
 * @var $template \pay\models\OrderJuridicalTemplate
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
  <td><b><?=$template->Recipient;?></b><BR>Адрес: <?=$template->Address;?><br/>Тел.: <?=$template->Phone;?><?if (!empty($template->Fax)):?><br/>Факс.: <?=$template->Fax;?><?endif;?></td>
</tr>
<tr>
  <td colspan="2">
    <P style="TEXT-ALIGN: center"><B>Образец заполнения платежного поручения</B></P>
    <table style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; WIDTH: 100%; BORDER-TOP: 1px solid; BORDER-RIGHT: 1px solid" cellSpacing="0" cellPadding="3">
      <tbody>
      <tr>
        <td style="BORDER-BOTTOM: 1px solid;">ИНН <?=$template->INN;?></td>
        <?if (!empty($template->KPP)):?>
          <TD style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">КПП <?=$template->KPP;?></TD>
        <?else:?>
          <TD style="BORDER-BOTTOM: 1px solid">&nbsp;</TD>
        <?endif;?>
        <TD style="BORDER-BOTTOM: 1px solid">&nbsp;</TD>
        <TD style="BORDER-BOTTOM: 1px solid">&nbsp;</TD>
      </tr>
      <tr>
        <td style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"	colSpan=2>Получатель<BR><?=$template->Recipient;?></td>
        <td	style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"><BR>Сч.	№</td>

        <td style="BORDER-BOTTOM: 1px solid"><BR><?=$template->AccountNumber;?></td></tr>
      <tr>
        <td style="BORDER-RIGHT: 1px solid" colSpan=2>Банк получателя<BR><?=$template->Bank;?></td>
        <td style="BORDER-RIGHT: 1px solid">БИК<BR>Сч. №</td>
        <td><?=$template->BIK;?><BR><?=$template->BankAccountNumber;?></td>

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
          <td style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: center; BORDER-RIGHT: 1px solid" nowrap="nowrap"><?=number_format(round($data['DiscountPrice'], 2, PHP_ROUND_HALF_UP), 2, ',', ' ');?></td>

          <td style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: right" nowrap="nowrap"><?=number_format(round($data['DiscountPrice'] * $data['Count'], 2, PHP_ROUND_HALF_UP), 2, ',', ' ');?></td>
        </tr>
        <?
        $i++;
      endforeach;?>

      <?if ($template->VAT):?>
      <TR>
        <TD style="TEXT-ALIGN: right; FONT-WEIGHT: bold; BORDER-RIGHT: 1px solid" colSpan="4">Итого:<BR>Итого НДС:<BR>Всего к оплате (c учетом НДС):</TD>
        <TD style="TEXT-ALIGN: right; FONT-WEIGHT: bold" colspan="2"><?=number_format($total - $nds, 2, ',', ' ');?><BR><?=number_format($nds, 2, ',', ' ');?><BR><?=number_format($total, 2, ',', ' ');?></TD>
      </TR>
      <?else:?>
      <tr>
        <td style="TEXT-ALIGN: right; FONT-WEIGHT: bold; BORDER-RIGHT: 1px solid" colSpan="4">Итого:<br/><i>НДС не облагается</i></td>
        <td style="TEXT-ALIGN: right; FONT-WEIGHT: bold" colspan="2"><?=number_format($total, 2, ',', ' ');?></td>
      </tr>
      <?endif;?>
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
  
  
  <tr>
    <td colspan="2">
      <div>
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
        
        <table style="width: 100%; border:0;" cellspacing="0" cellpadding="3">
          <tr>
            <td style="width: 1px; overflow: visible;white-space:nowrap;"><?=$template->SignFirstTitle;?></td>
            <td style="border-bottom: 1px solid #000;"></td>
            <td style="width: 1px; overflow: visible;white-space:nowrap;">(<?=$template->SignFirstName;?>)</td>
          </tr>
          <?if (!empty($template->SignSecondTitle) && !empty($template->SignSecondName)):?>
          <tr><td style="height: 10px;" colspan="3"></td></tr>
          <tr>
            <td style="width: 1px; overflow: visible;white-space:nowrap;"><?=$template->SignSecondTitle;?></td>
            <td style="border-bottom: 1px solid #000; padding: 0 10px;"></td>
            <td style="width: 1px; overflow: visible;white-space:nowrap;">(<?=$template->SignSecondName;?>)</td>
          </tr>
          <?endif;?>
        </table>
      </div>
      <br/><br/><br/><br/><br/>
    </td>
  </tr>
</tbody>
</table>
</div>
</body>
</html>

 
