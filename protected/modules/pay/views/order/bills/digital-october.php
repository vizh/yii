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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML lang=ru xml:lang="ru" xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
  <TITLE>Счёт № <?=$order->Number?></TITLE>
  <META content="text/html; charset=UTF-8" http-equiv=Content-Type>
</HEAD>
<BODY>
<DIV id=panel></DIV>
<DIV id=content>
  <TABLE cellSpacing="0" cellPadding="5" width="720" border="0">
    <TBODY>
    <TR>
      <TD><b>ООО «Цифровой Октябрь»</b><BR>Адрес: Российская Федерация, 119072, Москва, Берсеневская набережная, дом 6, строение 3<BR>тел. 7 (495) 988-33-56</TD>
      <td align="right"><img src="/images/bill/rocid.png" width="129" height="48"></td>

    </tr>
    <TR>
      <TD colspan="2">
        <P style="TEXT-ALIGN: center"><B>Образец заполнения платежного поручения</B></P>
        <TABLE style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; WIDTH: 100%; BORDER-TOP: 1px solid; BORDER-RIGHT: 1px solid" cellSpacing="0" cellPadding="3">
          <TBODY>
          <TR>
            <TD style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">ИНН 7706751562</TD>

            <TD style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">КПП 770601001</TD>
            <TD style="BORDER-BOTTOM: 1px solid">&nbsp;</TD>
            <TD style="BORDER-BOTTOM: 1px solid">&nbsp;</TD>
          </TR>
          <TR>
            <TD style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"	colSpan=2>Получатель<BR>ООО «Цифровой Октябрь»</TD>
            <TD	style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"><BR>Сч.&nbsp;№</TD>

            <TD style="BORDER-BOTTOM: 1px solid"><BR>40702810600000008430</TD></TR>
          <TR>
            <TD style="BORDER-RIGHT: 1px solid" colSpan=2>Банк получателя<BR>ОАО КБ «МАСТ-Банк» г.Москва</TD>
            <TD style="BORDER-RIGHT: 1px solid">БИК<BR>Сч.&nbsp;№</TD>
            <TD>044579797<BR>30101810300000000797 в Отделении 4 Московского ГТУ Банка России</TD>

          </TR>
          </TBODY>
        </TABLE>
      </TD>
    </TR>
    <TR>
      <TD style="TEXT-ALIGN: center" colspan="2">
        <DIV style="MARGIN-TOP: 20px; FONT-SIZE: 24px"><B>СЧЕТ № <?=$order->Number?> от <?=date('d.m.Y', strtotime($order->CreationTime))?></B></DIV>

        (Счет действителен в течение 5-и банковских дней)
      </TD>
    </TR>
    <TR>
      <TD colspan="2">Заказчик: <?=$order->OrderJuridical->Name?>,
        ИНН / КПП: <?=$order->OrderJuridical->INN?>/<?=$order->OrderJuridical->KPP?><BR>
        Плательщик: <?=$order->OrderJuridical->Name?><BR>
        Адрес: <?=$order->OrderJuridical->Address?>		</TD>
    </TR>

    <TR>
      <TD colspan="2">
        <TABLE style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; WIDTH: 100%; BORDER-TOP: 1px solid; BORDER-RIGHT: 1px solid" cellSpacing=0 cellPadding=3>
          <TBODY>
          <TR style="TEXT-ALIGN: center">
            <TD style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">№</TD>
            <TD	style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">Наименование<BR>товара (услуги)</TD>

            <TD style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">Единица<BR>измерения</TD>
            <TD style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">Кол-во</TD>
            <TD style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">Цена,<br />руб.</TD>
            <TD style="BORDER-BOTTOM: 1px solid">Сумма,<BR>руб.</TD>
          </TR>

          <?
          $i = 1;
          foreach ($billData as $data):
           ?>
            <TR>
              <TD style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"><?=$i?></TD>
              <TD style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"><?=$data['Title']?></TD>
              <TD style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: center; BORDER-RIGHT: 1px solid"><?=$data['Unit']?></TD>
              <TD style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: center; BORDER-RIGHT: 1px solid"><?=$data['Count']?></TD>
              <TD style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: center; BORDER-RIGHT: 1px solid" nowrap="nowrap"><?=number_format(round($data['DiscountPrice'] / 1.18, 2, PHP_ROUND_HALF_UP), 2, ',', ' ')?></TD>

              <TD style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: right" nowrap="nowrap"><?=number_format(round($data['DiscountPrice'] * $data['Count'] / 1.18, 2, PHP_ROUND_HALF_UP), 2, ',', ' ')?></TD>
            </TR>
            <?
            $i++;
          endforeach?>

          <TR>
            <TD style="TEXT-ALIGN: right; FONT-WEIGHT: bold; BORDER-RIGHT: 1px solid" colSpan="4">Итого:<BR>Итого НДС:<BR>Всего к оплате (c учетом НДС):</TD>
            <TD style="TEXT-ALIGN: right; FONT-WEIGHT: bold" colspan="2"><?=number_format($total - $nds, 2, ',', ' ')?><BR><?=number_format($nds, 2, ',', ' ')?><BR><?=number_format($total, 2, ',', ' ')?></TD>

          </TR>
          </TBODY>
        </TABLE>
      </TD>
    </TR>
    <TR>
      <TD colspan="2">
        Всего на сумму <?=number_format($total, 0, ',', ' ')?> руб. 00 коп.
        <DIV><span><?=Texts::mb_ucfirst(mb_strtolower(Texts::NumberToText($total, true)))?></span> рублей 00 копеек</DIV><BR><BR>

      </TD>
    </TR>
    <?if($withSign):?>
      <TR>
        <TD colspan="2">
          <IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-TOP: medium none; BORDER-RIGHT: medium none; width: 720px;"
               src="/img/pay/bill/digital-october/bill_withsign.png"
              />
        </TD>
      </TR>
    <?else:?>
      <tr>
        <td colspan="2" style="border-top: 4px solid #000000;"></td>
      </tr>
      <tr>
        <td colspan="2">
          <table style="width: 100%; font-family: Arial; padding-top: 10px;">
            <tr>
              <td width="10%">Руководитель</td>
              <td width="40%" style="padding-right: 10px; border-bottom: 2px solid #000000; font-size: 80%; font-weight: bold; text-align: right;">Репин Д.В.</td>
              <td width="10%" style="padding-left: 20px;">Бухгалтер</td>
              <td width="40%" style="padding-right: 10px; border-bottom: 2px solid #000000; font-size: 80%; font-weight: bold; text-align: right;">Репин Д.В.</td>
            </tr>
          </table>
        </td>
      </tr>
    <?endif?>
    </TBODY>
  </TABLE></DIV></BODY></HTML>