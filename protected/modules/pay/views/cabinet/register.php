<?php
/**
 * @var \event\models\Event $event
 * @var \pay\models\forms\OrderForm $orderForm
 * @var \pay\models\Account $account
 * @var \pay\models\Product[] $products
 */

$runetIdTitle = $account->SandBoxUser ? '' : ' или RUNET-ID';
$runetIdTitle2 = $account->SandBoxUser ? 'ID' : 'RUNET-ID';
?>

<script type="text/javascript">
  payItems = [];
  <?if (!empty($orderForm->Items)):?>
  <?foreach ($orderForm->Items as $item):?>
  <?php $owner = \user\models\User::model()->byRunetId($item['RunetId'])->find();?>
  var payItem = [];
  payItem.productId = '<?=$item['ProductId'];?>';
  payItem.user = {
    RunetId : '<?=$owner->RunetId;?>',
    FullName : '<?=\CHtml::encode($owner->getFullName());?>'
  };
  payItem.promoCode = '<?=!empty($item['PromoCode']) ? $item['PromoCode'] : '';?>';
  payItems.push(payItem);
  <?endforeach;?>
  <?endif;?>
</script>

<section id="section" role="main">
  <?=\CHtml::beginForm('', 'POST', [
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


      <div class="alert alert-block alert-muted">
        <?$user = Yii::app()->user->getCurrentUser();?>
        <p>
          <?if (!empty($user->LastName) && !empty($user->FirstName)):?>
            <?=$user->getShortName();?>,
          <?else:?>
            Уважаемый пользователь,
          <?endif;?>
          на данном шаге Вы можете сформировать или отредактировать свой заказ.</p>

        <?if (count($products) > 1):?>
        <p>Оплата может быть произведена как за одного, так и за несколько пользователей: все услуги для <?=$event->Title;?> разделены на группы, внутри каждой из которых вы можете указать получателей.</p>
        <?else:?>
          <p>Оплата на <?=$event->Title;?> может быть произведена как за одного, так и за несколько пользователей. Просто укажите своих коллег и друзей в качестве получателей услуги.</p>
        <?endif;?>

        <?if (!empty($account->SandBoxUserRegisterUrl)):?>
          <p>
            <strong>Если вы еще не зарегистрировались на мероприятие или хотите зарегистрировать своих коллег, пройдите по ссылке
              <a target="_blank" href="<?=$account->SandBoxUserRegisterUrl;?>">зарегистрироваться</a>.</strong>
          </p>
        <?endif;?>

        <?if (!$account->SandBoxUser):?>
          <p>Для добавления участника достаточным будет ввести его ФИО или RUNET-ID, система автоматически проверит наличие пользователя среди участников ИТ-мероприятия и если будут найдены совпадения - предложит добавить существующий профиль. В противном случае нужно будет заполнить необходимую контактную информацию для участника.</p>

          <?if ($unpaidOwnerCount > 0 || $unpaidJuridicalOrderCount > 0):?>
            <p><strong>Важно:</strong> у Вас уже есть сформированные, но <a href="<?=$this->createUrl('/pay/cabinet/index', array('eventIdName' => $event->IdName));?>">неоплаченные заказы</a>.</p>
          <?endif;?>
        <?endif;?>
      </div>

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

      <?foreach ($products as $product):?>
        <table class="table" data-product-id="<?=$product->Id;?>" data-price="<?=$product->getPrice();?>" data-row-max="<?=$countRows[$product->Id];?>" data-row-current="0">
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

      <div class="actions">
        <a href="#" onclick="$('#registration_form').trigger('submit'); return false;" class="btn btn-large btn-info">
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
    <td colspan="3" class="last-child">
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
        <input type="text" class="input-xxlarge form-element_text input-user" placeholder="Введите ФИО<?=$runetIdTitle;?>" value="<%=item.FullName%>, <?=$runetIdTitle2;?> <%=item.RunetId%>" disabled>
        <i class="icon-remove"></i>
      </div>
    </td>
    <td colspan="3" class="last-child">
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
              <?php echo CHtml::activeTextField($registerForm, 'FirstName');?>
            </div>
          </div>
          <div class="control-group">
            <label><?=\Yii::t('app', 'Отчество');?></label>
            <div class="controls">
              <?php echo CHtml::activeTextField($registerForm, 'FatherName');?>
            </div>
          </div>
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
            <?=CHtml::activeTextField($registerForm, 'Phone');?>
          </div>
          <div class="control-group">
            <label><?=\Yii::t('app', 'Компания');?></label>
            <div class="required">
              <?=CHtml::activeTextField($registerForm, 'Company');?>
            </div>
          </div>
          <div class="control-group">
            <label><?=\Yii::t('app', 'Должность');?></label>
            <?=CHtml::activeTextField($registerForm, 'Position');?>
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