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
      <th><?=\Yii::t('pay', 'Тип билета');?></th>
      <th class="col-width t-right"><?=\Yii::t('pay', 'Цена');?></th>
      <th class="col-width t-right"><?=\Yii::t('pay', 'Кол-во');?></th>
      <th class="col-width t-right last-child"><?=\Yii::t('pay', 'Сумма');?></th>
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
        <th colspan="2"><h4 class="title"><?=\Yii::t('pay', $product->Title);?> <i class="icon-chevron-up"></i></h4></th>
        <th class="col-width t-right"><span class="number"><?=$product->getPrice();?></span> Р</th>
        <th class="col-width t-right"><b class="number"><?=sizeof($items);?></b></th>
        <th class="col-width t-right last-child"><b class="number"><?=$product->getPrice()*sizeof($items);?></b> Р</th>
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
              <?=\Yii::t('pay', 'Промо-код');?> <?=$item->getCouponActivation()->Coupon->Code;?>: <b class="number">-<?=$item->getPrice() - $item->getPriceDiscount();?></b> Р
            <?endif;?>
          </td>
        </tr>
      <?endforeach;?>
      </tbody>
    </table>
  <?endforeach;?>

  <div class="total">
    <span><?=\Yii::t('pay', 'Итого');?>:</span> <b class="number"><?=\Yii::app()->numberFormatter->format('#,##0.00', $total);?></b> Р
  </div>

  <div style="width: 500px; margin: 0 auto; margin-bottom: 40px;">
    <label class="checkbox">
      <input type="checkbox" name="agreeOffer" value="1"/><?=\Yii::t('pay', 'Я согласен с условиями <a href="{url}">договора-оферты</a> и готов перейти к оплате', array('{url}' => $this->createUrl('/pay/cabinet/offer')));?>
    </label>
  </div>
  <div class="actions clearfix">
    <a href="<?=$account->ReturnUrl===null ? $this->createUrl('/pay/cabinet/register') : $account->ReturnUrl;?>" class="btn btn-large">
      <i class="icon-circle-arrow-left"></i>
      <?=\Yii::t('pay', 'Назад');?>
    </a>
    <a href="<?=$this->createUrl('/pay/cabinet/pay');?>" class="btn btn-large btn-primary"><?=\Yii::t('pay', 'Оплатить картой или эл. деньгами');?></a>
    <a href="<?=$this->createUrl('/pay/cabinet/pay', array('type' => 'paypal'));?>" class="btn btn-large btn-primary paypal"><?=\Yii::t('pay', 'Оплатить через');?> <img src="/img/pay/logo-paypal.png" alt=""></a>
    <a href="<?php echo $this->createUrl('/pay/juridical/create/');?>" class="btn btn-large"><?=\Yii::t('pay', 'Выставить счет');?> <span class="muted"><?=\Yii::t('pay', '(для юр. лиц)');?></span></a>
  </div>

<?else:?>

  <style type="text/css">
    .event-register .alert {
      margin: 0 40px 40px;
    }
  </style>
  <?if (!$hasRecentPaidItems):?>
    <div class="alert alert-error"><?=\Yii::t('pay', 'У вас нет товаров для оплаты.');?></div>
  <?else:?>
    <div class="alert alert-success"><?=\Yii::t('pay', 'Вы недавно оплатили участие или активировали промо-код. Список оплаченых товаров можно посмотреть ниже.');?></div>
  <?endif;?>

  <div class="actions">
    <a href="<?=$account->ReturnUrl===null ? $this->createUrl('/pay/cabinet/register') : $account->ReturnUrl;?>" class="btn btn-large">
      <i class="icon-circle-arrow-left"></i>
      <?=\Yii::t('pay', 'Назад');?>
    </a>
  </div>

<?endif;?>