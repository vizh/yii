<?php
/**
 * @var \pay\models\RoomPartnerOrder $order
 * @var string $owner
 * @var bool $clear
 */
use application\components\utility\Texts;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
  <META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
  <TITLE>Договор</TITLE>
  <style type="text/css">
    ol>li{
      list-style: none outside none;
    }
    ol>li:before{
      content:counters(item,".") ". ";
      counter-increment:item;
    }
    ol{
      counter-reset:item;
    }
  </style>
</HEAD>
<BODY style="color: #000; font-family: 'Times New Roman'; font-size: 14px; width: 700px; text-align: justify;">
  <h1 style="text-align: center; font-size: 16px;">ДОГОВОР НА ОКАЗАНИЕ УСЛУГ № <?=$order->Number;?></h1>
  <table style="width: 100%; padding: 0; margin: 0; font-size: 12px;">
    <tr>
      <td>г. Москва</td>
      <td style="text-align: right;"><?=\Yii::app()->getDateFormatter()->format('«dd» MMMM yyyy г.', $order->CreationTime);?></td>
    </tr>
  </table>
  <p>
      <strong><?=CHtml::encode($order->Name)?></strong>, именуемое в дальнейшем <strong>«Заказчик»</strong>,
      в лице <?=CHtml::encode($order->ChiefPositionP)?>, действующего на основании
      <?=!empty($order->StatuteTitle) ? $order->StatuteTitle : 'Устава'?>, и
      <strong>Общество с ограниченной ответственностью «Интернет Медиа Холдинг»</strong>,
      именуемое в дальнейшем <strong>«Организатор»</strong>, в лице Директора Гребенникова Сергея Владимировича,
      действующего на основании Устава, а совместно именуемые «Стороны», заключили настоящий договор о нижеследующем:
  </p>
  <ol style="margin: 0; padding: 0; font-weight: bold;">
    <li style="padding-bottom: 10px;">
      <span style="font-size: 15px; font-weight: bold;">ПРЕДМЕТ ДОГОВОРА</span>
      <ol style="padding-top: 10px; font-weight: normal;">
        <li style="padding-bottom: 10px;">
            Организатор оказывает Заказчику услуги по участию представителей Заказчика в конференции
            "РИФ+КИБ 2016" (далее - Конференция) на территории пансионата ФГУ
            «Рублево-Звенигородский лечебно-оздоровительный комплекс» Управления делами Президента Российской Федерации
            по адресу: Московская область, Одинцовский район, поселок Горки-10, а Заказчик оплачивает услуги Организатора.
        </li>
        <li style="padding-bottom: 10px;">Срок оказания услуг: с 13 апреля 2016 года по 15 апреля 2016 года.</li>
      </ol>
    </li>
    <li style="padding-bottom: 10px;">
      <span style="font-size: 15px; font-weight: bold;">ПРАВА И ОБЯЗАННОСТИ СТОРОН</span>
      <ol style="padding-top: 10px; font-weight: normal;"">
        <li style="padding-bottom: 10px;">Организатор обязуется предоставить Заказчику полную информацию о возможностях Конференции, имеющих прямое отношение к предмету настоящего договора.</li>
        <li style="padding-bottom: 10px;">Организатор обязуется своевременно информировать Заказчика о любых изменениях, связанных с предметом настоящего договора.</li>
        <li style="padding-bottom: 10px;">Организатор обязуется оказать услуги в полном объеме и с надлежащим качеством, в срок, указанный в п. 1.2 настоящего договора.</li>
        <li style="padding-bottom: 10px;">По факту оказания услуг в течение 5 (пяти) календарных дней Организатор передает представителю Заказчика Акт сдачи-приема оказанных услуг и счет-фактуру.</li>
        <li style="padding-bottom: 10px;">Организатор вправе расторгнуть договор в одностороннем порядке, при невыполнении Заказчиком п.3.3 настоящего договора.</li>
        <li style="padding-bottom: 10px;">Заказчик обязуется оплатить услуги Организатора в полном объеме и в срок, предусмотренный условиями настоящего договора.</li>
      </ol>
    </li>
    <li style="padding-bottom: 10px;">
      <span style="font-size: 15px; font-weight: bold;">СТОИМОСТЬ ДОГОВОРА И ПОРЯДОК РАСЧЕТОВ</span>
      <ol style="padding-top: 10px; font-weight: normal;"">
        <?php
        $total = $order->getTotalPrice();
        $nds = $total - round($total / 1.18, 2, PHP_ROUND_HALF_DOWN);
        ?>
        <li style="padding-bottom: 10px;">Общая стоимость услуг по настоящему договору составляет <?=number_format($order->getTotalPrice(), 0, ',', ' ');?> (<?=mb_strtolower(Texts::NumberToText($total, true));?>) <?=Yii::t('app', 'рубль| рубля|рублей|рубля', $total);?> 00 копеек, в т.ч. НДС <?=number_format(floor($nds), 0, ',', ' ');?> (<?=mb_strtolower(Texts::NumberToText($nds, true));?>) <?=Yii::t('app', 'рубль| рубля|рублей|рубля', floor($nds));?>
          <?$kop = round(($nds - floor($nds)) * 100, 0, PHP_ROUND_HALF_DOWN);?>
          <?=$kop < 10 ? '0' . $kop : $kop;?> копеек.</li>
        <li style="padding-bottom: 10px;">
          Проживание:

          <table class="order" cellpadding="0" cellspacing="0" style="font-size: 12px; width: 100%; padding: 0; margin: 10px 0 0 10px; position: relative; left: -50px; border-collapse: collapse;">
            <thead>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">ПАНСИОНАТ</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">КОРПУС</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">КАТЕГОРИЯ</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">НОМЕР</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">СТОИМОСТЬ ЗА СУТКИ</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">Доп.места</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">12-13 апр</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">13-14 апр</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">14-15 апр</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">КОЛ-ВО СУТОК</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">ИТОГО</th>
            </thead>
            <tbody>
              <?foreach ($order->Bookings as $booking):?>
                <?
                /** @var \pay\components\managers\RoomProductManager $manager */
                $manager = $booking->Product->getManager();
                ?>
                <tr>
                  <td style="border: 1px solid #000000;padding: 8px;"><?=$manager->Hotel;?></td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;"><?=$manager->Housing;?></td>
                  <td style="border: 1px solid #000000;padding: 8px;"><?=$manager->Category;?></td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;"><?=$manager->Number;?></td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;"><?=$manager->Price;?></td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;"><?=$manager->AdditionalPrice * $booking->AdditionalCount;?></td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;">
                    <?if ($booking->DateIn <= '2016-04-12' && $booking->DateOut >= '2016-04-13'):?>1<?endif;?>
                  </td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;">
                    <?if ($booking->DateIn <= '2016-04-13' && $booking->DateOut >= '2016-04-14'):?>1<?endif;?>
                  </td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;">
                    <?if ($booking->DateIn <= '2016-04-15' && $booking->DateOut >= '2016-04-15'):?>1<?endif;?>
                  </td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;"><?=$booking->getStayDay();?></td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;"><?=$booking->getStayDay() * (Texts::getOnlyNumbers($manager->Price) + $booking->AdditionalCount * $manager->AdditionalPrice);?></td>
                </tr>
              <?endforeach;?>
            </tbody>
          </table>
      </li>
        <li style="padding-bottom: 10px;">Оплата услуг по настоящему договору осуществляется Заказчиком на условиях 100% (Сто процентного) авансового платежа в течение 10 (десяти) банковских дней с момента выставления Организатором соответствующего счета.</li>
      </ol>
    </li>
    <li style="padding-bottom: 10px;">
      <span style="font-size: 15px; font-weight: bold;">ОТВЕТСТВЕННОСТЬ СТОРОН И ПОРЯДОК РАЗРЕШЕНИЯ СПОРОВ</span>
      <ol style="padding-top: 10px; font-weight: normal;"">
        <li style="padding-bottom: 10px;">За неисполнение или ненадлежащее исполнение условий договора Стороны несут ответственность в соответствии с условиями договора и положениями действующего законодательства РФ.</li>
        <li style="padding-bottom: 10px;">Стороны договорились, что правила, предусмотренные пунктом 1 статьи 317.1. Гражданского кодекса Российской Федерации к отношениям Сторон по Договору не применяются и Заказчик не имеет право на получение с Исполнителя процентов на сумму уплаченного Заказчиком аванса.</li>
        <li style="padding-bottom: 10px;">Стороны освобождаются от ответственности за частичное или полное неисполнение обязательств по настоящему Договору, если это неисполнение явилось следствием обстоятельств непреодолимой силы, возникших после заключения Договора, в результате событий чрезвычайного характера, которые Сторона не могла ни предвидеть, ни предотвратить разумными мерами.</li>
        <li style="padding-bottom: 10px;">Споры и разногласия, которые могут возникнуть при исполнении настоящего договора, будут по возможности разрешаться путем переговоров между Сторонами, в случае недостижения договоренности по предмету спора путем переговоров споры между Сторонами подлежат разрешению в Арбитражном Суде г. Москвы в соответствии с действующими нормами законодательства РФ. </li>
      </ol>
    </li>
    <li style="padding-bottom: 10px;">
      <span style="font-size: 15px; font-weight: bold;">ЗАКЛЮЧИТЕЛЬНЫЕ ПОЛОЖЕНИЯ</span>
      <ol style="padding-top: 10px; font-weight: normal;"">
        <li style="padding-bottom: 10px;">Договор вступает в действие с момента подписания и действует до полного исполнения Сторонами своих обязательств по настоящему Договору.</li>
        <li style="padding-bottom: 10px;">Любые изменения и дополнения к настоящему договору действительны лишь при условии, что они совершены в письменной форме и подписаны уполномоченными представителями Сторон.</li>
        <li style="padding-bottom: 10px;">Стороны обязаны незамедлительно сообщать об изменении своих почтовых адресов, банковских реквизитов, номеров телефонов, телефаксов.</li>
        <li style="padding-bottom: 10px;">Настоящий договор составлен на русском языке в двух экземплярах, имеющих одинаковую юридическую силу, по одному для каждой из Сторон.</li>
      </ol>
    </li>
    <li style="padding-bottom: 10px; <?if (sizeof($order->Bookings) > 3):?>page-break-before: always;<?endif;?>">
      <span style="font-size: 15px; font-weight: bold;">АДРЕСА И БАНКОВСКИЕ РЕКВИЗИТЫ СТОРОН</span>
      <table style="margin-top: 20px; width: 100%;">
        <tr>
          <td style="width: 50%; vertical-align: top;">
            <p><strong>«Заказчик»</strong></p>
            <p>
              <?=$owner;?><br/>
              Юр. адрес: <?=$order->Address;?><br/>
              <?if (!empty($order->RealAddress)):?>
              Фактич. адрес: <?=$order->RealAddress;?><br/>
              <?endif;?>
              ИНН/КПП <?=$order->INN;?> / <?=$order->KPP;?><br/>
              <?=$order->BankName;?><br/>
              р/с <?=$order->Account;?><br/>
              к/с <?=$order->CorrespondentAccount;?><br/>
              БИК <?=$order->BIK;?>
            </p>
          </td>
          <td style="width: 50%; vertical-align: top;">
            <p><strong>«Организатор»</strong></p>
            <p>ООО «Интернет Медиа Холдинг»<br/>
            123100, г. Москва, Пресненская наб., д. 12, эт. 46<br/>
            ИНН/КПП 7703725797/770301001<br/>
            Московский филиал ПАО РОСБАНК <br/>
            р/с 40702810697620000409<br/>
            к/с 30101810000000000272<br/>
            БИК 044583272</p>
          </td>
        </tr>
        <tr>
            <td style="vertical-align: bottom;">
                <p>
                    <?=$order->ChiefPosition;?>:<br/><br/>

                    _____________________ / <?=$order->ChiefName;?>/<br/>
                    м.п.
                </p>
            </td>
            <td style="vertical-align: bottom;">
                <?php if (!$clear):?>
                <img src="/img/pay/bill/booking/stamp.png" style="position: absolute; margin: 5px 0 0 -30px; z-index: 2;image-resolution: 150dpi;"/>
                <img src="/img/pay/bill/booking/sign.png" style="position: absolute; margin: 10px 0 0 10px; z-index: 1;image-resolution: 150dpi;"/>
                <?php endif;?>
                <p>
                    Директор:<br/><br/>
                    _____________________ / Гребенников С.В./<br/>
                    м.п.</p>
            </td>
        </tr>
      </table>
    </li>
  </ol>

  <div style="page-break-after: always; padding: 0; margin: 0; height: 0"></div>

  <table style="width: 100%; padding: 0; margin: 0;" cellspacing="0" cellpadding="0">
      <tbody>
      <tr>
          <td>
              <strong>ООО «Интернет Медиа Холдинг»</strong><br>
              Адрес: 123100, г. Москва, наб. Пресненская., д. 12, этаж 46<br>
              тел. +7 (495) 950-56-51          </td>
          <td style="text-align: right; vertical-align: middle;">
              <img width="219" height="20" src="/images/logo-mid.png">
          </td>
      </tr>
      </tbody>
  </table>

  <h4 style="text-align: center; font-weight: bold; margin: 25px 0 10px;">Образец заполнения платежного поручения</h4>
  <table class="payment-info" style="width: 100%; padding: 0; margin: 0; border-collapse: collapse;" cellspacing="0" cellpadding="0">
      <tbody>
      <tr>
          <td style="border: 1px solid #000; padding: 5px;">ИНН 7703725797</td>
          <td style="border: 1px solid #000; padding: 5px;">КПП 770301001</td>
          <td colspan="2" style="border: 1px solid #000;">&nbsp;</td>
      </tr>
      <tr>
          <td colspan="2"  style="border: 1px solid #000; padding: 5px;">Получатель<br>ООО «Интернет Медиа Холдинг»</td>
          <td style="border: 1px solid #000; padding: 5px;"><br>Сч.	№</td>
          <td style="border: 1px solid #000; padding: 5px;"><br>40702810697620000409</td></tr>
      <tr>
          <td colspan="2" style="border: 1px solid #000; padding: 5px;">Банк получателя<br>МОСКОВСКИЙ ФИЛИАЛ ПАО РОСБАНК Г.МОСКВА</td>
          <td style="border: 1px solid #000; padding: 5px;">БИК<br>Сч. №</td>
          <td style="border: 1px solid #000; padding: 5px;">044583272<br>30101810000000000272</td>
      </tr>
      </tbody>
  </table>

  <h2 style="text-align: center;font-size: 22px;line-height: 22px;margin: 40px 0 10px;">
      Cчет № <?=$order->Number;?> от <?=\Yii::app()->getDateFormatter()->format('dd.MM.yyyy', $order->CreationTime);?><br>
  </h2>

  <p>
      <strong>Заказчик:</strong> <?=$order->Name;?>,
      <strong>ИНН / КПП:</strong> <?=$order->INN;?>/<?=$order->KPP;?><br>
      <strong>Плательщик:</strong> <?=$order->Name;?><br>
      <strong>Адрес:</strong> <?=$order->Address;?></p>


  <table class="orderitems" style="width: 100%; padding: 0; margin: 0; border-collapse: collapse;" cellspacing="0" cellpadding="0">
      <thead>
      <tr>
          <th style="border: 1px solid #000;  padding: 5px;">№</th>
          <th style="border: 1px solid #000;  padding: 5px;">Наименование товара (услуги)</th>
          <th style="border: 1px solid #000;  padding: 5px;">Единица<br>измерения</th>
          <th style="border: 1px solid #000;  padding: 5px;">Кол-во</th>
          <th style="border: 1px solid #000;  padding: 5px;">Цена,<br>руб.</th>
          <th style="border: 1px solid #000;  padding: 5px;">Сумма,<br>руб.</th>
      </tr>
      </thead>
      <tbody>
      <tr>
          <td style="border: 1px solid #000;  padding: 5px;">1</td>
          <td style="border: 1px solid #000;  padding: 5px;">Услуги по участию представителей Заказчика в конференции "РИФ+КИБ 2016",
              проходящей в период с 13 апреля 2016 года по 15 апреля 2016 года по адресу Московская область,
              Одинцовский район, поселок Горки-10, согласно
              Договору № <?=$order->Number;?> от
              <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy г', $order->CreationTime);?>.</td>
          <td style="border: 1px solid #000;  padding: 5px; text-align: center;">усл.</td>
          <td style="border: 1px solid #000;  padding: 5px; text-align: center;">1</td>
          <td style="border: 1px solid #000;  padding: 5px; text-align: center; white-space: nowrap;"><?=number_format($total-$nds, 2, ',', ' ');?></td>
          <td style="border: 1px solid #000;  padding: 5px; text-align: right; white-space: nowrap;"><?=number_format($total-$nds, 2, ',', ' ');?></td>
      </tr>

      <tr>
          <td colspan="4" style="border: 1px solid #000;  padding: 5px; text-align: right;">
              <strong>Итого:</strong><br>
              <strong>Итого НДС:</strong><br>
              <strong>Всего к оплате (c учетом НДС):</strong>
          </td>
          <td colspan="2" style="border: 1px solid #000;  padding: 5px; text-align: right;">
              <strong><?=number_format($total-$nds, 2, ',', ' ');?></strong><br>
              <strong><?=number_format($nds, 2, ',', ' ');?></strong><br>
              <strong><?=number_format($total, 2, ',', ' ');?></strong>
          </td>
      </tr>
      </tbody>
  </table>

  <p>
      Всего на сумму <?=number_format($total, 0, ',', ' ');?> руб. 00 коп.<br>
      <?$stringTotal = Texts::NumberToText($total, true);?>
      <?=mb_substr($stringTotal, 0, 1).mb_substr(mb_strtolower($stringTotal), 1);?> <?=Yii::t('app', 'рубль| рубля|рублей|рубля', $total);?> 00 копеек
  </p>
  <?php if (!$clear):?>
      <img src="/img/pay/bill/imh.jpg" style="margin-left: -10px;image-resolution: 150dpi;">
  <?php else:?>
      <table class="sign">
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
  <?php endif;?>
  <div style="page-break-after: always; padding: 0; margin: 0; height: 0"></div>
</BODY>
</HTML>
