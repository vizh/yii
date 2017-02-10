<?php
/**
 * @var \pay\models\Account $account
 * @var string $system
 */
?>
<?= \CHtml::link('&nbsp;', ['/pay/cabinet/pay', 'type' => $system, 'eventIdName' => $this->account->Event->IdName], $this->getHtmlOptions($system)) ?>
    <span class="payonline"></span>
<?php if (!$this->controller->getUser()->PayonlineRebill || $this->controller->getUser()->PayonlineRebill =='pending'): ?>
    <?php $this->widget('application\widgets\bootstrap\Modal', [
            'header' => '&nbsp;',
            'id' => 'payonline-modal',
            'htmlOptions' => ['style' => 'width:750px;']
    ]); ?>
<?php endif; ?>