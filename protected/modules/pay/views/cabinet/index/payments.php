<?php
/**
 *  @var $account \pay\models\Account
 */

$hideJuridical = $account->OrderLastTime !== null && $account->OrderLastTime < date('Y-m-d H:i:s') || !$account->OrderEnable;
$hideReceipt = $account->ReceiptLastTime !== null && $account->ReceiptLastTime < date('Y-m-d H:i:s') || !$account->ReceiptEnable;

$paysystems = ['uniteller', 'payonline', 'yandexmoney', 'paypal'];
$paybuttons = [];
if ($account->Uniteller)
  $paybuttons[] = 'uniteller';
if ($account->PayOnline)
{
  $paybuttons[] = 'payonline';
  $paybuttons[] = 'yandexmoney';
}
$paybuttons[] = 'paypal';
if ($account->MailRuMoney)
  $paybuttons[] = 'mailrumoney';
if (!$hideReceipt)
{
  $paybuttons[] = 'receipt';
}
$i = 0;
?>

<div class="pay-buttons clearfix">
  <div class="pull-left">
    <h5><?=\Yii::t('app', 'Для юридических лиц');?></h5>
    <?if (!$account->OrderEnable):?>
      <p class="text-error"><?=\Yii::t('app', 'Оплата недоступна. Оплата возможна только банковскими картами и электронными деньгами');?></p>
    <?elseif ($hideJuridical && $account->OrderEnable):?>
      <p class="text-error">Окончен период выставления счетов юридическими лицами. Оплата возможна только банковскими картами и электронными деньгами.</p>
    <?elseif(!$hideJuridical):?>
      <?$this->renderPartial('index/buttons/juridical', ['account' => $account]);?>
    <?endif;?>
  </div>
  <div class="pull-right">
    <h5><?=\Yii::t('app', 'Для физических лиц');?></h5>
    <ul class="clearfix actions">
      <?foreach ($paybuttons as $button):?>
        <li>
          <?$this->renderPartial('index/buttons/'.(in_array($button, $paysystems) ? 'paysystem' : $button), ['account' => $account, 'system' => $button]);?>
        </li>
      <?endforeach;?>
    </ul>
  </div>
</div>

<div class="nav-buttons">
  <?$this->renderPartial('index/buttons/back', ['account' => $account]);?>
</div>
