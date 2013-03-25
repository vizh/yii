<?php
/** @var $order \pay\models\Order */
?>

<div class="row">
  <div class="span12 indent-bottom3">
    <h2>Счет №<?=$order->Id;?></h2>

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


  <div class="span6 indent-bottom3">
    <h3>Данные заказчика</h3>

    <p><strong>Название компании:</strong> <?=$order->OrderJuridical->Name;?></p>

    <p><strong>Адрес:</strong> <?=$order->OrderJuridical->Address;?></p>

    <p><strong>ИНН/КПП:</strong> <?=$order->OrderJuridical->INN;?> / <?=$order->OrderJuridical->KPP;?></p>

    <p><strong>Телефон:</strong> <?=$order->OrderJuridical->Phone;?></p>
  </div>

  <div class="span6 indent-bottom3">
    <h3>Данные пользователя</h3>

    <p><strong>rocID:</strong> <a target="_blank" href="<?=\Yii::app()->createUrl('/partner/user/edit', array('runetId' => $order->Payer->RunetId));?>"><?=$order->Payer->RunetId;?></a></p>

    <p><strong>ФИО:</strong> <?=$order->Payer->getFullName();?></p>

    <?$employment = $order->Payer->getEmploymentPrimary();?>
    <p><strong>Компания:</strong> <?=$employment != null ? $employment->Company->Name : 'не указана';?></p>

    <p><strong>Email:</strong> <?=$order->Payer->Email;?></p>

    <p><strong>Телефон:</strong> <?=!empty($order->Payer->Phones) ? urldecode($order->Payer->Phones[0]->Phone) : 'не указан';?></p>
  </div>

  <?php foreach ($order->ItemLinks as $link):?>
    <?php if ($link->OrderItem->ChangedOwner !== null):?>
      <div class="span12">
        <div class="alert alert">
          <h4>Внимание!</h4>
          В заказе произошли изменения: статус "<?=$link->OrderItem->Product->getManager()->getTitle($link->OrderItem);?>" был перенесен с пользователя <a href="<?=\Yii::app()->createUrl('/partner/user/edit', array('runetId' => $link->OrderItem->Owner->RunetId));?>"><?=$link->OrderItem->Owner->getFullName();?></a> на пользователя <a href="<?=\Yii::app()->createUrl('/partner/user/edit', array('runetId' => $link->OrderItem->ChangedOwner->RunetId));?>"><?=$link->OrderItem->ChangedOwner->getFullName();?></a>.
        </div>
      </div>
    <?php endif;?>
  <?php endforeach;?>
  
  <div class="span12 indent-bottom3">
    <h3>Состав счета</h3>

    <table class="table table-striped">
      <thead>
      <tr>
        <th>Наименование</th>
        <th>ФИО плательщика</th>
        <th>ФИО получателя</th>
        <th>Стоимость</th>
      </tr>
      </thead>
      <tbody>
      <?foreach ($order->ItemLinks as $link):
      ?>
      <tr>
        <td><?=$link->OrderItem->Product->getManager()->getTitle($link->OrderItem);?></td>
        <td><?=$link->OrderItem->Payer->getFullName();?> (<?=$link->OrderItem->Payer->RunetId;?>)</td>
        <td>
          <p><?=$link->OrderItem->Owner->getFullName();?> (<?=$link->OrderItem->Owner->RunetId;?>)</p>
          <?if ($link->OrderItem->ChangedOwner !== null):?>
            <p class="text-success m-top_10"><strong>Перенесено на пользователя</strong></p>
            <p><?=$link->OrderItem->ChangedOwner->getFullName();?> (<?=$link->OrderItem->ChangedOwner->RunetId;?>)</p>
          <?php endif;?>
        </td>
        <td><?=$link->OrderItem->getPriceDiscount();?> руб.</td>
      </tr>
      <?endforeach;?>
      </tbody>
    </table>
  </div>

  <div class="span12 indent-bottom3">
    <h3>Сумма счета: <?=$order->getPrice();?> руб.</h3>
  </div>

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
</div>