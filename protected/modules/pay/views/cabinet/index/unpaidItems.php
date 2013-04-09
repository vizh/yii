<?php
/**
 * @var $unpaidItems array
 * @var $hasRecentPaidItems bool
 * @var $this CabinetController
 * @var $account \pay\models\Account
 */

$total = 0;
?>

<?if (sizeof($unpaidItems) > 0):?>

  <table class="table thead-actual">
    <thead>
    <tr>
      <th><?=\Yii::t('app', 'Тип билета');?></th>
      <th class="col-width t-right"><?=\Yii::t('app', 'Цена');?></th>
      <th class="col-width t-right"><?=\Yii::t('app', 'Кол-во');?></th>
      <th class="col-width t-right last-child"><?=\Yii::t('app', 'Сумма');?></th>
    </tr>
    </thead>
  </table>

  <?foreach ($unpaidItems as $key => $items):?>
    <?
    /** @var $items \pay\models\OrderItem[] */
    $product = $items[0]->Product;
    ?>
    <table class="table">
      <thead>
      <tr>
        <th colspan="2"><h4 class="title"><?=$product->Title;?> <i class="icon-chevron-up"></i></h4></th>
        <th class="col-width t-right"><span class="number"><?=$product->getPrice();?></span> <?=Yii::t('app', 'руб.');?></th>
        <th class="col-width t-right"><b class="number"><?=sizeof($items);?></b></th>
        <th class="col-width t-right last-child"><b class="number"><?=$product->getPrice()*sizeof($items);?></b> <?=Yii::t('app', 'руб.');?></th>
      </tr>
      </thead>
      <tbody>
      <?foreach ($items as $item):?>
        <?$total += $item->getPriceDiscount();?>
        <tr>
          <td style="padding-left: 10px; width: 15px;">
            <a href="<?=$this->createUrl('/pay/cabinet/deleteitem', array('orderItemId' => $item->Id));?>"><i class="icon-trash"></i></a>
          </td>
          <td>
            <?=$item->Owner->getFullName();?>
          </td>
          <td colspan="3" class="t-right muted last-child">
            <?if ($item->getPriceDiscount() < $item->getPrice()):?>
              <?=\Yii::t('app', 'Промо-код');?> <?=$item->getCouponActivation()->Coupon->Code;?>: <b class="number">-<?=$item->getPrice() - $item->getPriceDiscount();?></b> <?=Yii::t('app', 'руб.');?>
            <?endif;?>
          </td>
        </tr>
      <?endforeach;?>
      </tbody>
    </table>
  <?endforeach;?>

  <div class="total">
    <span><?=\Yii::t('app', 'Итого');?>:</span> <b class="number"><?=\Yii::app()->numberFormatter->format('#,##0.00', $total);?></b> <?=Yii::t('app', 'руб.');?>
  </div>

  <div style="width: 500px; margin: 0 auto; margin-bottom: 40px;">
    <label class="checkbox">
      <input type="checkbox" name="agreeOffer" value="1"/><?=\Yii::t('app', 'Я согласен с условиями <a target="_blank" href="{url}">договора-оферты</a> и готов перейти к оплате', array('{url}' => $this->createUrl('/pay/cabinet/offer')));?>
    </label>
  </div>
  <div class="actions clearfix">
    <a href="<?=$account->ReturnUrl===null ? $this->createUrl('/pay/cabinet/register') : $account->ReturnUrl;?>" class="btn btn-large">
      <i class="icon-circle-arrow-left"></i>
      <?=\Yii::t('app', 'Назад');?>
    </a>
    <?if ($account->EventId == 422):?>
      <a href="<?=$this->createUrl('/pay/cabinet/pay', array('type' => 'uniteller'));?>" class="btn btn-large btn-primary uniteller"><?=\Yii::t('app', 'Оплатить через');?></a>
      <a href="<?=$this->createUrl('/pay/cabinet/pay');?>" class="btn btn-large btn-primary payonline"><?=\Yii::t('app', 'Оплатить через');?></a>
    <?else:?>
      <a href="<?=$this->createUrl('/pay/cabinet/pay');?>" class="btn btn-large btn-primary"><?=\Yii::t('app', 'Оплатить картой или эл. деньгами');?></a>
    <?endif;?>
    <a href="<?=$this->createUrl('/pay/cabinet/pay', array('type' => 'paypal'));?>" class="btn btn-large btn-primary paypal"><?=\Yii::t('app', 'Оплатить через');?> <img src="/img/pay/logo-paypal.png" alt=""></a>
    <?if ($account->EventId != 422):?>
      <a href="<?php echo $this->createUrl('/pay/juridical/create/');?>" class="btn btn-large"><?=\Yii::t('app', 'Выставить счет');?> <span class="muted"><?=\Yii::t('app', '(для юр. лиц)');?></span></a>
    <?endif;?>
  </div>

  <?if ($account->EventId == 422):?>
  <div class="actions clearfix">
    <a href="<?php echo $this->createUrl('/pay/juridical/create/');?>" class="btn btn-large"><?=\Yii::t('app', 'Выставить счет');?> <span class="muted"><?=\Yii::t('app', '(для юр. лиц)');?></span></a>
  </div>
  <?endif;?>

<?else:?>

  <style type="text/css">
    .event-register .alert {
      margin: 0 40px 40px;
    }
  </style>
  <?if (!$hasRecentPaidItems):?>
    <div class="alert alert-error"><?=\Yii::t('app', 'У вас нет товаров для оплаты.');?></div>
  <?else:?>
    <div class="alert alert-success"><?=\Yii::t('app', 'Вы недавно оплатили участие или активировали промо-код. Список оплаченых товаров можно посмотреть ниже.');?></div>
  <?endif;?>

  <div class="actions">
    <a href="<?=$account->ReturnUrl===null ? $this->createUrl('/pay/cabinet/register') : $account->ReturnUrl;?>" class="btn btn-large">
      <i class="icon-circle-arrow-left"></i>
      <?=\Yii::t('app', 'Назад');?>
    </a>
  </div>

<?endif;?>