<?php
/**
 * @var \pay\widgets\JuridicalButton $this
 * @var \pay\models\Account $account
 */

$hideJuridical = $account->OrderLastTime !== null && $account->OrderLastTime < date('Y-m-d H:i:s') || !$account->OrderEnable;
?>
<?if(!$account->OrderEnable):?>
    <span class="text-danger"><?=!empty($account->OrderDisableMessage) ? $account->OrderDisableMessage : \Yii::t('app', 'Оплата недоступна. Оплата возможна только банковскими картами и электронными деньгами')?></span>
<?php elseif (!empty($account->OrderMinTotal) && $total < $account->OrderMinTotal):?>
    <span class="text-danger"><?=$account->OrderMinTotalMessage?></span>
<?php elseif ($hideJuridical):?>
    <span class="text-danger"><?=!empty($account->OrderDisableMessage) ? $account->OrderDisableMessage : \Yii::t('app', 'Окончен период выставления счетов юридическими лицами. Оплата возможна только банковскими картами и электронными деньгами.')?></span>
<?php else:?>
    <?=\CHtml::link(\Yii::t('app', 'Выставить счет'), $this->url, $this->htmlOptions)?>
<?endif?>
