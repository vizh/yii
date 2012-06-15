<?
/** @var $item OrderItem */
?>
<tr>
  <td><?=$this->ProductId;?></td>
  <td><?=$this->Housing;?></td>
  <td><?=$this->Category;?></td>
  <td><?=$this->Number;?></td>
  <td><?=$this->Price;?></td>
  <td></td>
  <?foreach ($this->Items as $key => $value):?>
  <td class="room-product-info">
    <?if (empty($value)):?>
    <span class="label">свободен</span>
    <?else:?>
    <span class="label <?=$value->Paid != 0 ? 'success' : 'warning';?>"><?=$value->Paid != 0 ? 'куплен' : 'бронь';?></span>
      <?if ($value->Paid == 0 && $value->Booked != null):?>
      <br><em>до <?=date('d.m.Y H:i', strtotime($value->Booked));?></em>
      <?endif;?>
    <?endif;?>
  </td>
  <?endforeach;?>
  <td></td>
</tr>