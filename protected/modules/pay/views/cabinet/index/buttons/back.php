<?php
/**
 * @var \pay\models\Account $account
 */
?>
<a href="<?=$account->ReturnUrl===null ? $this->createUrl('/pay/cabinet/register') : $account->ReturnUrl;?>" class="btn btn-large">
  <i class="icon-circle-arrow-left"></i>
  <?=\Yii::t('app', 'Назад');?>
</a>