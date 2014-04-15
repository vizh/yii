<?php
/**
 * @var \pay\components\Controller $this
 * @var \event\models\Event $event
 * @var \pay\models\forms\OrderForm $orderForm
 * @var \pay\models\Account $account
 * @var \pay\models\Product[] $products
 * @var int $unpaidOwnerCount
 * @var int $unpaidJuridicalOrderCount
 * @var \user\models\forms\RegisterForm $registerForm
 * @var array $countRows
 */

$runetIdTitle = $account->SandBoxUser ? '' : ' или RUNET-ID';
$runetIdTitle2 = $account->SandBoxUser ? 'ID' : 'RUNET-ID';
$hasTickets = !empty($products->tickets);
?>

<script type="text/javascript">
  if (self.parent.frames.length != 0)
  {
    self.parent.location=document.location.href;
  }

  payItems = [];
  <?if ($orderForm->Scenario == null || $orderForm->Scenario == \pay\models\forms\OrderForm::ScenarioRegisterUser):?>
    <?if (!empty($orderForm->Items)):?>
      <?foreach ($orderForm->Items as $item):?>
        <?$owner = \user\models\User::model()->byRunetId($item['RunetId'])->find();?>
        var payItem = [];
        payItem.productId = '<?=$item['ProductId'];?>';
        payItem.user = {
          RunetId : '<?=$owner->RunetId;?>',
          FullName : '<?=\CHtml::encode($owner->getFullName());?>'
        };
        payItem.discount = '<?=!empty($item['Discount']) ? $item['Discount'] : 0;?>';
        payItem.promoCode = '<?=!empty($item['PromoCode']) ? $item['PromoCode'] : '';?>';
        payItems.push(payItem);
      <?endforeach;?>
    <?endif;?>
  <?endif;?>
</script>

