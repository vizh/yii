<?php $this->pageTitle = 'Мои заказы';?>
<?php
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/javascripts/jquerry-tabs.js');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/stylesheets/jquerry-tabs.css');
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
                        <div class="tabs">
                            <ul>
                                <?= !empty($waitOrders) ? '<li>Ожидают оплаты</li>' : '' ?>
                                <?= !empty($pastOrders) ? '<li>Оплачено</li>' : '' ?>
                            </ul>
                            <div class="inner-tab">
                                <?php if (!empty($waitOrders)): ?>
                                    <div>
                                        <?php foreach ($waitOrders as $orderItem): ?>
                                            <div class="eventOrders">
                                                <h4><?= $orderItem[0]['Item']->Product->Event->Title ?></h4>
                                                <h5>Заказы</h5>
                                                <table>
                                                    <?php foreach ($orderItem as $order): ?>
                                                        <tr>
                                                            <td class="eventTitle"><?= $order['Item']->Product->Title ?></td>
                                                            <td class="orderPrice">
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
                                                                                <td class="eventTitle">
                                                                                    <a href="<?= $order->getUrl() ?>">Счет
                                                                                        № <?= $order->Number ?></a>
                                                                                </td>
                                                                                <td class="orderPrice">
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
                                    <div>
                                        <? foreach ($pastOrders as $orderItem) : ?>
                                            <div class="eventOrders">
                                                <h4><?= $orderItem[0]['Item']->Product->Event->Title ?></h4>
                                                <h5>Заказы</h5>
                                                <table>
                                                    <? foreach ($orderItem as $order): ?>
                                                        <tr>
                                                            <td class="eventTitle"><?= $order['Item']->Product->Title ?></td>
                                                            <td class="orderPrice"><?= $order['Item']->getPriceDiscount() ?>
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
                                                                        <td class="eventTitle">
                                                                            <a href="<?= $order->getUrl() ?>">Счет
                                                                                № <?= $order->Number ?></a>
                                                                        </td>
                                                                        <td class="orderPrice">
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
