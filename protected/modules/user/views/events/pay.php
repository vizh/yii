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
                    <?=$this->renderPartial('parts/nav', ['current' => $this->getAction()->getId()])?>
                </div>
                <div class="span9">
                    <?if(empty($wait) && empty($paid)):?>
                        <div class="alert alert-danger text-center">У вас нет заказов</div>
                    <?php else:?>
                        <div class="tabs" id="user-account-settings-tabs">
                            <ul class="nav">
                                <?if(!empty($wait)):?>
                                    <li><a href="#user-account-settings_pay-wait"><?=\Yii::t('app', 'Ожидают оплаты')?></a></li>
                                <?endif?>
                                <?if(!empty($paid)):?>
                                    <li><a href="#user-account-settings_pay-paid"><?=\Yii::t('app', 'Оплачено')?></a></li>
                                <?endif?>
                            </ul>
                            <?if(!empty($wait)):?>
                                <div class="tab" id="user-account-settings_pay-wait">
                                    <?foreach($wait as $item):?>
                                        <?$this->renderPartial('pay/item', ['item' => $item, 'showCabinetBtn' => true])?>
                                    <?endforeach?>
                                </div>
                            <?endif?>

                            <?if(!empty($paid)):?>
                                <div class="tab" id="user-account-settings_pay-paid">
                                    <?foreach($paid as $item):?>
                                        <?$this->renderPartial('pay/item', ['item' => $item])?>
                                    <?endforeach?>
                                </div>
                            <?endif?>
                        </div>
                    <?endif?>
                </div>
            </div>
        </div>
    </div>
</div>
