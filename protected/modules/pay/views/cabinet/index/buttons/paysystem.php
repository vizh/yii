<?php
/**
 * @var \pay\models\Account $account
 * @var string $system
 */
?>
<a href="<?=$this->createUrl('/pay/cabinet/pay', ['type' => $system]);?>" class="btn btn-large btn-primary <?=$system;?>"><?=\Yii::t('app', 'Оплатить через');?></a>