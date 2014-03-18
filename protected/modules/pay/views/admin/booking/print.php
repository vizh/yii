<?/**
 * @var \pay\models\RoomPartnerOrder $order
 * @var string $owner
 */?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
  <META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
  <TITLE>Договор</TITLE>
</HEAD>
<BODY style="color: #000; font-family: Arial; font-size: 12px; width: 700px;">
  <h1 style="text-align: center; font-size: 16px;">ДОГОВОР НА ОКАЗАНИЕ УСЛУГ №</h1>
  <table style="width: 100%; padding: 0; margin: 0; font-size: 12px;">
    <tr>
      <td>г. Москва</td>
      <td style="text-align: right;"><?=\Yii::app()->getDateFormatter()->format('«dd» MMMM yyyy г.', $order->CreationTime);?></td>
    </tr>
  </table>
  <p><strong><?=$owner;?></strong>, именуемое в дальнейшем <strong>«Заказчик»</strong>, в лице <?=$order->ChiefPositionP;?> <?=$order->ChiefNameP;?>, действующего на основании Устава, и <strong>Общество с ограниченной ответственностью «Интернет Медиа Холдинг»</strong>, именуемое в дальнейшем <strong>«Организатор»</strong>, в лице Директора Гребенникова Сергея Владимировича, действующего на основании Устава, а совместно именуемые «Стороны», заключили настоящий договор о нижеследующем:</p>
  <ol>
    <li style="padding-bottom: 10px;">
      <span style="font-size: 15px; font-weight: bold;">ПРЕДМЕТ ДОГОВОРА</span>
      <ol style="padding-top: 10px;">
        <li style="padding-bottom: 10px;">Организатор оказывает Заказчику услуги по участию представителей Заказчика в конференции РИФ+КИБ 2014 (далее - Конференция) на территории пансионата ФГУ «Рублево-Звенигородский лечебно-оздоровительный комплекс» Управления делами Президента Российской Федерации, а Заказчик оплачивает услуги Организатора.</li>
        <li style="padding-bottom: 10px;">Срок оказания услуг: с 22 апреля 2014 года по 25 апреля 2014 года.</li>
      </ol>
    </li>
    <li style="padding-bottom: 10px;">
      <span style="font-size: 15px; font-weight: bold;">ПРАВА И ОБЯЗАННОСТИ СТОРОН</span>
      <ol style="padding-top: 10px;">
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
      <ol style="padding-top: 10px;">
        <?$nds = round($order->getTotalPrice() / 1.18, 2, PHP_ROUND_HALF_DOWN);?>
        <li style="padding-bottom: 10px;">Общая стоимость услуг по настоящему договору составляет <?=number_format($order->getTotalPrice(), 0, ',', ' ');?> (<?=mb_strtolower(\application\components\utility\Texts::NumberToText($order->getTotalPrice(), true));?>) рублей 00 копеек, в т.ч. НДС <?=number_format($nds, 0, ',', ' ');?> (<?=mb_strtolower(\application\components\utility\Texts::NumberToText($nds, true));?>) рублей 00 копеек.</li>
        <li style="padding-bottom: 10px;">
          Проживание:
        </li>
      </ol>
          <table class="order" cellpadding="0" cellspacing="0" style="font-size: 12px; width: 100%; padding: 0; margin: 0 0 20px; margin-top: 10px; border-collapse: collapse;">
            <thead>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">ПАНСИОНАТ</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">КОРПУС</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">КАТЕГОРИЯ</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">НОМЕР</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">СТОИМОСТЬ ЗА СУТКИ</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">Доп.места</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">22-23 апр</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">23-24 апр</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">24-25 апр</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">ИТОГО</th>
              <th style="padding: 30px 8px;text-align: center;font-weight: normal;background-color: #f2f2f2;border: 1px solid #000000;">ИТОГО</th>
            </thead>
            <tbody>
              <?foreach ($order->Bookings as $booking):?>
                <?$manager = $booking->Product->getManager();?>
                <tr>
                  <td style="border: 1px solid #000000;padding: 8px;"><?=$manager->Hotel;?></td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;"><?=$manager->Housing;?></td>
                  <td style="border: 1px solid #000000;padding: 8px;"><?=$manager->Category;?></td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;"><?=$manager->Number;?></td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;"><?=$manager->Price;?></td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;">&nbsp;</td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;">
                    <?if ($booking->DateIn <= '2014-04-22' && $booking->DateOut >= '2014-04-23'):?>1<?endif;?>
                  </td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;">
                    <?if ($booking->DateIn <= '2014-04-23' && $booking->DateOut >= '2014-04-24'):?>1<?endif;?>
                  </td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;">
                    <?if ($booking->DateIn <= '2014-04-24' && $booking->DateOut >= '2014-04-25'):?>1<?endif;?>
                  </td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;"><?=$booking->getStayDay();?></td>
                  <td style="border: 1px solid #000000;padding: 8px;text-align:center;"><?=$booking->getStayDay()*$manager->Price;?></td>
                </tr>
              <?endforeach;?>
            </tbody>
          </table>
      <ol start="3">
        <li style="padding-bottom: 10px;">Оплата услуг по настоящему договору осуществляется Заказчиком на условиях 100% (Сто процентного) авансового платежа в течение 5 (пяти) банковских дней с момента выставления Организатором соответствующего счета.</li>
      </ol>
    </li>
    <li style="padding-bottom: 10px;">
      <span style="font-size: 15px; font-weight: bold;">ОТВЕТСТВЕННОСТЬ СТОРОН И ПОРЯДОК РАЗРЕШЕНИЯ СПОРОВ</span>
      <ol style="padding-top: 10px;">
        <li style="padding-bottom: 10px;">За неисполнение или ненадлежащее исполнение условий договора Стороны несут ответственность в соответствии с условиями договора и положениями действующего законодательства РФ.</li>
        <li style="padding-bottom: 10px;">Стороны освобождаются от ответственности за частичное или полное неисполнение обязательств по настоящему Договору, если это неисполнение явилось следствием обстоятельств непреодолимой силы, возникших после заключения Договора, в результате событий чрезвычайного характера, которые Сторона не могла ни предвидеть, ни предотвратить разумными мерами.</li>
        <li style="padding-bottom: 10px;">Споры и разногласия, которые могут возникнуть при исполнении настоящего договора, будут по возможности разрешаться путем переговоров между Сторонами, в случае недостижения договоренности по предмету спора путем переговоров споры между Сторонами подлежат разрешению в Арбитражном Суде г. Москвы в соответствии с действующими нормами законодательства РФ. </li>
      </ol>
    </li>
    <li style="padding-bottom: 10px;">
      <span style="font-size: 15px; font-weight: bold;">ЗАКЛЮЧИТЕЛЬНЫЕ ПОЛОЖЕНИЯ</span>
      <ol style="padding-top: 10px;">
        <li style="padding-bottom: 10px;">Договор вступает в действие с момента подписания и действует до полного исполнения Сторонами своих обязательств по настоящему Договору.</li>
        <li style="padding-bottom: 10px;">Любые изменения и дополнения к настоящему договору действительны лишь при условии, что они совершены в письменной форме и подписаны уполномоченными представителями Сторон.</li>
        <li style="padding-bottom: 10px;">Стороны обязаны незамедлительно сообщать об изменении своих почтовых адресов, банковских реквизитов, номеров телефонов, телефаксов.</li>
        <li style="padding-bottom: 10px;">Настоящий договор составлен на русском языке в двух экземплярах, имеющих одинаковую юридическую силу, по одному для каждой из Сторон.</li>
      </ol>
    </li>
    <li style="padding-bottom: 10px;">
      <span style="font-size: 15px; font-weight: bold;">АДРЕСА И БАНКОВСКИЕ РЕКВИЗИТЫ СТОРОН</span>
      <table style="margin-top: 20px; font-size: 14px; width: 100%;">
        <tr>
          <td style="width: 50%; vertical-align: top;">
            <p><strong>«Заказчик»</strong></p>
            <p>
              <?=$owner;?><br/>
              <?=$order->Address;?><br/>
              ИНН/КПП <?=$order->INN;?> / <?=$order->KPP;?><br/>
              <?=$order->BankName;?><br/>
              р/с <?=$order->Account;?><br/>
              к/с <?=$order->CorrespondentAccount;?><br/>
              БИК <?=$order->BIK;?>
            </p>
            <p>
              <?=$order->ChiefPosition;?>:<br/><br/>

              _____________________ / <?=$order->ChiefName;?>/<br/>
              м.п.
            </p>
          </td>
          <td style="width: 50%; vertical-align: top;">
            <p><strong>«Организатор»</strong></p>
            <p>ООО «Интернет Медиа Холдинг»<br/>
            123100, г. Москва, Пресненская наб., д. 12, эт. 46<br/>
            ИНН/КПП 7703725797/770301001<br/>
            Московский филиал ОАО АКБ «РОСБАНК»<br/>
            р/с 40702810697620000409<br/>
            к/с 30101810000000000272<br/>
            БИК 044583272</p>
            <p>
            Директор:<br/><br/>
            _____________________ / Гребенников С.В./<br/>
            м.п.</p>

          </td>
        </tr>
      </table>
    </li>
  </ol>
</BODY>
</HTML>