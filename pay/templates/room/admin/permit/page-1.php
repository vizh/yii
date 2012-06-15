<?php
/** @var $orderItem OrderItem */
$orderItem = $this->OrderItem;
?>
<page orientation="P">
<table style="border: 1px solid #aaaaaa;">

  <tr>
    <td>
      <table style="width: 100%;">
        <tr>
          <td><img width="350" src='http://rocid.ru/files/permit/logo_350.png'></td>
          <td style="text-align: right; font-size: 16px; padding: 10px 10px 10px 140px;">
            <p style="margin: 5px 0;">Пансионат</p>
            <p style="margin: 5px 0;">Корпус</p>
            <p style="margin: 5px 0;">Комната</p>
          </td>
          <td style="width: 30mm; background: black; color: white; font-size: 16px; font-weight: bold; text-align: center; padding: 10px 10px 0 10px;">
            <?if (isset($orderItem)):?>
            <p style="margin: 5px 0;"><?=$orderItem->Product->GetAttribute('Hotel')->Value;?></p>
            <p style="margin: 5px 0;"><?=$orderItem->Product->GetAttribute('Housing')->Value;?></p>
            <p style="margin: 5px 0;"><?=$orderItem->Product->GetAttribute('Number')->Value;?></p>
            <?else:?>
            <p style="margin: 5px 0;">&mdash;</p>
            <p style="margin: 5px 0;">&mdash;</p>
            <p style="margin: 5px 0;">&mdash;</p>
            <?endif;?>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <tr>
    <td style="padding: 5px; border-top: 1px solid #aaaaaa;">
      <table style="width: 100%;">
        <tr valign="top">
          <td style="width: 160mm;">
            <b>ПРОЖИВАЮЩИЙ:</b><br><?=$orderItem->Owner->LastName;?>&nbsp;<?=$orderItem->Owner->FirstName;?>&nbsp;<?=$orderItem->Owner->FatherName;?>, <?=$this->Role;?><br><br>
            <?if (isset($arPayedServices['auto'])):?><b>ДАННЫЕ АВТОМОБИЛЯ:</b><br><?=mb_strtoupper($arPayedServices['auto']['number']);?>,&nbsp;<?=mb_strtoupper($arPayedServices['auto']['car_brand']);?>&nbsp;<?=$arPayedServices['auto']['model_car'];?><?endif;?>
          </td>
          <td style="text-align: center; vertical-align: top;"><img width="80" height="80" src="http://rocid.ru/user/dm/<?=$orderItem->Owner->RocId;?>/"><br><?=$orderItem->Owner->RocId;?></td>
        </tr>
      </table>
    </td>
  </tr>

  <?if (isset($orderItem)):?>
  <?
  // Формирование Пансионата питания
  $arFoodPlace = array('breakfast' => '', 'lunch' => '', 'dinner' => '', 'banquet' => '');
  if (!empty($this->Food))
  {
    if (!empty($orderItem))
    {
      switch($orderItem->Product->GetAttribute('Hotel')->Value)
      {
        case 'ЛЕСНЫЕ ДАЛИ': $arFoodPlace = array('breakfast' => 'Лесные дали', 'lunch' => 'Лесные дали', 'dinner' => 'Лесные дали', 'banquet' => 'Лесные дали'); break;
        case 'ПОЛЯНЫ': $arFoodPlace = array('breakfast' => 'Поляны', 'lunch' => 'Поляны', 'dinner' => 'Поляны', 'banquet' => 'Лесные дали'); break;
        case 'НАЗАРЬЕВО': $arFoodPlace = array('breakfast' => 'Назарьево', 'lunch' => 'Лесные дали', 'dinner' => 'Лесные дали', 'banquet' => 'Лесные дали'); break;
      }
    }
    else
    {
      $arFoodPlace = array('breakfast' => 'Лесные дали', 'lunch' => 'Лесные дали', 'dinner' => 'Лесные дали', 'banquet' => 'Лесные дали');
    }
  }

  // Формирование времени питания в зависимости от места проживания и дня

  // завтраки
  $breakfastTime = '8:30 - 10:00';
  if (!empty($orderItem))
  {
    switch ($orderItem->Product->GetAttribute('Hotel')->Value)
    {
      case 'ЛЕСНЫЕ ДАЛИ': $breakfastTime = '8:30 - 10:00'; break;
      case 'ПОЛЯНЫ': $breakfastTime = '8:00 - 10:00'; break;
      case 'НАЗАРЬЕВО': $breakfastTime = '7:30 - 10:00'; break;
    }
  }

  // питание во все дни
  $arFoodTime = array(
    17 => array('завтрак' => '&mdash;', 'обед' => '&mdash;', 'ужин' => '19:00 - 21:00', 'фуршет' => '&mdash;'),
    18 => array('завтрак' => $breakfastTime, 'обед' => '14:30 - 15:30', 'ужин' => '&mdash;', 'фуршет' => '20:30 - 23:00'),
    19 => array('завтрак' => $breakfastTime, 'обед' => '14:30 - 16:30', 'ужин' => '20:30 - 22:00', 'фуршет' => '&mdash;'),
    20 => array('завтрак' => $breakfastTime, 'обед' => '14:30 - 16:00', 'ужин' => '19:00 - 21:00', 'фуршет' => '&mdash;'),
  );

  // Кофе-брейк
  $arFoodBreak = array(
    17 => '&mdash;',
    18 => '12:00, 17:30',
    19 => '12:00, 18:00',
    20 => '12:30',
  );
  ?>
  <tr>
    <td style="font-size: 10px;">
      <table>
        <tr>
          <th rowspan="3" style="width: 60px;">Дата</th>
          <th rowspan="3" style="width: 70px;">Проживание<br>(въезд/выезд<br>в 17:00)</th>
          <th colspan="9">Питание</th>
        </tr>
        <tr>
          <th colspan="2" style="width: 100px;">Завтрак<br><?=$arFoodPlace['breakfast'];?></th>
          <th colspan="2" style="width: 100px;">Обед<br><?=$arFoodPlace['lunch'];?></th>
          <th colspan="2" style="width: 100px;">Ужин<br><?=$arFoodPlace['dinner'];?></th>
          <th colspan="2" style="width: 100px;">Фуршет<br><?=$arFoodPlace['banquet'];?></th>
          <th rowspan="2" style="width: 70px;">Кофе-брейк<br>(30 минут)</th>
        </tr>
        <tr>
          <th>время</th>
          <th>заказ</th>
          <th>время</th>
          <th>заказ</th>
          <th>время</th>
          <th>заказ</th>
          <th>время</th>
          <th>заказ</th>
        </tr>
        <?for($date = 17; $date <= 20; $date++):?>
        <tr style="text-align: center;">
          <td style="padding: 5px;"><?=$date?> апреля</td>
          <td style="padding: 5px;">
            <?
            if(!empty($orderItem))
            {
              $dateIn = date('d', strtotime($orderItem->GetParam('DateIn')->Value));
              $dateOut = date('d', strtotime($orderItem->GetParam('DateOut')->Value));
              ($date >= $dateIn && $date <= $dateOut) ? print '&radic;' : print '';
            }
            else
            {
              print '';
            }
            ?>
          </td>
          <?foreach(array('завтрак', 'обед', 'ужин', 'фуршет') as $foodType):?>
          <td style="padding: 5px;"><?=$arFoodTime[$date][$foodType];?>
          </td>
          <td style="padding: 5px;">
            <?
            if(!empty($this->Food))
            {
              $isFood = false;
              foreach($this->Food as $foodTitle)
              {
                $pattern = "/$date апреля, $foodType/i";
                if (preg_match($pattern, $foodTitle))
                {
                  $isFood = true;
                  break;
                }
              }
              ($isFood) ? print '&radic;' : print '';
            }
            else
            {
              print '';
            }
            ?>
          </td>
          <?endforeach;?>
          <td><?=$arFoodBreak[$date];?></td>
        </tr>
        <?endfor;?>
      </table>
    </td>
  </tr>
  <?endif;?>
