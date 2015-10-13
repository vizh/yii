<?php
/**
 * @var PublicMainController $this
 * @var EventPayItem[] $wait
 * @var EventPayItem[] $paid
 */

use user\controllers\events\EventPayItem;
use application\components\controllers\PublicMainController;

$this->setPageTitle(\Yii::t('app', 'Мои заказы'));
?>

<h2 class="b-header_large light">
    <div class="line"></div>
    <div class="container">
        <div class="title">
            <span class="backing runet">Runet</span>
            <span class="backing text">Мои заказы</span>
        </div>
    </div>
</h2>
<div class="user-account-settings">
    <div class="clearfix">
        <div class="container">
            <div class="row">
                <div class="span3">
                    <?= $this->renderPartial('parts/nav', ['current' => $this->getAction()->getId()]); ?>
                </div>
                <div class="span9">
                    <?php if (empty($wait) && empty($paid)): ?>
                        <div class="alert alert-danger text-center">У вас нет заказов</div>
                    <?php else: ?>
                        <div class="tabs" id="user-account-settings-tabs">
                            <ul class="nav">
                                <?php if (!empty($wait)):?>
                                    <li><a href="#user-account-settings_pay-wait"><?=\Yii::t('app', 'Ожидают оплаты');?></a></li>
                                <?php endif;?>
                                <?php if (!empty($paid)):?>
                                    <li><a href="#user-account-settings_pay-paid"><?=\Yii::t('app', 'Оплачено');?></a></li>
                                <?php endif;?>
                            </ul>
                            <?php if (!empty($wait)): ?>
                                <div class="tab" id="user-account-settings_pay-wait">
                                    <?php foreach ($wait as $item): ?>
                                        <?$this->renderPartial('pay/item', ['item' => $item, 'showCabinetBtn' => true]);?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif;?>

                            <?php if (!empty($paid)): ?>
                                <div class="tab" id="user-account-settings_pay-paid">
                                    <?php foreach ($paid as $item): ?>
                                        <?$this->renderPartial('pay/item', ['item' => $item]);?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif;?>
                        </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
