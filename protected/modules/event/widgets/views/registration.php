<?php
/**
 * @var \event\widgets\Registration $this
 * @var \pay\models\Product[] $products
 * @var \pay\models\Account $account
 * @var \event\models\Participant $participant
 */
if (empty($products))
  return;

$paidEvent = false;
?>
<form method="post" action="<?=\Yii::app()->createUrl('/pay/cabinet/register', array('eventIdName' => $this->event->IdName));?>" class="registration event-registration">
  <?= \CHtml::hiddenField(\Yii::app()->request->csrfTokenName, \Yii::app()->request->getCsrfToken()); ?>

  <?if ($participant !== null && $participant->RoleId != 24):?>
    <p class="text-success" style="font-size: 16px; line-height: 20px; margin: 15px 0 30px;">
      <strong><?=Yii::app()->user->getCurrentUser()->getFullName();?></strong>,<br>
      <?=Yii::t('app', 'Вы зарегистрированы на');?> «<?=$this->event->Title;?>».<br>
      <?=Yii::t('app', 'Ваш статус')?> - <strong><?=$participant->Role->Title;?></strong><br>
      <a target="_blank" href="<?=$participant->getTicketUrl();?>"><?=Yii::t('app', 'Скачать электронный билет');?></a>
      <?if (isset($this->RegistrationAfterInfo)):?>
      <br><br><span class="muted" style="font-size: 14px; line-height: 16px;"><?=$this->RegistrationAfterInfo;?></span>
      <?endif;?>
    </p>

    <h5 class="title"><?=Yii::t('app', 'Регистрация других участников');?></h5>
  <?else:?>
    <h5 class="title"><?=isset($this->RegistrationTitle) ? $this->RegistrationTitle : \Yii::t('app', 'Регистрация');?></h5>

      <?if (isset($this->RegistrationBeforeInfo)):?>
        <?=$this->RegistrationBeforeInfo;?>
      <?endif;?>

  <?endif;?>


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
      <?if (sizeof($product->PricesActive) > 1 || !empty($product->Description)):?>
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
            $paidEvent = $paidEvent || $price->Price > 0;
        ?>
        <tr data-price="<?=$price->Price;?>">
          <?if (sizeof($product->PricesActive) > 1 || !empty($product->Description)):?>
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
              <?if (Yii::app()->getLanguage() == 'en'):?>
                <br><span class="muted" style="font-size: 85%;">approx. <?=round($price->Price/47);?> eur</span>
              <?endif;?>
            <?else:?>
              <?=Yii::t('app', 'бесплатно');?>
            <?endif;?>
          </td>
          <td class="t-center <?=$mutedClass?>">
            <select <?if($isMuted):?>disabled="disabled"<?endif;?> name="count[<?=$product->Id;?>]" class="input-mini form-element_select">
              <option value="0" selected>0</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
            </select>
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
      <?if ($paidEvent):?>
          <img src="/img/pay/pay-methods.png" class="pull-left" alt="Поддерживаемые способы оплаты"/>
          <a style="margin-top: -2px; display: inline-block;" href="http://money.yandex.ru" target="_blank"><img src="http://money.yandex.ru/img/yamoney_logo88x31.gif " alt="Я принимаю Яндекс.Деньги" title="Я принимаю Яндекс.Деньги" border="0" /></a>
      <?endif;?>
    <button type="submit" class="btn btn-info pull-right">
        <?if (isset($this->RegistrationBuyLabel)):?>
            <?=$this->RegistrationBuyLabel;?>
        <?else:?>
          <?if ($participant !== null && $participant->RoleId != 24):?>
            <?=Yii::t('app', $paidEvent ? 'Оплатить (за себя или коллег)' : 'Зарегистрировать коллег');?>
          <?else:?>
            <?=Yii::t('app', 'Зарегистрироваться');?>
          <?endif;?>
        <?endif;?>
    </button>
  </div>
</form>