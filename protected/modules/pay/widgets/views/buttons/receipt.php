<?php
/**
 * @var \pay\models\Account $account
 */
?>
<?=\CHtml::link(\Yii::t('app', 'Квитанция на оплату'), ['/pay/receipt/index/', 'eventIdName' => $this->account->Event->IdName], $this->getHtmlOptions($system))?>