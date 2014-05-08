<?/** @var \pay\models\Product[] $products */?>

<div class="row-fluid">
  <div class="span12">
    <?=\CHtml::form('', 'POST', ['class' => 'products','target' => '_self']);?>
      <table class="table table-condensed">
        <thead>
        <tr>
          <th></th>
          <th class="t-right col-width"><?=Yii::t('app', 'Цена');?></th>
          <th class="t-center col-width"><?=Yii::t('app', 'Кол-во');?></th>
          <th class="t-right col-width"><?=Yii::t('app', 'Сумма');?></th>
        </tr>
        </thead>
        <tbody>
        <?foreach ($products as $product):?>
          <?if (sizeof($product->PricesActive) > 1):?>
            <tr>
              <td colspan="4">
                <article>
                  <h4 class="article-title"><?=$product->Title;?></h4>
                  <?if (!empty($product->Description)):?>
                    <p><?=$product->Description;?></p>
                  <?endif;?>
                </article>
              </td>
            </tr>
          <?endif;?>
          <?foreach ($product->PricesActive as $price):?>
            <?
            $curTime = date('Y-m-d H:i:s');
            $isMuted = $curTime < $price->StartTime;
            $mutedClass = $isMuted ? 'muted' : '';
            ?>
            <tr data-price="<?=$price->Price;?>">
              <?if (sizeof($product->PricesActive) > 1):?>
                <td class="<?=$mutedClass?>">
                  <?
                  $title = $price->Title;
                  if (empty($title))
                  {
                    if ($price->EndTime !== null)
                      $title = \Yii::t('app', 'При регистрации онлайн до').' '.\Yii::app()->dateFormatter->format('d MMMM', $price->EndTime);
                    else
                      $title = \Yii::t('app', 'При регистрации онлайн с').' '.\Yii::app()->dateFormatter->format('d MMMM', $price->StartTime).' '.\Yii::t('app', 'или на входе').' ('.$event->getFormattedStartDate('dd MMMM').')';
                  }
                  ?>
                  <?=$title;?>
                </td>
              <?else:?>
                <td style="padding-top: 20px; padding-bottom: 20px;" class="<?=$mutedClass?>">
                  <strong style="margin-bottom: 15px;"><?=$product->Title;?></strong>
                </td>
              <?endif;?>

              <td class="t-right <?=$mutedClass?>">
                <?if ($price->Price != 0):?>
                  <span class="number"><?=$price->Price;?></span> <?=Yii::t('app', 'руб.');?>
                <?else:?>
                  <?=Yii::t('app', 'бесплатно');?>
                <?endif;?>
              </td>
              <td class="t-center <?=$mutedClass?>">
                <?=\CHtml::dropDownList('ProductCount['.$product->Id.']', 0, [0,1,2,3,4,5,6,7,8,9], ['class' => 'input-mini form-element_select']);?>
              </td>
              <td class="t-right <?=$mutedClass?>"><b class="number mediate-price">0</b> <?=Yii::t('app', 'руб.');?></td>
            </tr>
          <?endforeach;?>
        <?endforeach;?>
        <tr>
          <td colspan="4" class="t-right total">
            <span><?=Yii::t('app', 'Итого');?>:</span> <b id="total-price" class="number">0</b> <?=Yii::t('app', 'руб.');?>
          </td>
        </tr>
        </tbody>
      </table>
      <div class="clearfix">
        <img src="/img/pay/pay-methods.png" class="pull-left" alt="<?=\Yii::t('app', 'Поддерживаемые способы оплаты');?>"/>
        <?/*
        <?if ($account->PayOnline):?>
          <a style="margin-top: -2px; display: inline-block;" href="http://money.yandex.ru" target="_blank"><img src="http://money.yandex.ru/img/yamoney_logo88x31.gif " alt="Я принимаю Яндекс.Деньги" title="Я принимаю Яндекс.Деньги" border="0" /></a>
        <?endif;?>
        */?>
        <?=\CHtml::submitButton(\Yii::t('app', 'Зарегистрироваться'), ['class' => 'btn btn-info pull-right']);?>
      </div>
    <?\CHtml::endForm();?>
  </div>
</div>