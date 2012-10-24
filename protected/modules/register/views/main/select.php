<?php echo CHtml::beginForm('', 'POST', array('class' => 'event-registration'));?>
  <header>
    <h3 class="title">Регистрация</h3>
  </header>
  <?php foreach ($products as $product):?>
    <article>
      <h4 class="article-title"><?php echo $product->Title;?></h4>
      <p><?php echo $product->Description;?></p>
    </article>
  
    <table class="table table-condensed">
      <thead>
        <tr>
          <th></th>
          <th class="t-right">Цена</th>
          <th class="t-center">Кол-во</th>
          <th class="t-right">Сумма</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($product->Prices as $key => $price):?>
          <tr data-price="<?php echo $price->Price;?>">
            <td <?php if ($key > 0):?>class="muted"<?php endif;?>>
              <?php if ($price->EndTime !== null):?>
                <strong>При регистрации до <?php echo Yii::app()->dateFormatter->format('dd MMMM yyyy', $price->EndTime);?></strong>
              <?php else:?>
                <strong>При регистрации <?php echo Yii::app()->dateFormatter->format('dd MMMM yyyy', $price->StartTime);?> и на входе</strong>
              <?php endif;?>
            </td>
            <td class="t-right price"><strong><?php echo Yii::app()->numberFormatter->formatDecimal($price->Price);?></strong> руб.</td>
            <td class="t-center">
              <?php
                $htmlOptions = array(
                  'class' => 'input-mini'
                );
                if ($key > 0)
                {
                  $htmlOptions['disabled'] = 'disabled';
                }
              ?>  
              <?php echo CHtml::activeDropDownList($orderForm, 'Count['.$product->ProductId.']', array(0,1,2,3,4,5,6,7,8,9,10), $htmlOptions);?>
            </td>
            <td class="t-right totalPrice"><strong>0</strong> руб.</td>
          </tr>
        <?php endforeach;?>     
      </tbody>
    </table>
  <?php endforeach;?>

  <div class="t-right total">
    <span>Итого:</span><strong id='grandTotal'>0</strong> руб.
  </div>

  <div class="t-center">
    <button class="btn btn-large btn-success">Зарегистрироваться</button>
  </div>
<?php echo CHtml::endForm();?>
