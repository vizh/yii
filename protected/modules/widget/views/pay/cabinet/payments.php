<?php
/**
 *  @var $account \pay\models\Account
 */

$hideJuridical = $account->OrderLastTime !== null && $account->OrderLastTime < date('Y-m-d H:i:s') || !$account->OrderEnable;
$hideReceipt = $account->ReceiptLastTime !== null && $account->ReceiptLastTime < date('Y-m-d H:i:s') || !$account->ReceiptEnable;

$paysystems = ['uniteller', 'payonline', 'yandexmoney', 'paypal'];
$onlinemoney = ['yandexmoney', 'paypal'];

$systembuttons = [];
$paybuttons = [];
if ($account->Uniteller)
  $systembuttons[] = 'uniteller';
if ($account->PayOnline)
{
  $systembuttons[] = 'payonline';
  $paybuttons[] = 'yandexmoney';
}
$paybuttons[] = 'paypal';
if ($account->MailRuMoney)
  $paybuttons[] = 'mailrumoney';
?>

<div class="pay-buttons clearfix">
  <div class="pull-left">
    <h5><?=\Yii::t('app', 'Для юридических лиц');?></h5>
    <?if (!$account->OrderEnable):?>
      <p class="text-error"><?=\Yii::t('app', 'Оплата недоступна. Оплата возможна только банковскими картами и электронными деньгами');?></p>
    <?elseif ($hideJuridical && $account->OrderEnable):?>
      <p class="text-error">Окончен период выставления счетов юридическими лицами. Оплата возможна только банковскими картами и электронными деньгами.</p>
    <?elseif(!$hideJuridical):?>
      <?$this->renderPartial('cabinet/buttons/juridical', ['account' => $account]);?>
    <?endif;?>
  </div>
  <div class="pull-right">
    <h5><?=\Yii::t('app', 'Для физических лиц');?></h5>
    <ul class="clearfix actions pay-systems">
      <?foreach ($systembuttons as $button):?>
        <li>
          <?$this->renderPartial('cabinet/buttons/'. $button, ['account' => $account, 'system' => $button]);?>
        </li>
      <?endforeach;?>
    </ul>

    <h5><?=\Yii::t('app', 'Электронные деньги');?></h5>
    <ul class="clearfix actions">
      <?foreach ($paybuttons as $button):?>
        <li>
          <?$this->renderPartial('cabinet/buttons/'.(in_array($button, $paysystems) ? 'onlinemoney' : $button), ['account' => $account, 'system' => $button]);?>
        </li>
      <?endforeach;?>
    </ul>

    <?if (!$hideReceipt):?>
    <h5><?=\Yii::t('app', 'Квитанцией в банке');?></h5>
    <ul class="clearfix actions">
      <li>
        <?$this->renderPartial('cabinet/buttons/receipt', ['account' => $account, 'system' => $button]);?>
      </li>
    </ul>
    <?endif;?>
  </div>
</div>

<div class="nav-buttons">
  <?$this->renderPartial('cabinet/buttons/back', ['account' => $account]);?>
</div>
