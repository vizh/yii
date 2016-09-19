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
  <td><b>ООО «Интернет Медиа Холдинг»</b><BR>Адрес: 123100, г. Москва, наб. Пресненская., д. 12, этаж 46<BR>тел. +7 (495) 950-56-51</td>
  <td align="right"><img src="/img/pay/bill/rocid.png" width="129" height="48"></td>

</tr>
<tr>
  <td colspan="2">
    <P style="TEXT-ALIGN: center"><B>Образец заполнения платежного поручения</B></P>
    <table style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; WIDTH: 100%; BORDER-TOP: 1px solid; BORDER-RIGHT: 1px solid" cellSpacing="0" cellPadding="3">
      <tbody>
      <tr>
        <td style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">ИНН 7703725797</td>

        <td style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid">КПП 770301001</td>
        <td style="BORDER-BOTTOM: 1px solid">&nbsp;</td>
        <td style="BORDER-BOTTOM: 1px solid">&nbsp;</td>
      </tr>
      <tr>
        <td style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"	colSpan=2>Получатель<BR>ООО «Интернет Медиа Холдинг»</td>
        <td	style="BORDER-BOTTOM: 1px solid; BORDER-RIGHT: 1px solid"><BR>Сч.	№</td>

        <td style="BORDER-BOTTOM: 1px solid"><BR>40702810697620000409</td></tr>
      <tr>
        <td style="BORDER-RIGHT: 1px solid" colSpan=2>Банк получателя<BR>Московский филиал ОАО АКБ «РОСБАНК» г. Москва</td>
        <td style="BORDER-RIGHT: 1px solid">БИК<BR>Сч. №</td>
        <td>044525256<BR>30101810000000000256</td>

      </tr>
      </tbody>
    </table>
  </td>
</tr>
<tr>
  <td style="TEXT-ALIGN: center" colspan="2">
    <div style="MARGIN-TOP: 20px; FONT-SIZE: 24px"><B>CЧЕТ № <?=$order->Id;?> от <?=date('d.m.Y', strtotime($order->CreationTime));?></B></div>

    (Счет действителен в течение 10-и банковских дней)
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
        <td style="TEXT-ALIGN: right; FONT-WEIGHT: bold; BORDER-RIGHT: 1px solid" colSpan="4">Итого:<BR>Итого НДС:<BR>Всего к оплате (c учетом НДС):</td>
        <td style="TEXT-ALIGN: right; FONT-WEIGHT: bold" colspan="2"><?=number_format($total - $nds, 2, ',', ' ');?><BR><?=number_format($nds, 2, ',', ' ');?><BR><?=number_format($total, 2, ',', ' ');?></td>

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
<tr>
  <td style="FONT-SIZE: 10px" colspan="2">
    <H2>Публичная оферта на оказание услуг</H2>
    <P><STRONG>1. ОБЩИЕ ПОЛОЖЕНИЯ</STRONG><BR>1.1. В соответствии со статьей
      437 Гражданского Кодекса Российской Федерации (ГК РФ) настоящий документ
      является официальной публичной офертой Общества с ограниченной
      ответственностью «Интернет Медиа Холдинг», в дальнейшем именуемого ИСПОЛНИТЕЛЬ, и
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
      документами и публикуются на сайте <A href="http://rocid.ru/"
                                            target=_blank>rocid.ru</A><BR>2.3. ИСПОЛНИТЕЛЬ имеет право изменять
      ПРЕЙСКУРАНТ, условия данной публичной оферты и дополнения к публичной
      оферте без предварительного согласования с ЗАКАЗЧИКОМ, обеспечивая при
      этом публикацию измененных условий на сайте <A href="http://rocid.ru/"
                                                     target=_blank>rocid.ru</A>, не менее чем за один день до ввода их в
      действие.<BR>2.4. ИСПОЛНИТЕЛЬ имеет право уведомлять ЗАКАЗЧИКА по
      предоставленным адресам электронной почты об изменениях в оказываемых
      услугах и новых услугах оказываемых ИСПОЛНИТЕЛЕМ. </P>
    <P><STRONG>3. ОПИСАНИЕ УСЛУГ</STRONG><BR>3.1. В соответствии с предметом
      настоящей оферты ИСПОЛНИТЕЛЬ оказывает ЗАКАЗЧИКУ услуги, указанные в
      ПРЕЙСКУРАНТЕ. </P>
    <P><STRONG>4. УСЛОВИЯ И ПОРЯДОК ПРЕДОСТАВЛЕНИЯ УСЛУГ</STRONG><BR>4.1.
      Ознакомившись с ПРЕЙСКУРАНТОМ и выбрав вид услуги, ЗАКАЗЧИК направляет в
      адрес ИСПОЛНИТЕЛЯ заявку на оказание услуг, в соответствии с формой
      приведенной на сайте <A href="http://rocid.ru/"
                              target=_blank>rocid.ru</A>, после чего <STRONG>ПУБЛИЧНАЯ ОФЕРТА НА
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
    <P><STRONG>7. СРОК ДЕЙСТВИЯ ДОГОВОРА</STRONG><BR>7.1. Договор вступает в
      силу с момента, указанного в п. 4.3 настоящей ОФЕРТЫ, и действует до
      полного выполнения ЗАКАЗЧИКОМ своих обязательств. </P>
    <P><STRONG>8. СПОРЫ СТОРОН</STRONG><BR>8.1. Все споры и разногласия
      решаются путем переговоров. В случае если споры и разногласия не могут
      быть урегулированы путем переговоров, они передаются на рассмотрение
      Арбитражного суда. </P>

    <P><STRONG>9. РЕКВИЗИТЫ</STRONG><BR><U>Исполнитель</U><BR>ООО «Интернет Медиа Холдинг»
      <BR>Юр. адрес: 123100, г. Москва, наб. Пресненская., д.
      12, этаж 46<BR>ИНН/КПП: 7703725797/770301001<BR>Московский филиал ОАО АКБ «РОСБАНК»
      г. Москва<BR>р/с. 40702810697620000409<BR>к/с. 30101810000000000256<BR>БИК
      044525256 </P><BR><BR><BR>
  </td>
</tr>
<?if ($withSign):?>
  <tr>

    <td colspan="2">
      <IMG	style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-TOP: medium none; BORDER-RIGHT: medium none"
            src="/img/pay/bill/signature.jpg"
          />
    </td>
  </tr>
<?else:?>
  <tr>
    <td colspan="2">
      <table>
        <tr>
          <td>Руководитель предприятия</td>
          <td>__________________________</td>
          <td>(Гребенников С. В.)</td>
        </tr>
        <tr>
          <td>Главный бухгалтер</td>
          <td>__________________________</td>
          <td>(Гулина Н. А.)</td>
        </tr>
      </table>
      <br/><br/><br/><br/><br/>
    </td>
  </tr>
<?endif;?>
</tbody>
</table>
</div>
</body>
</html>

 
