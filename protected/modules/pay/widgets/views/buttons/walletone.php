<?php
/**
 * @var \pay\widgets\PayButtons $this
 * @var \pay\models\Account $account
 * @var string $system
 */
?>
<?=\CHtml::link('&nbsp;', ['/pay/cabinet/pay', 'type' => $system, 'eventIdName' => $this->account->Event->IdName], $this->getHtmlOptions($system))?>
<script src="https://www.walletone.com/merchant/widget/1.0.1/script.js"></script>
<div id="w1widget"></div>
<script>
    W1.widget({
        "pt": "SberOnlineRUB,PsbRetailRUB,MtsRUB,BeelineRUB",
        "bigLogo": false,
        "grayscale": false,
        "background": "white",
        "fixWidth": "300",
        "container": "w1widget"
    });
</script>