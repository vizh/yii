<?php
/**
 * @var \pay\models\Account $account
 * @var PayController $this
 */

$url = $account->ReturnUrl === null ? $this->createUrl('/pay/cabinet/register') : $account->ReturnUrl;

//TODO: Костыль для devcon16
if ($this->getAccount()->EventId == 2319) {
    $account = \api\models\Account::model()->findByPk(335);
    $url = \api\components\ms\Helper::getPayUrl($account, $this->getUser());
}
?>
<a href="<?= $url; ?>" class="btn btn-large">
    <i class="icon-circle-arrow-left"></i>
    <?= \Yii::t('app', 'Назад'); ?>
</a>