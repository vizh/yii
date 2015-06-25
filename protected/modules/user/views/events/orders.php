<?php
/**
 * @var \application\components\controllers\PublicMainController $this
 */

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
                    <?= $this->renderPartial('parts/nav', array('current' => $this->getAction()->getId())); ?>
                </div>
                <div class="span9">
                    <?php if (empty($waitOrders) && empty($pastOrders)): ?>
                        <div class="alert alert-danger text-center">У вас нет заказов</div>
                    <?php else: ?>
                        <div class="tabs" id="user-account-settings-tabs">
                            <ul class="nav">
                                <?php if (!empty($waitOrders)):?>
                                    <li><a href="#user-account-settings_orders-wait"><?=\Yii::t('app', 'Ожидают оплаты');?></a></li>
                                <?php endif;?>
                                <?php if (!empty($pastOrders)):?>
                                    <li><a href="#user-account-settings_orders-past"><?=\Yii::t('app', 'Оплачено');?></a></li>
                                <?php endif;?>
                            </ul>
                            <?php if (!empty($waitOrders)): ?>
                                <div class="tab" id="user-account-settings_orders-wait">
                                    <?php foreach ($waitOrders as $orderItem): ?>
                                        <div class="event-orders">
                                            <h4><?= $orderItem[0]['Item']->Product->Event->Title ?></h4>
                                            <h5>Заказы</h5>
                                            <table>
                                                <?php foreach ($orderItem as $order): ?>
                                                    <tr>
                                                        <td class="event-title"><?= $order['Item']->Product->Title ?></td>
                                                        <td class="order-price">
                                                            <?= $order['Item']->getPriceDiscount() ?> руб.
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </table>
                                            <?php if (!empty($orderItem[0]['Juridical'])): ?>
                                                <h5>Счета</h5>
                                                <table>
                                                    <?php foreach ($orderItem as $order) : ?>
                                                            <tr>
                                                                <?php if (!empty($order['Juridical'])): ?>
                                                                    <?php foreach ($order['Juridical'] as $order): ?>
                                                                        <tr>
                                                                            <td class="event-title">
                                                                                <a href="<?= $order->getUrl() ?>">Счет
                                                                                    № <?= $order->Number ?></a>
                                                                            </td>
                                                                            <td class="order-price">
                                                                                <?= $order->getPrice() ?> руб.
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                        <?php else :?>
                                                            <td></td>
                                                        <?php endif; ?>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </table>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($pastOrders)): ?>
                                <div class="tab" id="user-account-settings_orders-past">
                                    <? foreach ($pastOrders as $orderItem) : ?>
                                        <div class="event-orders">
                                            <h4><?= $orderItem[0]['Item']->Product->Event->Title ?></h4>
                                            <h5>Заказы</h5>
                                            <table>
                                                <? foreach ($orderItem as $order): ?>
                                                    <tr>
                                                        <td class="event-title"><?= $order['Item']->Product->Title ?></td>
                                                        <td class="order-price"><?= $order['Item']->getPriceDiscount() ?>
                                                            руб.
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </table>
                                            <?php if (!empty($orderItem[0]['Juridical'])): ?>
                                                <h5>Счета</h5>
                                                <table>
                                                    <?php foreach ($orderItem as $order): ?>
                                                    <tr>
                                                        <?php if (!empty($order['Juridical'])): ?>
                                                            <?foreach ($order['Juridical'] as $order): ?>
                                                                <tr>
                                                                    <td class="event-title">
                                                                        <a href="<?= $order->getUrl() ?>">Счет
                                                                            № <?= $order->Number ?></a>
                                                                    </td>
                                                                    <td class="order-price">
                                                                        <?= $order->getPrice() ?> руб.
                                                                    </td>
                                                                </tr>
                                                            <?endforeach; ?>
                                                        <?php else :?>
                                                            <td></td>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </table>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".tabs").lightTabs();
    });
</script>
