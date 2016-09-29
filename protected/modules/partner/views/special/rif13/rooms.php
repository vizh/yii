<?php
/**
 * @var $hotel string
 * @var $counts array
 * @var $orderItems array
 */
?>

<div class="row">
  <div class="span12">
    <h2>Информация по проживанию (<?=$hotel?>)</h2>

    <ul class="breadcrumb">
      <?foreach($counts as $key => $value):?>
        <?if($key != $hotel):?>
          <li><a href="<?=Yii::app()->createUrl('/partner/special/rooms', array('hotel' => $key))?>"><?=$key?> (<?=$value?>)</a><span class="divider"></span></li>
        <?else:?>
          <li class="active"><?=$key?> (<?=$value?>)<span class="divider"></span></li>
        <?endif?>
      <?endforeach?>
    </ul>
  </div>
</div>

<div class="row">
  <div class="span12">
    <table class="table table-bordered">
      <thead>
      <tr>
        <th class="span4">Описание номера</th>
        <th class="span2">Дата</th>
        <th class="span2">Статус</th>
        <th class="span4">Данные заказа</th>
      </tr>
      </thead>
      <tbody>
      <?foreach($orderItems as $list):?>
        <?
        /** @var $list \pay\models\OrderItem[] */

        /** @var $manager \pay\components\managers\RoomProductManager */
        $manager = $list['product']->getManager();
        $flag = false;
       ?>
        <tr>
        <td rowspan="<?=sizeof($list['items'])?>">
          <strong>Номер: <?=$manager->Number?></strong> <span class="muted">(Id: <?=$list['product']->Id?>)</span><br>
          <?=$manager->Housing?>, <?=$manager->Category?><br>
          Всего мест: <?=$manager->PlaceTotal?> (основных - <?=$manager->PlaceBasic?>, доп. - <?=$manager->PlaceMore?>)<br>
          <em><?=$manager->DescriptionBasic?>, <?=$manager->DescriptionMore?></em><br>
          <!--<p class="text-error"><strong>Цена за сутки: <?//$manager->Price?></strong></p>-->
          <?if($manager->Visible == 0):?>
            <span class="label label-inverse">Номер скрыт</span>
          <?endif?>
        </td>
        <?foreach($list['items'] as $date => $items):?>
          <?/** @var $items \pay\models\OrderItem[] */?>
          <?if($flag):?><tr><?endif?>
            <td><?=$date?></td>

            <?if(sizeof($items) !== 0):?>
            <td>
              <?foreach($items as $item):?>
                  <?if($item->Paid):?>
                  <span class="label label-success">Оплачен</span>
                  <?else:?>
                  <span class="label label-warning">Забронирован</span><br>
                  <em>До: <?=$item->Booked?></em>
                  <?endif?>
              <?endforeach?>
              <?if(sizeof($items) > 1):?>
                <span class="label label-important">Множественное бронирование номера</span>
              <?endif?>
            </td>
            <td>
              <?foreach($items as $item):?>
                <a target="_blank" href="<?=Yii::app()->createUrl('/user/view/index', array('runetId' => $item->Payer->RunetId))?>"><?=$item->Payer->RunetId?></a> <?=$item->Payer->getFullName()?><br>
                <em><?=$item->Payer->Email?></em><br>
                <?if($this->action->hasOtherRoom($item->Payer->Id, $item->Id)):?>
                  <span class="label label-important">Возможно повторное бронирование</span>
                <?endif?>
              <?endforeach?>
            </td>


            <?else:?>
        <td>
              <span class="label">Свободен</span>
        </td>
            <td></td>
            <?endif?>

          </tr>
          <?$flag = true;
        endforeach?>
      <?endforeach?>
      </tbody>
    </table>
  </div>
</div>
