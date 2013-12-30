<?php
/**
 * @var \event\widgets\Registration $this
 * @var \pay\models\Product[] $products
 * @var \pay\models\Account $account
 */
?>

  <?=CHtml::beginForm(\Yii::app()->createUrl('/pay/cabinet/register', array('eventIdName' => $this->event->IdName)), 'POST', array('class' => 'event-registration registration'));?>
  <?=\CHtml::hiddenField(\Yii::app()->request->csrfTokenName, \Yii::app()->request->getCsrfToken()); ?>
  <header>
    <h3 class="title">Регистрация</h3>

    <?if (isset($this->RegistrationBeforeInfo)):?>
      <?=$this->RegistrationBeforeInfo;?>
    <?endif;?>
  </header>

  <?foreach ($products as $product):?>
    <article>
      <h4 class="article-title"><?=$product->Title;?></h4>
      <p><?=$product->Description;?></p>
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
      <?$dateFormatter = \Yii::app()->dateFormatter;?>
      <?foreach ($product->Prices as $key => $price):
        $curTime = date('Y-m-d H:i:s');
        $isMuted = $curTime < $price->StartTime || ($price->EndTime != null && $curTime > $price->EndTime);
        ?>
        <tr data-price="<?=$price->Price;?>">

          <?if (!$isMuted):?><td><strong><?else:?><td class="muted"><?endif;?>

            <?if ($key == 0 && $price->EndTime != null):?>
              При регистрации до <?=$dateFormatter->format('d MMMM', $price->EndTime);?>
            <?elseif ($key != 0 && $price->EndTime != null):?>
              При регистрации c <?=$dateFormatter->format('d MMMM', $price->StartTime);?> по <?=$dateFormatter->format('d MMMM', $price->EndTime);?>
            <?else:?>
              При регистрации с <?=$dateFormatter->format('d MMMM', $price->StartTime);?> и на входе
            <?endif;?>

            <?if (!$isMuted):?></strong><?endif;?></td>
          <td class="t-right price <?=$isMuted?'muted':'';?>"><strong><?=$price->Price;?></strong> руб.</td>
          <td class="t-center">
            <?
            $inpParams = array(
                'class' => 'input-mini'
            );
            if ($isMuted)
            {
              $inpParams['disabled'] = 'disabled';
            }
            echo CHtml::dropDownList('count['.$product->Id.']', 0,array(0,1,2,3,4,5,6,7,8,9,10), $inpParams);?>
          </td>
          <td class="t-right totalPrice <?=$isMuted?'muted':'';?>"><strong class="mediate-price">0</strong> руб.</td>
        </tr>
      <?endforeach;?>
      </tbody>
    </table>
  <?endforeach;?>

  <div class="t-right total">
    <span>Итого: </span><strong id="total-price">0</strong> руб.
  </div>

  <div class="t-center">
    <button class="btn btn-large btn-success" type="submit">Зарегистрироваться</button>
  </div>
  <?php echo CHtml::endForm();?>
