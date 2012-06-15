<?
/** @var $item OrderItem */
?>
<tr>
  <td><?=$this->ProductId;?></td>
  <td><?=$this->Housing;?></td>
  <td><?=$this->Category;?></td>
  <td><?=$this->Number;?></td>
  <td><?=$this->Price;?></td>
  <td><?if ($this->Visible == 0):?><span class="label notice">скрыт</span><?endif;?></td>
  <?if (!isset($this->Keys[0]) || $this->Keys[0] != 0):?>
  <td class="room-product-info" colspan="<?=isset($this->Keys[0]) ? $this->Keys[0] : $this->Max;?>">
    <span class="label">свободен</span>
  </td>
  <?endif;?>
  <?
  foreach ($this->Keys as $i => $key):
    $item = $this->Items[$key];
    $delta = intval((strtotime($item->GetParam('DateOut')->Value) - strtotime($item->GetParam('DateIn')->Value)) / (24*60*60));
  ?>
    <td class="room-product-info" colspan="<?=$delta;?>">
      <span class="label <?=$item->Paid != 0 ? 'success' : 'warning';?>"><?=$item->Paid != 0 ? 'куплен' : 'бронь';?></span>
      <?if ($item->Paid == 0 && $item->Booked != null):?><br><em>до <?=date('d.m.Y H:i', strtotime($item->Booked));?></em><?endif;?>
      <br><strong>RocID:</strong> <a target="_blank" href="http://rocid.ru/<?=$item->Payer->RocId;?>"><?=$item->Payer->RocId;?></a>
    </td>
    <?if (isset($this->Keys[$i+1])):?>
      <?if (($key + $delta) != $this->Keys[$i+1]):?>
      <td class="room-product-info" colspan="<?=$this->Keys[$i+1]-$key - $delta;?>">
        <span class="label">свободен</span>
      </td>
      <?endif;?>
    <?else:?>
      <?if (($key+$delta) != $this->Max):?>
      <td class="room-product-info" colspan="<?=$this->Max-$key - $delta;?>">
        <span class="label">свободен</span>
      </td>
      <?endif;?>
    <?endif;?>
  <?endforeach;?>
  <td></td>
</tr>