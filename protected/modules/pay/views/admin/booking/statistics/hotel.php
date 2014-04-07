<?php
/**
 * @var \pay\models\Product[] $products
 * @var array $orderItemsByProduct
 * @var array $usersFullData
 * @var array $usersTogether
 */
?>
<div class="btn-toolbar"></div>
<div class="well">
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
    <?foreach ($products as $product):?>
      <?$this->renderPartial('statistics/hotelRow', [
        'product' => $product,
        'orderItems' => isset($orderItemsByProduct[$product->Id]) ? $orderItemsByProduct[$product->Id] : [],
        'usersFullData' => $usersFullData,
        'usersTogether' => $usersTogether
      ]);?>
    <?endforeach;?>
    </tbody>
  </table>

</div>