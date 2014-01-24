<?php
/**
 * @var string[] $productNames
 * @var \pay\models\Product[] $products
 * @var array $values
 * @var string $error
 */
?>

<div class="row">
  <div class="span12">

    <?=CHtml::beginForm();?>

    <h3>Выберите соответствие столбцов и полей данных</h3>

    <?if ($error):?>
      <div class="alert alert-error">
        <p>Необходимо заполнить все товары!</p>
      </div>
    <?endif;?>

    <table class="table table-bordered">
      <thead>
      <tr>
        <td>Поле из файла</td>
        <td>Товар</td>
      </tr>
      </thead>
      <tbody>
      <?foreach ($productNames as $name):?>
        <tr>
          <td><?=$name;?></td>
          <td>
            <select name="values[<?=!empty($name) ? $name : 0;?>]">
              <option value="0">не задан</option>
              <option value="-1">нет товара</option>
              <?foreach ($products as $product):?>
                <option value="<?=$product->Id;?>" <?=isset($values[$name]) && $values[$name] == $product->Id ? 'selected="selected"' : '';?>><?=$product->Title;?></option>
              <?endforeach;?>
            </select>
          </td>
        </tr>
      <?endforeach;?>
      </tbody>
    </table>

    <div class="control-group">
      <div class="controls">
        <input type="submit" value="Продолжить" class="btn"/>
      </div>
    </div>

    <?=CHtml::endForm();?>
  </div>
</div>