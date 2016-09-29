<?php
/**
 * @var \pay\models\Account $account
 * @var string $system
 */
?>
<?=\CHtml::link('&nbsp;', ['/pay/mailru/index', 'type' => $system, 'eventIdName' => $this->account->Event->IdName], $this->getHtmlOptions($system))?>