<section id="section" role="main">
  <?=\CHtml::beginForm(Yii::app()->createUrl('/pay/cabinet/register', ['eventIdName' => $event->IdName]), 'POST', [
    'class' => 'registration',
    'id' => 'registration_form',
    'data-event-id-name' => $event->IdName,
    'data-event-id' => $event->Id,
    'data-sandbox-user' => $account->SandBoxUser,
  ]);?>

  <div class="event-register">
    <?=\CHtml::errorSummary($orderForm, '<div class="container"><div class="alert alert-error">', '</div></div>');?>
    <div class="container">
      <div class="tabs clearfix">
        <div class="tab current pull-left">
          <span class="number img-circle">1</span>
          <?=\Yii::t('app', 'Регистрация');?>
        </div>
        <div class="tab pull-left">
          <span class="number img-circle">2</span>
          <?=\Yii::t('app', 'Оплата');?>
        </div>
      </div>

      <?if ($hasTickets):?>
      <div class="clearfix m-bottom_30 scenario-selector m-top_40">
        <div class="pull-left">
          <label class="radio"><?=\CHtml::activeRadioButton($orderForm, 'Scenario', ['value' => \pay\models\forms\OrderForm::ScenarioRegisterUser, 'uncheckValue' => null]);?> <?=\Yii::t('app', '<strong>Я знаю кто пойдет на мероприятие</strong>, и хочу указать участников сразу');?></label>
        </div>
        <div class="pull-right">
          <label class="radio"><?=\CHtml::activeRadioButton($orderForm, 'Scenario', ['value' => \pay\models\forms\OrderForm::ScenarioRegisterTicket, 'uncheckValue' => null]);?> <?=\Yii::t('app', '<strong>Я не знаю кто пойдет на мероприятие</strong>, и хочу указать участников позже');?></label>
        </div>
      </div>
      <?else:?>
        <?=\CHtml::activeHiddenField($orderForm, 'Scenario', ['value' => \pay\models\forms\OrderForm::ScenarioRegisterUser]);?>
      <?endif;?>


      <div <?if ($hasTickets):?>style="display: none;"<?endif;?> data-scenario="<?=\pay\models\forms\OrderForm::ScenarioRegisterUser;?>">
      <?$this->renderPartial('register/help', ['user' => $this->getUser(), 'products' => $products, 'account' => $account, 'event' => $event,'unpaidOwnerCount' => $unpaidOwnerCount, 'unpaidJuridicalOrderCount' => $unpaidJuridicalOrderCount]);?>
      <table class="table thead-actual">
        <thead>
        <tr>
          <th><?=\Yii::t('app', 'Тип билета');?></th>
          <th class="col-width t-right"><?=\Yii::t('app', 'Цена');?></th>
          <th class="col-width t-center"><?=\Yii::t('app', 'Кол-во');?></th>
          <th class="col-width t-right last-child"><?=\Yii::t('app', 'Сумма');?></th>
        </tr>
        </thead>
      </table>
      <?foreach ($products->all as $product):?>
        <table class="table" data-product-id="<?=$product->Id;?>" data-price="<?=$product->getPrice();?>" data-row-max="<?=$countRows[$product->Id] == 0 ? 1 : $countRows[$product->Id];?>" data-row-current="0">
          <thead>
          <tr>
            <th>
              <h4 class="title"><?=$product->Title;?> <i class="icon-chevron-up"></i></h4>
            </th>
            <th class="col-width t-right"><span class="number"><?=$product->getPrice();?></span> <?=Yii::t('app', 'руб.');?></th>
            <th class="col-width t-center"><span class="number quantity"></span></th>
            <th class="col-width t-right last-child"><b class="number mediate-price">0</b> <?=Yii::t('app', 'руб.');?></th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      <?endforeach;?>
      <div class="total">
        <span><?=Yii::t('app', 'Итого');?>:</span> <b id="total-price" class="number">0</b> <?=Yii::t('app', 'руб.');?>
      </div>
      </div>

      <?if ($hasTickets):?>
      <div style="display: none;" data-scenario="<?=\pay\models\forms\OrderForm::ScenarioRegisterTicket;?>">
        <?$this->renderPartial('register/help-ticket', ['user' => $this->getUser(), 'products' => $products, 'account' => $account, 'event' => $event,'unpaidOwnerCount' => $unpaidOwnerCount, 'unpaidJuridicalOrderCount' => $unpaidJuridicalOrderCount]);?>
        <table class="table thead-actual">
          <thead>
          <tr>
            <th><?=\Yii::t('app', 'Тип билета');?></th>
            <th class="col-width t-right"><?=\Yii::t('app', 'Цена');?></th>
            <th class="t-center" style="width: 30px;"><?=\Yii::t('app', 'Кол-во');?></th>
            <th class="col-width t-right last-child"><?=\Yii::t('app', 'Сумма');?></th>
          </tr>
          </thead>
          <?foreach ($products->tickets as $i => $product):?>
          <tbody>
            <tr data-product-id="<?=$product->Id;?>" data-price="<?=$product->getPrice();?>">
              <td><?=$product->getManager()->getPaidProduct()->Title;?></td>
              <td class="t-right"><span class="number"><?=$product->getPrice();?></span> <?=Yii::t('app', 'руб.');?></td>
              <td class="t-center">
                <?
                $value = \CHtml::resolveValue($orderForm, 'Items['.$i.'][Count]');
                if ($value == null)
                {
                  $value = isset($countRows[$product->getManager()->ProductId]) ? $countRows[$product->getManager()->ProductId] : 0;
                }
                echo \CHtml::dropDownList(\CHtml::activeName($orderForm, 'Items['.$i.'][Count]'), $value, [0,1,2,3,4,5,6,7,8,9,10],  ['class' => 'input-mini']);?>
              </td>
              <td class="t-right"><b class="number mediate-price">0</b> <?=Yii::t('app', 'руб.');?></td>
            </tr>
          </tbody>
          <?=\CHtml::activeHiddenField($orderForm, 'Items['.$i.'][ProductId]', ['value' => $product->Id]);?>
          <?endforeach;?>
        </table>
        <div class="total">
          <span><?=Yii::t('app', 'Итого');?>:</span> <b id="total-price" class="number">0</b> <?=Yii::t('app', 'руб.');?>
        </div>
      </div>
      <?endif;?>

      <div class="nav-buttons">
        <a href="#" onclick="$('#registration_form').trigger('submit'); return false;" class="btn btn-large btn-info <?if ($hasTickets):?>disabled<?endif;?>">
          <?=\Yii::t('app', 'Продолжить');?>
          <i class="icon-circle-arrow-right icon-white"></i>
        </a>
      </div>
    </div>
  </div>
  <?=\CHtml::endForm();?>
</section>

<script type="text/template" id="row-tpl">
  <tr class="user-row">
    <td>
      <div class="p-relative">
        <input type="text" class="input-xxlarge form-element_text input-user" placeholder="<?=Yii::t('app', 'Введите ФИО'.$runetIdTitle);?>">
      </div>
    </td>
    <td class="discount" data-discount="0"></td>
    <td colspan="2" class="last-child">
      <?if (!$account->SandBoxUser):?>
        <button class="btn btn-inverse btn-register pull-right" style="display: none;"><?=Yii::t('app', 'Зарегистрировать');?></button>
      <?endif;?>
    </td>
  </tr>
</script>

<script type="text/template" id="row-withdata-tpl">
  <tr class="user-row">
    <td>
      <div class="p-relative">
        <input type="text" class="input-xxlarge form-element_text input-user no-disabled" placeholder="Введите ФИО<?=$runetIdTitle;?>" value="<%=item.FullName%>, <?=$runetIdTitle2;?> <%=item.RunetId%>" disabled>
        <i class="icon-remove"></i>
      </div>
    </td>
    <td class="discount"></td>
    <td colspan="2" class="last-child">
      <input type="hidden" name="<?=\CHtml::activeName($orderForm, 'Items[<%=i%>][ProductId]');?>" value="<%=productId%>" />
      <input type="hidden" name="<?=\CHtml::activeName($orderForm, 'Items[<%=i%>][RunetId]');?>" value="<%=item.RunetId%>" />
      <div class="input-append pull-right input-promo">
        <input type="text" name="<?=\CHtml::activeName($orderForm, 'Items[<%=i%>][PromoCode]');?>" value="<%=promoCode%>" class="t-center form-element_text" placeholder="<?=Yii::t('app', 'Промо код');?>"/>
        <button class="btn disabled" type="button"><i class="icon-check"></i></button>
        <div class="alert hide"></div>
      </div>
    </td>
  </tr>
