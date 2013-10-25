<?php
/**
 *  @var $account \pay\models\Account
 */

$hideJuridical = $account->OrderLastTime !== null && $account->OrderLastTime < date('Y-m-d H:i:s') || !$account->OrderEnable;
$hideReceipt = $account->ReceiptLastTime !== null && $account->ReceiptLastTime < date('Y-m-d H:i:s') || !$account->ReceiptEnable;

$paysystems = ['uniteller', 'payonline', 'yandexmoney', 'paypal'];

$buttons = ['back'];
if ($account->Uniteller)
  $buttons[] = 'uniteller';
if ($account->PayOnline)
{
  $buttons[] = 'payonline';
  $buttons[] = 'yandexmoney';
}
$buttons[] = 'paypal';
if (!$hideReceipt)
{
  $buttons[] = 'receipt';
}
if (!$hideJuridical)
{
  $buttons[] = 'juridical';
}
$i = 0;
?>

<?while ($i < count($buttons)):?>
  <div class="actions clearfix">
    <?for ($j=0; $j<4 && $i < count($buttons); $j++, $i++):?>
      <?if (in_array($buttons[$i], $paysystems)):?>
          <?$this->renderPartial('index/buttons/paysystem', ['account' => $account, 'system' => $buttons[$i]]);?>
      <?else:?>
        <?$this->renderPartial('index/buttons/'.$buttons[$i], ['account' => $account]);?>
      <?endif;?>
    <?endfor;?>
  </div>
<?endwhile;?>

<?if ($hideJuridical && $account->OrderEnable):?>
  <div class="actions clearfix">
    <div class="row">
      <div class="offset2 span8">
        <p class="text-error">Окончен период выставления счетов юридическими лицами. Оплата возможна только банковскими картами и электронными деньгами.</p>
      </div>
    </div>
  </div>
<?endif;?>