<?php
/**
 * @var $products \pay\models\Product[]
 * @var $counts array
 * @var $polyaniCounts array
 * @var $ldCounts array
 * @var $sosniCounts array
 * @var $nazarCounts array
 */
?>

<div class="row">
  <div class="span12">
    <h2>Статистика питания</h2>
  </div>
</div>

<div class="row">
  <div class="span8 offset2">
    <h3>Сосны</h3>
    <table class="table table-bordered">
      <thead>
      <tr>
        <th class="span4">Наименование товара</th>
        <th class="span4">Куплено</th>
      </tr>
      </thead>
      <tbody>
      <?foreach($products as $product):?>
          <?if(isset($sosniCounts[$product->Id])):?>
        <tr>
          <td><?=preg_replace('/Питание в рамках участия в объединенной конференции РИФ\+КИБ 2013: /i', '', $product->Title)?></td>
          <td class="text-center"><?=$sosniCounts[$product->Id]?></td>
        </tr>
          <?endif?>
      <?endforeach?>
      </tbody>
    </table>
  </div>
</div>


<div class="row">
  <div class="span8 offset2">
    <h3>Назарьево</h3>
    <table class="table table-bordered">
      <thead>
      <tr>
        <th class="span4">Наименование товара</th>
        <th class="span4">Куплено</th>
      </tr>
      </thead>
      <tbody>
      <?foreach($products as $product):?>
        <?if(isset($nazarCounts[$product->Id])):?>
          <tr>
            <td><?=preg_replace('/Питание в рамках участия в объединенной конференции РИФ\+КИБ 2013: /i', '', $product->Title)?></td>
            <td class="text-center"><?=$nazarCounts[$product->Id]?></td>
          </tr>
        <?endif?>
      <?endforeach?>
      </tbody>
    </table>
  </div>
</div>


<div class="row">
  <div class="span8 offset2">
    <h3>Лесные дали</h3>
    <table class="table table-bordered">
      <thead>
      <tr>
        <th class="span4">Наименование товара</th>
        <th class="span4">Куплено</th>
      </tr>
      </thead>
      <tbody>
      <?foreach($products as $product):?>
        <?if(isset($ldCounts[$product->Id])):?>
          <tr>
            <td><?=preg_replace('/Питание в рамках участия в объединенной конференции РИФ\+КИБ 2013: /i', '', $product->Title)?></td>
            <td class="text-center"><?=$ldCounts[$product->Id]?></td>
          </tr>
        <?endif?>
      <?endforeach?>
      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="span8 offset2">
    <h3>Поляны</h3>
    <table class="table table-bordered">
      <thead>
      <tr>
        <th class="span4">Наименование товара</th>
        <th class="span4">Куплено</th>
      </tr>
      </thead>
      <tbody>
      <?foreach($products as $product):?>
          <tr>
            <td><?=preg_replace('/Питание в рамках участия в объединенной конференции РИФ\+КИБ 2013: /i', '', $product->Title)?></td>
            <td class="text-center"><?=isset($polyaniCounts[$product->Id]) ? $polyaniCounts[$product->Id] : 0?></td>
          </tr>
      <?endforeach?>
      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="span8 offset2">
    <h3>Всего</h3>
    <table class="table table-bordered">
      <thead>
      <tr>
        <th class="span4">Наименование товара</th>
        <th class="span4">Куплено</th>
      </tr>
      </thead>
      <tbody>
      <?foreach($products as $product):?>
        <tr>
          <td><?=preg_replace('/Питание в рамках участия в объединенной конференции РИФ\+КИБ 2013: /i', '', $product->Title)?></td>
          <td class="text-center"><?=isset($counts[$product->Id]) ? $counts[$product->Id] : 0?></td>
        </tr>
      <?endforeach?>
      </tbody>
    </table>
  </div>
</div>