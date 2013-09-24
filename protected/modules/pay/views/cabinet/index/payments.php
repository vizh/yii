<?php
/**
 *  @var $account \pay\models\Account
 */

$hideJuridical = $account->OrderLastTime !== null && $account->OrderLastTime < date('Y-m-d H:i:s') || !$account->OrderEnable;
?>

  <div class="actions clearfix">
    <a href="<?=$account->ReturnUrl===null ? $this->createUrl('/pay/cabinet/register') : $account->ReturnUrl;?>" class="btn btn-large">
      <i class="icon-circle-arrow-left"></i>
      <?=\Yii::t('app', 'Назад');?>
    </a>

    <?if ($account->Uniteller):?>
      <a href="<?=$this->createUrl('/pay/cabinet/pay', ['type' => 'uniteller']);?>" class="btn btn-large btn-primary uniteller"><?=\Yii::t('app', 'Оплатить через');?></a>
    <?endif;?>

    <?if ($account->PayOnline):?>
      <a href="<?=$this->createUrl('/pay/cabinet/pay');?>" class="btn btn-large btn-primary payonline"><?=\Yii::t('app', 'Оплатить через');?></a>
      <a href="<?=$this->createUrl('/pay/cabinet/pay', ['type' => 'yandexmoney']);?>" class="btn btn-large btn-primary yandexmoney"><?=\Yii::t('app', 'Оплатить через');?></a>
    <?endif;?>

    <?if (!$account->Uniteller || !$account->PayOnline):?>
      <a href="<?=$this->createUrl('/pay/cabinet/pay', array('type' => 'paypal'));?>" class="btn btn-large btn-primary paypal"><?=\Yii::t('app', 'Оплатить через');?> <img src="/img/pay/logo-paypal.png" alt=""></a>
    <?endif;?>

    <?if (!$account->PayOnline && !$hideJuridical):?>
      <a href="<?php echo $this->createUrl('/pay/juridical/create/');?>" class="btn btn-large juridical"><?=\Yii::t('app', 'Выставить счет');?> <span class="muted"><?=\Yii::t('app', '(для юр. лиц)');?></span></a>
    <?endif;?>
  </div>

<?if ($account->PayOnline):?>
<div class="actions clearfix text-right">
  <?if ($account->PayOnline && $account->Uniteller):?>
    <a href="<?=$this->createUrl('/pay/cabinet/pay', array('type' => 'paypal'));?>" class="btn btn-large btn-primary paypal"><?=\Yii::t('app', 'Оплатить через');?> <img src="/img/pay/logo-paypal.png" alt=""></a>
  <?endif;?>

  <?if (!$hideJuridical):?>
    <a href="<?php echo $this->createUrl('/pay/juridical/create/');?>" class="btn btn-large juridical"><?=\Yii::t('app', 'Выставить счет');?> <span class="muted"><?=\Yii::t('app', '(для юр. лиц)');?></span></a>
  <?endif;?>
</div>
<?endif;?>

<?if ($hideJuridical && $account->OrderEnable):?>
  <div class="actions clearfix">
    <div class="row">
      <div class="offset2 span8">
        <p class="text-error">Окончен период выставления счетов юридическими лицами. Оплата возможна только банковскими картами и электронными деньгами.</p>
      </div>
    </div>
  </div>
<?endif;?>