</table>

<table style="margin-top: 10px;">
  <tr valign="top">
    <td style="width: 34px;"><img src="http://rocid.ru/files/permit/icon_reg.png"></td>
    <td style="font-size:16px; width: 100mm;">Режим работы стойки регистрации<br><span style="font-size: 10px;">(регистрация участников, оплата участия)<br>КПП &laquo;Лесные дали&raquo;</span></td>

    <td style="width: 34px;"><img src="http://rocid.ru/files/permit/icon_org.png"></td>
    <td style="font-size:16px; width: 75mm;">Режим работы стойки орг.комитета<br><span style="font-size: 10px;">(выдача отчётных документов, оплата доп.услуг, отметка командировочных удостоверений, орг.вопросы)<br>Холл главного корпуса &laquo;Лесные дали&raquo;</span></td>
  </tr>

  <tr valign="top">
    <td colspan="2">
      <table cellpadding="5" style="border: 1px solid #dddddd;">
        <tr align="center">
          <th style="width: 100px;">Дата</th>
          <th style="width: 70px;">Начало</th>
          <th style="width: 70px;">Окончание</th>
        </tr>
        <tr align="center">
          <td style="padding: 5px;">17 апреля</td>
          <td style="padding: 5px;">14:00</td>
          <td style="padding: 5px;">24:00</td>
        </tr>
        <tr align="center">
          <td style="padding: 5px;">18 апреля</td>
          <td style="padding: 5px;">7:40</td>
          <td style="padding: 5px;">22:00</td>
        </tr>
        <tr align="center">
          <td style="padding: 5px;">19 апреля</td>
          <td style="padding: 5px;">8:00</td>
          <td style="padding: 5px;">19:30</td>
        </tr>
        <tr align="center">
          <td style="padding: 5px;">20 апреля</td>
          <td style="padding: 5px;">8:00</td>
          <td style="padding: 5px;">18:30</td>
        </tr>
      </table>
    </td>

    <td colspan="2">
      <table cellpadding="5" style="border: 1px solid #dddddd;">
        <tr align="center">
          <th style="width: 100px;">Дата</th>
          <th style="width: 70px;">Начало</th>
          <th style="width: 70px;">Окончание</th>
        </tr>
        <tr align="center">
          <td style="padding: 5px;">17 апреля</td>
          <td style="padding: 5px;">15:30</td>
          <td style="padding: 5px;">21:00</td>
        </tr>
        <tr align="center">
          <td style="padding: 5px;">18 апреля</td>
          <td style="padding: 5px;">8:00</td>
          <td style="padding: 5px;">21:00</td>
        </tr>
        <tr align="center">
          <td style="padding: 5px;">19 апреля</td>
          <td style="padding: 5px;">8:00</td>
          <td style="padding: 5px;">20:00</td>
        </tr>
        <tr align="center">
          <td style="padding: 5px;">20 апреля</td>
          <td style="padding: 5px;">8:00</td>
          <td style="padding: 5px;">20:00</td>
        </tr>
      </table>
    </td>

  </tr>
