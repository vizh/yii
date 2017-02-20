<?php
/**
 * @var \pay\components\Controller $this
 * @var \event\models\Event $event
 * @var \pay\models\forms\OrderForm $orderForm
 * @var \pay\models\Account $account
 * @var \pay\models\Product[] $products
 * @var int $unpaidOwnerCount
 * @var \user\models\forms\RegisterForm $registerForm
 * @var array $countRows
 */
use pay\models\Product;

$hasTickets = !empty($products->tickets);

$paidEvent = false;
foreach ($products->all as $product) {
    $paidEvent = $paidEvent || $product->getPrice() > 0;
}

$isHideProduct = function (Product $product) use ($event, $countRows) {
    if (isset($event->RegisterHideNotSelectedProduct) && $event->RegisterHideNotSelectedProduct == 1) {
        if (array_sum($countRows) > 0 && $countRows[$product->Id] == 0) {
            return true;
        }
    }
    return false;
}
?>

<script type="text/javascript">
    payItems = [];
    <?if($orderForm->Scenario == null || $orderForm->Scenario == \pay\models\forms\OrderForm::ScenarioRegisterUser):?>
    <?if(!empty($orderForm->Items)):?>
    <?foreach($orderForm->Items as $item):?>
    <?$owner = \user\models\User::model()->byRunetId($item['RunetId'])->find()?>
    var payItem = [];
    payItem.productId = '<?=$item['ProductId']?>';
    payItem.user = {
        RunetId : '<?=$owner->RunetId?>',
        FullName : '<?=\CHtml::encode($owner->getFullName())?>'
    };
    payItem.discount = '<?=!empty($item['Discount']) ? $item['Discount'] : 0?>';
    payItem.promoCode = '<?=!empty($item['PromoCode']) ? $item['PromoCode'] : ''?>';
    payItems.push(payItem);
    <?endforeach?>
    <?endif?>
    <?endif?>
</script>

<div class="register">
    <?=\CHtml::beginForm('', 'POST', [
        'data-event-id-name' => $event->IdName,
        'data-event-id' => $event->Id,
        'data-document-required' => (isset($event->DocumentRequired) && $event->DocumentRequired == 1)
    ])?>
    <?=\CHtml::errorSummary($orderForm, '<div class="alert alert-error">', '</div>')?>
    <?if($hasTickets):?>
        <div class="clearfix m-bottom_30 scenario-selector">
            <div class="pull-left">
                <label class="radio"><?=\CHtml::activeRadioButton($orderForm, 'Scenario', ['value' => \pay\models\forms\OrderForm::ScenarioRegisterUser, 'uncheckValue' => null])?> <?=\Yii::t('app', '<strong>Я знаю кто пойдет на мероприятие</strong>, и хочу указать участников сразу')?></label>
            </div>
            <div class="pull-right">
                <label class="radio"><?=\CHtml::activeRadioButton($orderForm, 'Scenario', ['value' => \pay\models\forms\OrderForm::ScenarioRegisterTicket, 'uncheckValue' => null])?> <?=\Yii::t('app', '<strong>Я не знаю кто пойдет на мероприятие</strong>, и хочу указать участников позже')?></label>
            </div>
        </div>
    <?else:?>
        <?=\CHtml::activeHiddenField($orderForm, 'Scenario', ['value' => \pay\models\forms\OrderForm::ScenarioRegisterUser])?>
    <?endif?>


    <div <?if($hasTickets):?>style="display: none;"<?endif?> data-scenario="<?=\pay\models\forms\OrderForm::ScenarioRegisterUser?>">
        <?$this->renderPartial('register/help', ['user' => $this->getUser(), 'products' => $products, 'account' => $account, 'event' => $event,'unpaidOwnerCount' => $unpaidOwnerCount, 'paidEvent' => $paidEvent])?>
        <table class="table thead-actual">
            <thead>
            <tr>
                <th><?=\Yii::t('app', 'Тип билета')?></th>
                <th class="col-width t-right"><?=\Yii::t('app', 'Цена')?></th>
                <th class="col-width t-center"><?=\Yii::t('app', 'Кол-во')?></th>
                <th class="col-width t-right last-child"><?=\Yii::t('app', 'Сумма')?></th>
            </tr>
            </thead>
        </table>
        <?foreach($products->all as $product):?>
            <?if($isHideProduct($product)) continue?>
            <table class="table" data-product-id="<?=$product->Id?>" data-price="<?=$product->getPrice()?>" data-row-max="<?=!isset($countRows[$product->Id]) || $countRows[$product->Id] == 0 ? 1 : $countRows[$product->Id]?>" data-row-current="0">
                <thead>
                <tr>
                    <th>
                        <h4 class="title"><?=$product->Title?></h4>
                    </th>
                    <th class="col-width t-right"><span class="number"><?=$product->getPrice()?></span> <?=Yii::t('app', 'руб.')?></th>
                    <th class="col-width t-center"><span class="number quantity"></span></th>
                    <th class="col-width t-right last-child"><b class="number mediate-price">0</b> <?=Yii::t('app', 'руб.')?></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        <?endforeach?>
        <div class="total">
            <span><?=Yii::t('app', 'Итого')?>:</span> <b id="total-price" class="number">0</b> <?=Yii::t('app', 'руб.')?>
        </div>
    </div>

    <?if($hasTickets):?>
        <div style="display: none;" data-scenario="<?=\pay\models\forms\OrderForm::ScenarioRegisterTicket?>">
            <?$this->renderPartial('register/help-ticket', ['user' => $this->getUser(), 'products' => $products, 'account' => $account, 'event' => $event,'unpaidOwnerCount' => $unpaidOwnerCount, 'paidEvent' => $paidEvent])?>
            <table class="table thead-actual">
                <thead>
                <tr>
                    <th><?=\Yii::t('app', 'Тип билета')?></th>
                    <th class="col-width t-right"><?=\Yii::t('app', 'Цена')?></th>
                    <th class="t-center" style="width: 30px;"><?=\Yii::t('app', 'Кол-во')?></th>
                    <th class="col-width t-right last-child"><?=\Yii::t('app', 'Сумма')?></th>
                </tr>
                </thead>
                <?foreach($products->tickets as $i => $product):?>
                    <tbody>
                    <tr data-product-id="<?=$product->Id?>" data-price="<?=$product->getPrice()?>">
                        <td><?=$product->getManager()->getPaidProduct()->Title?></td>
                        <td class="t-right"><span class="number"><?=$product->getPrice()?></span> <?=Yii::t('app', 'руб.')?></td>
                        <td class="t-center">
                            <?
                            $value = \CHtml::resolveValue($orderForm, 'Items['.$i.'][Count]');
                            if ($value == null)
                            {
                                $value = isset($countRows[$product->getManager()->ProductId]) ? $countRows[$product->getManager()->ProductId] : 0;
                            }
                            echo \CHtml::dropDownList(\CHtml::activeName($orderForm, 'Items['.$i.'][Count]'), $value, range(0, 10),  ['class' => 'input-mini'])?>
                        </td>
                        <td class="t-right"><b class="number mediate-price">0</b> <?=Yii::t('app', 'руб.')?></td>
                    </tr>
                    </tbody>
                    <?=\CHtml::activeHiddenField($orderForm, 'Items['.$i.'][ProductId]', ['value' => $product->Id])?>
                <?endforeach?>
            </table>
            <div class="total">
                <span><?=Yii::t('app', 'Итого')?>:</span> <b id="total-price" class="number">0</b> <?=Yii::t('app', 'руб.')?>
            </div>
        </div>
    <?endif?>

    <div class="nav-buttons">
        <a href="#" onclick="$('.register form').trigger('submit'); return false;" class="btn btn-large btn-info <?if($hasTickets):?>disabled<?endif?>">
            <?=\Yii::t('app', 'Продолжить')?>
            <i class="icon-circle-arrow-right icon-white"></i>
        </a>
    </div>
    <?=\CHtml::endForm()?>
