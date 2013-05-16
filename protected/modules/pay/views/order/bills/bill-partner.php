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
  <TITLE>Счёт № <?=$order->Id;?></TITLE>
  <META content="text/html; charset=UTF-8" http-equiv=Content-Type>
</HEAD>
<BODY>
<DIV id=panel></DIV>
<DIV id=content>
<TABLE cellSpacing="0" cellPadding="5" width="720" border="0">
<TBODY>
<TR>
  <TD><b>ООО «Рунет Медиа Холдинг»</b><BR>Адрес: 123100, г. Москва, наб. Пресненская., д. 12, этаж 46<BR>тел. +7 (495) 950-56-51</TD>
  <td align="right"><img src="/img/pay/bill/rocid.png" width="129" height="48"></td>

</tr>
<TR>
  <TD colspan="2">
    <P style="TEXT-ALIGN: center"><B>Образец заполнения платежного поручения</B></P>
    <TABLE style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; WIDTH: 100%; BORDER-TOP: 1px solid; BORDER-RIGHT: 1px solid" cellSpacing="0" cellPadding="3">
      <TBODY>
      <TR>
        <TD style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">ИНН 7703760449</TD>

        <TD style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">КПП 770301001</TD>
        <TD style="BORDER-BOTTOM: 1px solid">&nbsp;</TD>
        <TD style="BORDER-BOTTOM: 1px solid">&nbsp;</TD>
      </TR>
      <TR>
        <TD style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"	colSpan=2>Получатель<BR>ООО «Рунет Медиа Холдинг»</TD>
        <TD	style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"><BR>Сч.	№</TD>

        <TD style="BORDER-BOTTOM: 1px solid"><BR>40702810897620000319</TD></TR>
      <TR>
        <TD style="BORDER-RIGHT: 1px solid" colSpan=2>Банк получателя<BR>Московский филиал ОАО АКБ «РОСБАНК» г. Москва</TD>
        <TD style="BORDER-RIGHT: 1px solid">БИК<BR>Сч. №</TD>
        <TD>044552272<BR>30101810200000000272</TD>

      </TR>
      </TBODY>
    </TABLE>
  </TD>
</TR>
<TR>
  <TD style="TEXT-ALIGN: center" colspan="2">
    <DIV style="MARGIN-TOP: 20px; FONT-SIZE: 24px"><B>CЧЕТ № <?=$order->Id;?> от <?=date('d.m.Y', strtotime($order->CreationTime));?></B></DIV>

    (Счет действителен в течение 5-и банковских дней)
  </TD>
</TR>
<TR>
  <TD colspan="2">Заказчик: <?=$order->OrderJuridical->Name;?>,
    ИНН / КПП: <?=$order->OrderJuridical->INN;?>/<?=$order->OrderJuridical->KPP;?><BR>
    Плательщик: <?=$order->OrderJuridical->Name;?><BR>
    Адрес: <?=$order->OrderJuridical->Address;?>		</TD>
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
          <TD style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"><?=$i;?></TD>
          <TD style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"><?=$data['Title'];?></TD>
          <TD style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: center; BORDER-RIGHT: 1px solid"><?=$data['Unit'];?></TD>
          <TD style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: center; BORDER-RIGHT: 1px solid"><?=$data['Count'];?></TD>
          <TD style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: center; BORDER-RIGHT: 1px solid" nowrap="nowrap"><?=number_format(round($data['DiscountPrice'] / 1.18, 2, PHP_ROUND_HALF_UP), 2, ',', ' ');?></TD>

          <TD style="BORDER-BOTTOM: 1px solid; TEXT-ALIGN: right" nowrap="nowrap"><?=number_format(round($data['DiscountPrice'] * $data['Count'] / 1.18, 2, PHP_ROUND_HALF_UP), 2, ',', ' ');?></TD>
        </TR>
        <?
        $i++;
      endforeach;?>

      <TR>
        <TD style="TEXT-ALIGN: right; FONT-WEIGHT: bold; BORDER-RIGHT: 1px solid" colSpan="4">Итого:<BR>Итого НДС:<BR>Всего к оплате (c учетом НДС):</TD>
        <TD style="TEXT-ALIGN: right; FONT-WEIGHT: bold" colspan="2"><?=number_format($total - $nds, 2, ',', ' ');?><BR><?=number_format($nds, 2, ',', ' ');?><BR><?=number_format($total, 2, ',', ' ');?></TD>

      </TR>
      </TBODY>
    </TABLE>
  </TD>
