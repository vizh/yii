<?php
/**
 * @var $orderItems \pay\models\OrderItem[]
 */
?>
<div class="row">
  <div class="span12">
    <h2>Статистика броней</h2>
  </div>
</div>


<div class="row">
  <div class="span12">
    <table class="table table-bordered">
      <thead>
      <tr>
        <th>Время окончания брони</th>
        <th>Информация о номере</th>
        <th>ФИО</th>
        <th>Email</th>
        <th>Телефон</th>
      </tr>
      </thead>
      <tbody>
      <?foreach($orderItems as $item):?>
          <tr>
            <td><?=date('d-m-Y', strtotime($item->Booked))?></td>
            <td>
              <?
              /** @var $manager \pay\components\managers\RoomProductManager */
              $manager = $item->Product->getManager();
             ?>
            <strong>Номер: <?=$manager->Number?></strong> <span class="muted">(Id: <?=$item->Product->Id?>)</span><br>
            <?=$manager->Housing?>, <?=$manager->Category?><br>
            Всего мест: <?=$manager->PlaceTotal?> (основных - <?=$manager->PlaceBasic?>, доп. - <?=$manager->PlaceMore?>)<br>
            <em><?=$manager->DescriptionBasic?>, <?=$manager->DescriptionMore?></em><br>
            <p class="text-error"><strong>Цена за сутки: <?=$manager->Price?></strong></p>

            </td>
            <td><?=$item->Payer->getFullName()?>, <em><?=$item->Payer->RunetId?></em></td>
            <td><?=$item->Payer->Email?></td>
            <td><?=sizeof($item->Payer->LinkPhones) > 0 ? (string)$item->Payer->LinkPhones[0]->Phone : ''?></td>
          </tr>
      <?endforeach?>
      </tbody>
    </table>
  </div>
</div>

