<?php
/** @var $items OrderItem[] */
$items = $this->Items;
$total = 0;
?>

<div class="row">
  <div class="span16">
    <?if (!empty($this->OrderId)):?>
    <h1>Информация по счету № <?=$this->OrderId;?></h1>
    <?elseif (!empty($this->User)):?>
    <h1>Информация о заказах пользователя <?=$this->User->LastName;?> <?=$this->User->FirstName;?> (<?=$this->User->RocId;?>)</h1>
    <?endif;?>
  </div>

  <div class="span16">
    <?if (!empty($this->Error)):?>
    <div class="alert-message error">
      <p><strong>Возникла ошибка!</strong> <?=$this->Error;?></p>
    </div>
    <?endif;?>
  </div>

  <div class="span16">
    <h3>Всего услуг: <?=sizeof($items);?></h3>
  </div>

  <table>
    <tr>
      <th>Наименование</th>
      <th>ФИО плательщика</th>
      <th>ФИО получателя</th>
      <th>Стоимость</th>
      <th>Статус</th>
    </tr>
    <?foreach ($items as $item):
    ?>
    <tr>
      <td><?=$item->Product->ProductManager()->GetTitle($item);?></td>
      <td><?=$item->Payer->LastName;?> <?=$item->Payer->FirstName;?> <?=$item->Payer->FatherName;?> (<?=$item->Payer->RocId;?>)</td>
      <td><?=$item->Owner->LastName;?> <?=$item->Owner->FirstName;?> <?=$item->Owner->FatherName;?> (<?=$item->Owner->RocId;?>)</td>
      <td><?$price = $item->PriceDiscount(); $total += $price; echo $price;?> руб.</td>
      <td>
        <?if ($item->Paid == 1):?>
        <span class="label success">оплачен</span>
        <?else:?>
        <span class="label">не оплачен</span>
        <?if ($item->Booked != null):?>
          <br><em>до <?=date('d.m.Y H:i', strtotime($item->Booked));?></em>
        <?endif;?>
        <?endif;?>
      </td>
    </tr>
    <?endforeach;?>

    <tr>
      <td></td>
      <td></td>
      <td><h4>Итого</h4></td>
      <td colspan="2"><h4><?=$total;?> руб.</h4></td>
    </tr>
  </table>

  <div class="span16">
    <a class="btn large" href="<?=RouteRegistry::GetAdminUrl('main', '', 'info');?>">Назад</a>
  </div>
</div>