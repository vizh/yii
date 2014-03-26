<?php
/** @var $order \pay\models\Order */

$collection = \pay\components\OrderItemCollection::createByOrder($order);
?>

<div class="row">
  <div class="span12 indent-bottom3">
    <h2>Счет № <?=$order->Number;?></h2>
    <p>
      <?if ($order->Paid):?>
      <span class="label label-success">ОПЛАЧЕН</span>
      <?else:?>
        <?if (!$order->Deleted):?>
        <span class="label label-warning">НЕ ОПЛАЧЕН</span>
        <?else:?>
        <span class="label label-important">УДАЛЕН</span>
        <?endif;?>
      <?endif;?>
    </p>
  </div>

  <div class="span12 indent-bottom3">
    <?if (!empty($this->action->error)):?>
    <div class="alert alert-error">
      <p><strong>Возникла ошибка!</strong> <?=$this->action->error;?></p>

      <p>Отправьте данное сообщение на email: <a href="mailto:users@rocid.ru">users@rocid.ru</a></p>
    </div>
    <?elseif (! empty($this->action->result)):?>
    <div class="alert alert-success">
      <p><strong>Выполнено!</strong> <br> <?=$this->action->result;?></p>
    </div>
    <?endif;?>
  </div>

  <?if ($order->Type == \pay\models\OrderType::Juridical):?>
  <div class="span6 indent-bottom3">
    <h3>Данные заказчика</h3>

    <p><strong>Название компании:</strong> <?=$order->OrderJuridical->Name;?></p>

    <p><strong>Адрес:</strong> <?=$order->OrderJuridical->Address;?></p>

    <p><strong>ИНН/КПП:</strong> <?=$order->OrderJuridical->INN;?> / <?=$order->OrderJuridical->KPP;?></p>

    <p><strong>Телефон:</strong> <?=$order->OrderJuridical->Phone;?></p>
  </div>
  <?endif;?>

  <div class="span6 indent-bottom3">
    <h3>Данные пользователя</h3>

    <p><strong>rocID:</strong> <a target="_blank" href="<?=\Yii::app()->createUrl('/partner/user/edit', array('runetId' => $order->Payer->RunetId));?>"><?=$order->Payer->RunetId;?></a></p>

    <p><strong>ФИО:</strong> <?=$order->Payer->getFullName();?></p>

    <?$employment = $order->Payer->getEmploymentPrimary();?>
    <p><strong>Компания:</strong> <?=$employment != null ? $employment->Company->Name : 'не указана';?></p>

    <p><strong>Email:</strong> <?=$order->Payer->Email;?></p>

    <p><strong>Телефон:</strong> <?=!empty($order->Payer->Phones) ? urldecode($order->Payer->Phones[0]->Phone) : 'не указан';?></p>
  </div>

  <?foreach ($collection as $item):?>
    <?if ($item->getOrderItem()->ChangedOwner !== null):?>
      <div class="span12">
        <div class="alert alert">
          <h4>Внимание!</h4>
          В заказе произошли изменения: статус "<?=$item->getOrderItem()->Product->getManager()->getTitle($item->getOrderItem());?>" был перенесен с пользователя <a href="<?=\Yii::app()->createUrl('/partner/user/edit', array('runetId' => $item->getOrderItem()->Owner->RunetId));?>"><?=$item->getOrderItem()->Owner->getFullName();?></a> на пользователя <a href="<?=\Yii::app()->createUrl('/partner/user/edit', array('runetId' => $item->getOrderItem()->ChangedOwner->RunetId));?>"><?=$item->getOrderItem()->ChangedOwner->getFullName();?></a>.
        </div>
      </div>
    <?endif;?>
  <?endforeach;?>
  
  <div class="span12 indent-bottom3">
    <h3>Состав счета</h3>

    <table class="table table-striped">
      <thead>
      <tr>
        <th>Номер</th>
        <th>Наименование</th>
        <th>ФИО плательщика</th>
        <th>ФИО получателя</th>
        <th>Стоимость</th>
      </tr>
      </thead>
      <tbody>
      <?foreach ($collection as $item):
      ?>
      <tr>
        <td><?=$item->getOrderItem()->Id;?></td>
        <td>
          <?=$item->getOrderItem()->Product->getManager()->getTitle($item->getOrderItem());?>
          <?if ($item->getOrderItem()->Paid):?>
            <span class="label label-success">ОПЛАЧЕН</span>
          <?else:?>
            <span class="label label-warning">НЕ ОПЛАЧЕН</span>
          <?endif;?>
        </td>
        <td><?=$item->getOrderItem()->Payer->getFullName();?> (<?=$item->getOrderItem()->Payer->RunetId;?>)</td>
        <td>
          <p><?=$item->getOrderItem()->Owner->getFullName();?> (<?=$item->getOrderItem()->Owner->RunetId;?>)</p>
          <?if ($item->getOrderItem()->ChangedOwner !== null):?>
            <p class="text-success m-top_10"><strong>Перенесено на пользователя</strong></p>
            <p><?=$item->getOrderItem()->ChangedOwner->getFullName();?> (<?=$item->getOrderItem()->ChangedOwner->RunetId;?>)</p>
          <?php endif;?>
        </td>
        <td><?=$item->getPriceDiscount();?> руб.</td>
      </tr>
      <?endforeach;?>
      </tbody>
    </table>
  </div>


  <div class="span12 indent-bottom3">
    <h3>Сумма счета: <?=$order->getPrice();?> руб.</h3>
  </div>
  <?if (\pay\models\OrderType::getIsBank($order->Type)):?>
  <div class="span12">
    <form action="" method="post">
      <fieldset>
        <div class="clearfix">
          <button type="submit" class="btn btn-success"
            <?if ($order->Paid):?>
                  onclick="return confirm('Счет уже отмечен как оплаченный. Повторить?');"
            <?else:?>
                  onclick="return confirm('Вы уверены, что хотите отметить данный счет оплаченным?');"
            <?endif;?>
                  name="SetPaid"><i class="icon-ok icon-white"></i> Отметить как оплаченный</button>

          <?if (!$order->Deleted):?>
          <button class="btn btn-danger" type="submit" name="SetDeleted" onclick="return confirm('Вы уверены, что хотите удалить счет?');"><i class="icon-remove icon-white"></i> Удалить</button>
          <?endif;?>

          <a href="<?=\Yii::app()->createAbsoluteUrl('/pay/order/index', array('orderId' => $order->Id, 'hash' => $order->getHash()));?>" class="btn" target="_blank"><i class="icon-print"></i> Счет с печатью</a>
          <a href="<?=\Yii::app()->createAbsoluteUrl('/pay/order/index', array('orderId' => $order->Id, 'hash' => $order->getHash(), 'clear' => 'clear'));?>" class="btn" target="_blank"><i class="icon-print"></i> Счет без печати</a>
        </div>
      </fieldset>
    </form>
  </div>
  <?endif;?>
</div>