</TR>
<TR>
  <TD colspan="2">
    Всего на сумму <?=number_format($total, 0, ',', ' ');?> руб. 00 коп.
    <DIV><span><?=Texts::mb_ucfirst(mb_strtolower(Texts::NumberToText($total, true)));?></span> рублей 00 копеек</DIV><BR><BR>

  </TD>
</TR>
<TR>
  <TD style="FONT-SIZE: 10px" colspan="2">
    <H2>Публичная оферта на оказание услуг</H2>
    <P><STRONG>1. ОБЩИЕ ПОЛОЖЕНИЯ</STRONG><BR>1.1. В соответствии со статьей
      437 Гражданского Кодекса Российской Федерации (ГК РФ) настоящий документ
      является официальной публичной офертой Общества с ограниченной
      ответственностью «Рунет Медиа Холдинг», в дальнейшем именуемого ИСПОЛНИТЕЛЬ, и
      содержит все существенные условия оказания услуг.<BR>1.2. В соответствии с
      пунктом 2 статьи 437 Гражданского Кодекса Российской Федерации (ГК РФ) в
      случае принятия изложенных ниже условий и оплаты услуг юридическое или
      физическое лицо, производящее акцепт этой оферты становится ЗАКАЗЧИКОМ. В
      соответствии с пунктом 3 статьи 438 ГК РФ акцепт оферты равносилен
      заключению договора на условиях, изложенных в оферте.<BR>1.3. В связи с
      вышеизложенным, внимательно прочитайте текст данной публичной оферты и
      если Вы не согласны с каким-либо пунктом оферты, ИСПОЛНИТЕЛЬ предлагает
      Вам отказаться от использования услуг.</P>

    <P><STRONG>2. ПРЕДМЕТ ОФЕРТЫ</STRONG><BR>2.1. Предметом настоящей оферты
      является оказание ЗАКАЗЧИКУ услуг в соответствии с условиями настоящей
      публичной оферты, дополнениями к публичной оферте и текущим прейскурантом
      (в дальнейшем ПРЕЙСКУРАНТОМ) ИСПОЛНИТЕЛЯ.<BR>2.2. Публичная оферта,
      дополнения к публичной оферте и ПРЕЙСКУРАНТ являются официальными
      документами и публикуются на сайте <A href="http://runet-id.com/"
                                            target=_blank>runet-id.com</A><BR>2.3. ИСПОЛНИТЕЛЬ имеет право изменять
      ПРЕЙСКУРАНТ, условия данной публичной оферты и дополнения к публичной
      оферте без предварительного согласования с ЗАКАЗЧИКОМ, обеспечивая при
      этом публикацию измененных условий на сайте <A href="http://runet-id.com/"
                                                     target=_blank>runet-id.com</A>, не менее чем за один день до ввода их в
      действие.<BR>2.4. ИСПОЛНИТЕЛЬ имеет право уведомлять ЗАКАЗЧИКА по
      предоставленным адресам электронной почты об изменениях в оказываемых
      услугах и новых услугах оказываемых ИСПОЛНИТЕЛЕМ. </P>
    <P><STRONG>3. ОПИСАНИЕ УСЛУГ</STRONG><BR>3.1. В соответствии с предметом
      настоящей оферты ИСПОЛНИТЕЛЬ оказывает ЗАКАЗЧИКУ услуги, указанные в
      ПРЕЙСКУРАНТЕ. </P>
    <P><STRONG>4. УСЛОВИЯ И ПОРЯДОК ПРЕДОСТАВЛЕНИЯ УСЛУГ</STRONG><BR>4.1.
      Ознакомившись с ПРЕЙСКУРАНТОМ и выбрав вид услуги, ЗАКАЗЧИК направляет в
      адрес ИСПОЛНИТЕЛЯ заявку на оказание услуг, в соответствии с формой
      приведенной на сайте <A href="http://runet-id.com/"
                              target=_blank>runet-id.com</A>, после чего <STRONG>ПУБЛИЧНАЯ ОФЕРТА НА
        ОКАЗАНИЕ УСЛУГ</STRONG> (в дальнейшем - ДОГОВОР) автоматически считается
      заключенным.<BR>4.2. На основании полученной заявки ИСПОЛНИТЕЛЬ выставляет
      ЗАКАЗЧИКУ счет на оплату выбранной услуги.<BR>4.3. После проведения
      ЗАКАЗЧИКОМ оплаты выставленного счета и зачисления денежных средств на
      расчетный счет ИСПОЛНИТЕЛЯ ДОГОВОР вступает в силу.<BR>4.4. Услуги
      считаются оказанными надлежащим образом и в полном объеме, если в течение
      трех рабочих дней с момента окончания оказания услуг ЗАКАЗЧИКОМ не
      выставлена рекламация. В случае отсутствия рекламации, акт приемки-сдачи
      оказанных услуг считается подписанным, а услуги оказанными надлежащим
      образом.<BR>4.5. По факту оказания услуг ИСПОЛНИТЕЛЬ выписывает
      счет-фактуру и составляет Акт приемки-сдачи оказанных услуг.<BR>4.6.
      Другие условия оказания услуг приведены в п.п. 5-7 настоящей ОФЕРТЫ. </P>

    <P><STRONG>5. ФИНАНСОВЫЕ ВЗАИМООТНОШЕНИЯ СТОРОН</STRONG><BR>5.1. Оказание
      всех услуг ИСПОЛНИТЕЛЯ осуществляется на основании 100% предоплаты.
      <BR>5.2. Расчет предоставляемых ИСПОЛНИТЕЛЕМ услуг производится в рублях.
    </P>
    <P><STRONG>6. ФОРС-МАЖОРНЫЕ ОБСТОЯТЕЛЬСТВА</STRONG><BR>6.1. Сторона
      освобождается от ответственности по настоящему договору, если
      докажет, что надлежащее выполнение условий договора оказалось невозможным
      вследствие непреодолимой силы, чрезвычайных и непредотвратимых
      обстоятельств в данных условиях (стихийные действия, военные действия и
      т.д.). </P>
    <p><strong>7. СРОК ДЕЙСТВИЯ ДОГОВОРА</strong><br>
      7.1. Договор вступает в силу с момента, указанного в п. 4.3 настоящей ОФЕРТЫ, и действует до полного выполнения ИСПОЛНИТЕЛЕМ своих обязательств.
    </p>
    <P><STRONG>8. СПОРЫ СТОРОН</STRONG><BR>8.1. Все споры и разногласия
      решаются путем переговоров. В случае если споры и разногласия не могут
      быть урегулированы путем переговоров, они передаются на рассмотрение
      Арбитражного суда. </P>

    <P><STRONG>9. РЕКВИЗИТЫ</STRONG><BR><U>Исполнитель</U><BR>ООО «Рунет Медиа Холдинг»
      <BR>Юр. адрес: 123100, г. Москва, наб. Пресненская., д.
      12, этаж 46<BR>ИНН/КПП: 7703760449/770301001<BR>Московский филиал ОАО АКБ «РОСБАНК»
      г. Москва<BR>р/с. 40702810897620000319<BR>к/с. 30101810200000000272<BR>БИК
      044552272 </P><BR><BR><BR>
  </TD>
</TR>
<?if ($withSign):?>
  <TR>

    <TD colspan="2">
      <IMG	style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-TOP: medium none; BORDER-RIGHT: medium none"
            src="/img/pay/bill/partner/signature.jpg"
          />
    </TD>
  </TR>
<?else:?>
  <TR>
    <TD colspan="2">
      <table>
        <tr>
          <td>Руководитель предприятия</td>
          <td>__________________________</td>
          <td>(Гребенников С. В.)</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Главный бухгалтер</td>
          <td>__________________________</td>
          <td>(Гребенников С. В.)</td>
        </tr>
      </table>
      <br/><br/><br/><br/><br/>
    </TD>
  </TR>
<?endif;?>
</TBODY>
</TABLE></DIV></BODY></HTML>
