<?php
/**
 * @var \pay\models\Account $account
 * @var string $system
 */
?>
<a href="<?=\Yii::app()->createAbsoluteUrl('/pay/cabinet/pay', ['eventIdName' => $this->getEvent()->IdName, 'type' => $system]);?>" class="btn btn-large <?=$system;?>" target="_top">&nbsp;</a>

<span class="payonline"></span>