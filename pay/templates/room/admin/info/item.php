<?php
/** @var $product Product */
$product = $this->Product;
?>

<tr>
  <td><?=$product->ProductId;?></td>
  <td><?=$product->GetAttribute('TechnicalNumber')->Value;?></td>
  <td><?=$product->GetAttribute('Hotel')->Value;?></td>
  <td><?=$product->GetAttribute('Housing')->Value;?></td>
  <td><?=$product->GetAttribute('Category')->Value;?></td>
  <td><?=$product->GetAttribute('Number')->Value;?></td>
  <td><?=$product->GetAttribute('EuroRenovation')->Value;?></td>
  <td><?=$product->GetAttribute('RoomCount')->Value;?></td>
  <td><?=$product->GetAttribute('SleepCount')->Value;?></td>
  <td><?=$product->GetAttribute('BedCount')->Value;?></td>
  <td><?=$product->GetAttribute('RoomDescription')->Value;?></td>
  <td><?=$product->GetAttribute('AdditionalDescription')->Value;?></td>
  <td><?=$product->GetAttribute('Price')->Value;?></td>
</tr>