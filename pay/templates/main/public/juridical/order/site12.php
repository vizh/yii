<?
/** @var $orderJuridical OrderJuridical */
$orderJuridical = $this->OrderJuridical;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML lang=ru xml:lang="ru" xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
  <TITLE>Счёт № <?=$this->OrderId;?></TITLE>
  <META content="text/html; charset=UTF-8" http-equiv=Content-Type>
</HEAD>
<BODY>
<DIV id=panel></DIV>
<DIV id=content>
  <TABLE cellSpacing="0" cellPadding="5" width="720" border="0">
    <TBODY>
    <TR>
		<TD style="width: 68px; padding-right: 10px;"><img src="/images/bill/logo_site12.png" border="0" /></TD>
		<TD>Фактический и почтовый адрес: <br/>ЗАО "Ашманов и Партнеры"<br/> 123022, Москва, ул. 2-ая Звенигородская, д.13, стр. 43, 2 этаж<br/>Тел./факс +7 (495) 258-28-10<br/>Web: http://www.ashmanov.com<br/>E-mail: info@ashmanov.com</TD>
    </TR>
    <TR>
      <TD colspan="2">
		<P style="TEXT-ALIGN: center; margin-bottom: 30px;"><b>Юридический адрес: 117463, г. Москва, ул. Паустовского, д.3, кв. 553</b></P>
        <P style="TEXT-ALIGN: center"><B>Образец заполнения платежного поручения</B></P>
        <TABLE style="BORDER: 1px solid; WIDTH: 100%;" cellSpacing="0" cellPadding="3">
			<TBODY>
				<tr>
					<td style="BORDER-RIGHT: 1px solid; BORDER-BOTTOM: 1px solid;">ИНН 7728240040 &nbsp;&nbsp;&nbsp; КПП 772801001</td>
					<td style="BORDER-BOTTOM: 1px solid;">р/с 40702810800000000330</td>
				</tr>
				<tr>
					<td style="BORDER-RIGHT: 1px solid; BORDER-BOTTOM: 1px solid;">Получатель ЗАО "Ашманов и партнеры"</td>
					<td style="BORDER-BOTTOM: 1px solid;">БИК 044583893</td>
				</tr>
				<tr>
					<td style="BORDER-RIGHT: 1px solid; ">Банк получателя<br/> ЗАО КБ "КВОТА-БАНК" Г.МОСКВА</td>
					<td>к/c 30101810900000000893</td>
				</tr>
			</TBODY>
        </TABLE>
      </TD>
    </TR>
    <TR>
      <TD style="TEXT-ALIGN: center" colspan="2">
        <DIV style="MARGIN-TOP: 20px; FONT-SIZE: 20px"><strong>CЧЕТ № <?=$this->OrderId;?> от <?=date('d.m.Y', strtotime($this->CreationTime));?></strong></DIV>
      </TD>
    </TR>
	
	<TR>
		<TD colspan="2" style="font-size: 11px;">
			<DIV style="MARGIN-TOP: 20px; FONT-SIZE: 16px;"><strong>ВНИМАНИЕ! Счет действителен в течение 3-х банковских дней</strong></DIV>
			Наличие в платежно-расчетном документе ссылки на номер выставленного счета обязательно!<BR/>
			Денежные средства в оплату счета должны поступить на расчетный счет ЗАО «Ашманов и партнеры» <strong>не позднее 5 (пяти) банковских дней</strong> с даты выставления счета.<BR/>
			Денежные средства возвращаются в 60 (шестидесяти) дневный срок на расчетный счет Плательщика, на основании официального письма направленного в адрес ЗАО «Ашманов и партнеры».<BR/>
			Убедительно просим Вас заблаговременно связаться с нами по тел. (495) 258-28-10, в случае задержки оплаты счета.<BR/>
		</TD>
	</TR>
	
	
    <TR>
      <TD colspan="2">Заказчик: <?=$orderJuridical->Name;?> <br/>Плательщик: <?=$orderJuridical->Name;?></TD>
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
          foreach ($this->BillOrders as $billOrder):
            ?>
          <TR>
            <TD style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"><?=$i;?></TD>
            <TD style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"><?=$billOrder['Title'];?></TD>
            <TD style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: center; BORDER-RIGHT: 1px solid"><?=$billOrder['Unit'];?></TD>
            <TD style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: center; BORDER-RIGHT: 1px solid"><?=$billOrder['Count'];?></TD>
            <TD style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: center; BORDER-RIGHT: 1px solid" nowrap="nowrap"><?=number_format(round($billOrder['DiscountPrice'] / 1.18, 2, PHP_ROUND_HALF_UP), 2, ',', ' ');?></TD>

            <TD style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: right" nowrap="nowrap"><?=number_format(round($billOrder['DiscountPrice'] * $billOrder['Count'] / 1.18, 2, PHP_ROUND_HALF_UP), 2, ',', ' ');?></TD>
          </TR>
          <?
          $i++;
          endforeach;?>

          <TR>
            <TD style="TEXT-ALIGN: right; FONT-WEIGHT: bold; BORDER-RIGHT: 1px solid" colSpan="4">Итого:<BR>Итого НДС:<BR>Всего к оплате (c учетом НДС):</TD>
            <TD style="TEXT-ALIGN: right; FONT-WEIGHT: bold" colspan="2"><?=number_format($this->Total - $this->NDS, 2, ',', ' ');?><BR><?=number_format($this->NDS, 2, ',', ' ');?><BR><?=number_format($this->Total, 2, ',', ' ');?></TD>

          </TR>
          </TBODY>
        </TABLE>
      </TD>
    </TR>
    <TR>
      <TD colspan="2">
        Всего на сумму <?=number_format($this->Total, 0, ',', ' ');?> руб. 00 коп.
        <DIV><span><?=Texts::mb_ucfirst(mb_strtolower(Texts::NumberToText($this->Total, true)));?></span> рублей 00 копеек</DIV><BR><BR>
      </TD>
    </TR>
    <?if ($this->WithSign):?>
    <TR>
      <TD colspan="2">
        <IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-TOP: medium none; BORDER-RIGHT: medium none" src="/images/bill/signature_site12.png" />
      </TD>
    </TR>
    <?else:?>
    <TR>
      <TD colspan="2">
        <table>
          <tr>
            <td>Руководитель предприятия</td>
            <td>__________________________</td>
            <td>(Ашманов И.)</td>
          </tr>
          <tr>
            <td>Главный бухгалтер</td>
            <td>__________________________</td>
            <td>(Жукова И.)</td>
          </tr>
        </table>
      </TD>
    </TR>
    <?endif;?>
    </TBODY>
  </TABLE></DIV></BODY></HTML>