</div>

<script type="text/template" id="row-tpl">
    <tr class="user-row">
        <td>
            <div class="p-relative">
                <input type="text" class="form-element_text input-user" placeholder="<?=Yii::t('app', 'Введите ФИО или RUNET-ID')?>">
            </div>
        </td>
        <td class="discount" data-discount="0"></td>
        <td colspan="2" class="last-child">
            <button class="btn btn-inverse btn-register pull-right" style="display: none;"><?=Yii::t('app', 'Зарегистрировать')?></button>
        </td>
    </tr>
</script>

<script type="text/template" id="row-withdata-tpl">
    <tr class="user-row">
        <td>
            <div class="p-relative">
                <input type="text" class="form-element_text input-user no-disabled" placeholder="Введите ФИО или RUNET-ID" value="<%=item.FullName%>, RUNET-ID <%=item.RunetId%>" disabled>
                <i class="icon-remove"></i>
            </div>
        </td>
        <td class="discount"></td>
        <td colspan="2" class="last-child">
            <input type="hidden" name="<?=\CHtml::activeName($orderForm, 'Items[<%=i%>][ProductId]')?>" value="<%=productId%>" />
            <input type="hidden" name="<?=\CHtml::activeName($orderForm, 'Items[<%=i%>][RunetId]')?>" value="<%=item.RunetId%>" />
            <div class="input-append pull-right input-promo">
                <input type="text" name="<?=\CHtml::activeName($orderForm, 'Items[<%=i%>][PromoCode]')?>" value="<%=promoCode%>" class="t-center form-element_text" placeholder="<?=Yii::t('app', 'Промо код')?>"/>
                <button class="btn disabled" type="button"><i class="icon-check"></i></button>
                <div class="alert hide"></div>
            </div>
        </td>
    </tr>
</script>

<script type="text/template" id="row-data-tpl">
    <input type="hidden" name="<?=\CHtml::activeName($orderForm, 'Items[<%=i%>][ProductId]')?>" value="<%=productId%>" />
    <input type="hidden" name="<?=\CHtml::activeName($orderForm, 'Items[<%=i%>][RunetId]')?>" value="<%=runetId%>" />
    <div class="input-append pull-right input-promo">
        <input type="text" name="<?=\CHtml::activeName($orderForm, 'Items[<%=i%>][PromoCode]')?>" value="" class="t-center form-element_text" placeholder="<?=Yii::t('app', 'Промо код')?>"/>
        <button class="btn disabled" type="button"><i class="icon-check"></i></button>
        <div class="alert hide"></div>
    </div>
</script>

<script type="text/template" id="user-autocomlete-tpl">
    <p><%=item.FullName%>, <span class='muted'>RUNET-ID <%=item.RunetId%></span></p>
    <% if (typeof(item.Company) != "undefined") { %>
        <p class='muted'><%=item.Company%><% if (item.Position.length != 0) { %>, <%=item.Position%> <% } %></p>
    <% } %>
    <img src='<%=item.Photo.Small%>' alt='<%=item.FullName%>'>
</script>
<?
$this->renderPartial('register/templates/row-register', [
    'registerForm' => $registerForm,
    'event' => $event
]);
?>

<script  type="text/template" id="row-discount">
    -<%=discount%> <?=Yii::t('app', 'руб.')?>
</script>

<?$this->renderPartial('register/templates/row-edit-userdata')?>
<?$this->renderPartial('register/templates/row-document-alert')?>