</script>

<script type="text/template" id="row-data-tpl">
  <input type="hidden" name="<?=\CHtml::activeName($orderForm, 'Items[<%=i%>][ProductId]');?>" value="<%=productId%>" />
  <input type="hidden" name="<?=\CHtml::activeName($orderForm, 'Items[<%=i%>][RunetId]');?>" value="<%=runetId%>" />
  <div class="input-append pull-right input-promo">
    <input type="text" name="<?=\CHtml::activeName($orderForm, 'Items[<%=i%>][PromoCode]');?>" value="" class="t-center form-element_text" placeholder="<?=Yii::t('app', 'Промо код');?>"/>
    <button class="btn disabled" type="button"><i class="icon-check"></i></button>
    <div class="alert hide"></div>
  </div>
</script>

<script type="text/template" id="user-autocomlete-tpl">
  <p><%=item.FullName%>, <span class='muted'><?=$runetIdTitle2;?> <%=item.RunetId%></span></p>
  <% if (typeof(item.Company) != "undefined") { %>
    <p class='muted'><%=item.Company%><% if (item.Position.length != 0) { %>, <%=item.Position%> <% } %></p>
  <% } %>
  <img src='<%=item.Photo.Small%>' alt='<%=item.FullName%>'>
</script>

<script type="text/template" id="row-register-tpl">
  <tr>
    <td colspan="4" class="last-child">
      <?=CHtml::beginForm('', 'POST', array('class' => 'user-register'));?>
      <header><h4 class="title"><?=\Yii::t('app', 'Регистрация нового участника');?></h4></header>
      <?=CHtml::activeHiddenField($registerForm, 'EventId', ['value' => $event->Id]);?>
      <div class="alert alert-error" style="display: none;"></div>
      <div class="clearfix">
        <div class="pull-left">
          <div class="control-group">
            <label><?=\Yii::t('app', 'Фамилия');?></label>
            <div class="required">
              <?=CHtml::activeTextField($registerForm, 'LastName');?>
            </div>
          </div>
          <div class="control-group">
            <label><?=\Yii::t('app', 'Имя');?></label>
            <div class="required">
              <?=CHtml::activeTextField($registerForm, 'FirstName');?>
            </div>
          </div>
          <?if (Yii::app()->language != 'en'):?>
          <div class="control-group">
            <label><?=\Yii::t('app', 'Отчество');?></label>
            <div class="controls">
              <?=CHtml::activeTextField($registerForm, 'FatherName');?>
            </div>
          </div>
          <?endif;?>
          <div class="control-group">
            <label>Email</label>
            <div class="controls required">
              <?=CHtml::activeTextField($registerForm, 'Email');?>
            </div>
          </div>
        </div>
        <div class="pull-right">
          <div class="control-group">
            <label><?=\Yii::t('app', 'Телефон');?></label>
            <?if (isset($event->PhoneRequired) && $event->PhoneRequired):?>
              <div class="required">
                <?=CHtml::activeTextField($registerForm, 'Phone');?>
              </div>
            <?else:?>
              <?=CHtml::activeTextField($registerForm, 'Phone');?>
            <?endif;?>
          </div>
          <div class="control-group">
            <label><?=\Yii::t('app', 'Компания');?></label>
            <div class="required">
              <?=CHtml::activeTextField($registerForm, 'Company');?>
            </div>
          </div>
          <div class="control-group">
            <label><?=\Yii::t('app', 'Должность');?></label>
            <?if (isset($event->PositionRequired) && $event->PositionRequired):?>
            <div class="required">
            <?=CHtml::activeTextField($registerForm, 'Position');?>
            </div>
            <?else:?>
            <?=CHtml::activeTextField($registerForm, 'Position');?>
            <?endif;?>
          </div>
        </div>
      </div>

      <small class="muted required-notice">
        <span class="required-asterisk">*</span> &mdash; <?=\Yii::t('app', 'поля обязательны для заполнения');?>
      </small>

      <div class="form-actions">
        <button class="btn btn-inverse btn-submit"><?=\Yii::t('app', 'Зарегистрировать');?></button>
        <button class="btn btn-cancel"><?=\Yii::t('app', 'Отмена');?></button>
      </div>
      <?CHtml::endForm();?>
    </td>
  </tr>
</script>

<script  type="text/template" id="row-discount">
  -<%=discount%> <?=Yii::t('app', 'руб.');?>
</script>