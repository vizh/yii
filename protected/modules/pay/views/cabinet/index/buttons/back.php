<?php
/**
 * @var \pay\models\Account $account
 * @var PayController $this
 */

$url = $account->ReturnUrl === null ? $this->createUrl('/pay/cabinet/register') : $account->ReturnUrl;
?>
<a href="<?=$url?>" class="btn btn-large">
    <i class="icon-circle-arrow-left"></i>
    <?=\Yii::t('app', 'Назад')?>
</a>