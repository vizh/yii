<?php
/**
 * @var $products \pay\models\Product[]
 * @var $counts array
 */
?>

<div class="row">
  <div class="span12">
    <h2>Статистика питания</h2>
  </div>
</div>

<div class="row">
  <div class="span8 offset2">
    <table class="table table-bordered">
      <thead>
      <tr>
        <th class="span4">Наименование товара</th>
        <th class="span4">Куплено</th>
      </tr>
      </thead>
      <tbody>
      <?foreach ($products as $product):?>
          <tr>
            <td><?=preg_replace('/Питание в рамках участия в объединенной конференции РИФ\+КИБ 2013: /i', '', $product->Title);?></td>
            <td class="text-center"><?=isset($counts[$product->Id]) ? $counts[$product->Id] : 0;?></td>
          </tr>
      <?endforeach;?>
      </tbody>
    </table>
  </div>
</div>