</table>

<h4>Памятка участника:</h4>
<table>
  <tr>
    <th colspan="4" style="width: 160mm;">
      <table>
        <tr>
          <td style="padding: 0;"><div style="position: relative; border: 1px solid; border-radius: 7px; width: 8px; margin: 0; padding: 0px 2px;">1</div></td>
          <td style="padding-left: 20px; text-align: left; width: 85mm;">Распечатать путевой лист</td>
          <td></td>
        </tr>
      </table>
    </th>
  </tr>
  <tr>
    <th colspan="4">
      <table>
        <tr>
          <td style="padding: 0;"><div style="position: relative; border: 1px solid; border-radius: 7px; width: 8px; margin: 0; padding: 0px 2px;">2</div></td>
          <td style="padding-left: 20px; text-align: left; width: 85mm;">Выбрать вид транспорта</td>
          <td><img src="http://rocid.ru/files/permit/icon_transport.png"></td>
        </tr>
      </table>
    </th>
  </tr>
  <tr>
    <th colspan="4">
      <table>
        <tr>
          <td style="padding: 0;"><div style="position: relative; border: 1px solid; border-radius: 7px; width: 8px; margin: 0; padding: 0px 2px;">3</div></td>
          <td style="padding-left: 20px; text-align: left; width: 85mm;">Зарегистрироваться на РИФ+КИБ</td>
          <td><img src="http://rocid.ru/files/permit/icon_reg.png" height="20"></td>
        </tr>
      </table>
    </th>
  </tr>
  <tr>
    <th colspan="4">
      <table>
        <tr>
          <td style="padding: 0;"><div style="position: relative; border: 1px solid; border-radius: 7px; width: 8px; margin: 0; padding: 0px 2px;">4</div></td>
          <td style="padding-left: 20px; text-align: left; width: 85mm;">Оплатить дополнительные услуги</td>
          <td><img src="http://rocid.ru/files/permit/icon_reg.png" height="20">&nbsp;&nbsp;<img src="http://rocid.ru/files/permit/icon_org.png" height="20"></td>
        </tr>
      </table>
    </th>
  </tr>

  <tr>
    <th colspan="3">
      <table>
        <tr>
          <td style="padding: 0;"><div style="position: relative; border: 1px solid; border-radius: 7px; width: 8px; margin: 0; padding: 0px 2px;">5</div></td>
          <td style="padding-left: 20px; text-align: left; width: 80mm;">Заселиться в пансионат</td>
          <td></td>
        </tr>
      </table>
    </th>
    <th rowspan="2" style="background: #ECEC00;">
      <table>
        <tr valign="top" align="left">
          <td style="font-size: 14px;">
            Оплата дополнительных услуг:
            <ul>
              <li style="font-size: 10px;">Регистрационный взнос</li>
              <li style="font-size: 10px;">Питание на мероприятии</li>
              <li style="font-size: 10px;">Билет на банкет</li>
              <li style="font-size: 10px;">Подписка на журнал &laquo;Интернет в Цифрах&raquo;</li>
            </ul>
          </td>
          <td align="right"><img src="http://rocid.ru/files/permit/icon_reg.png">&nbsp;&nbsp;<img src="http://rocid.ru/files/permit/icon_org.png"></td>
        </tr>
      </table>
    </th>
  </tr>
  <tr valign="top">
    <th style="width: 25mm;">Лесные Дали<br><br><span style="font-size: 8px; font-weight: normal;">Т-образный перекрёсток, поворот направо (28,5 км)</span></th>
    <th style="width: 25mm;">Поляны<br><br><span style="font-size: 8px; font-weight: normal;">Т-образный перекрёсток, поворот налево (28,5 км)</span></th>
    <th style="width: 25mm;">Назарьево<br><br><span style="font-size: 8px; font-weight: normal;">Поворот налево на 2-е Успенское ш. (22 км)</span></th>
  </tr>

  <tr>
    <th colspan="4">
      <table>
        <tr>
          <td style="padding: 0;"><div style="position: relative; border: 1px solid; border-radius: 7px; width: 8px; margin: 0; padding: 0px 2px;">6</div></td>
          <td style="padding-left: 20px; text-align: left; width: 85mm;">Посетить выставку и конференцию РИФ+КИБ</td>
          <td></td>
        </tr>
      </table>
    </th>
  </tr>
  <tr>
    <th colspan="4">
      <table>
        <tr>
          <td style="padding: 0;"><div style="position: relative; border: 1px solid; border-radius: 7px; width: 8px; margin: 0; padding: 0px 2px;">7</div></td>
          <td style="padding-left: 20px; text-align: left; width: 85mm;">Получить отчётные документы <br>и оформить командировочное удостоверение</td>
          <td><img src="http://rocid.ru/files/permit/icon_org.png" height="20"></td>
        </tr>
      </table>
    </th>
  </tr>


  <tr>
    <th colspan="4">
      <table>
        <tr>
          <td style="padding: 0;"><div style="position: relative; border: 1px solid; border-radius: 7px; width: 8px; margin: 0; padding: 0px 2px;">!</div></td>
          <td style="padding-left: 20px; text-align: left; width: 85mm;">Получить доступ к сети Интернет</td>
          <td><img src="http://rocid.ru/files/permit/icon_wifi.png" height="20"></td>
        </tr>
      </table>
    </th>
  </tr>

  <tr>
    <td colspan="4" style="font-size: 9px;">Обращаем внимание участников конференции на то, что официальной точкой доступа в Интернет является BeeLine Wi-Fi Free. При загрузке стартовой страницы Beeline для дальнейшей работы необходимо ввести персональный логин пользователя в соответствующем окне. Логин напечатан на обратной стороне бейджа, который выдаётся каждому участнику при регистрации.<br>ВНИМАНИЕ! Полученный код действует единовременно только с одного устройства! Параллельное использование нескольких невозможно, для их смены необходимо отключить предыдущее от Сети.</td>
  </tr>

</table>
</page>