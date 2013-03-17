<?php
/**
 * @var $event \event\models\Event
 * @var $orderForm \pay\models\forms\OrderForm
 * @var $products \pay\models\Product[]
 * @var $registerForm \pay\models\forms\RegisterForm
 */

$hasNotPaidOrders = false;
?>
<?php if (!\Yii::app()->user->isGuest):?>
  <section id="section" role="main">

    <?foreach ($event->Widgets as $widget):?>
      <?if ($widget->getPosition() == \event\components\WidgetPosition::Header):?>
        <?
        $widget->getWidget()->eventPage = false;
        $widget->run();
        ?>
      <?endif;?>
    <?endforeach;?>

    <div class="event-register">
      <div class="container">

        <div class="tabs clearfix">
          <div class="tab current pull-left">
            <span class="number img-circle">1</span>
            <?=\Yii::t('pay', 'Регистрация');?>
          </div>
          <div class="tab pull-left">
            <span class="number img-circle">2</span>
            <?=\Yii::t('pay', 'Оплата');?>
          </div>
        </div>

        <?=CHtml::errorSummary($orderForm, '<div class="alert alert-error">', '</div>');?>

        <table class="table thead-actual">
          <thead>
          <tr>
            <th><?=\Yii::t('pay', 'Тип товара');?></th>
            <th class="col-width t-right"><?=\Yii::t('pay', 'Цена');?></th>
            <th class="col-width t-center"><?=\Yii::t('pay', 'Кол-во');?></th>
            <th class="col-width t-right last-child"><?=\Yii::t('pay', 'Сумма');?></th>
          </tr>
          </thead>
        </table>

        <?php echo CHtml::beginForm('', 'POST', array('class' => 'registration', 'id' => 'registration_form'));?>

        <?php foreach ($products as $product):
          if ($product->GetPrice() == null)
          {
            continue;
          }
          ?>
          <table class="table">
            <thead>
            <tr data-product-id="<?=$product->Id;?>" data-price="<?=$product->getPrice();?>" data-user-max="<?=isset($orderForm->Count[$product->Id]) ? $orderForm->Count[$product->Id] : 0;?>" data-user-current="<?=!empty($orderForm->Count[$product->Id]) ? $orderForm->Count[$product->Id] : 0;?>">
              <th>
                <h4 class="title"><?=\Yii::t('pay', $product->Title);?> <i class="icon-chevron-up"></i></h4>
              </th>
              <th class="col-width t-right"><span class="number"><?=$product->getPrice();?></span> Р</th>
              <th class="col-width t-center">
                <?=CHtml::activeHiddenField($orderForm, 'Count['.$product->Id.']', array('class' => 'quantity-user-max'));?>
                <span class="number quantity"></span>
              </th>
              <th class="col-width t-right last-child"><b class="number mediate-price">0</b> Р</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        <?php endforeach;?>

        <script type="text/javascript">
          var products = [];
          var user;
          <?if (!empty($orderForm->Owners)):?>
          <?foreach ($orderForm->Owners as $productId => $users):?>
          products[<?=$productId?>] = [];
          <?foreach ($users as $runetid => $value):?>
          <?
          /** @var $user \user\models\User */
          $user = \user\models\User::model()->byRunetId($runetid)->find();
          ?>
          user = {};
          user.runetid = <?=$runetid;?>;
          user.name = <?=json_encode($user->getFullName());?>;
          user.code = '<?=isset($orderForm->PromoCodes[$productId][$runetid]) ? $orderForm->PromoCodes[$productId][$runetid] : '';?>';
          products[<?=$productId?>].push(user);
          <?endforeach;?>
          <?endforeach;?>
          <?endif;?>

          var currentUser = {};
          currentUser.runetid = <?=\Yii::app()->user->CurrentUser()->RunetId;?>;
          currentUser.name = <?=json_encode(\Yii::app()->user->CurrentUser()->getFullName());?>;
        </script>

        <div class="total">
          <span>Итого:</span> <b id="total-price" class="number">0</b> Р
        </div>

        <?php if ($hasNotPaidOrders):?>
          <div class="alert alert-info" style="margin: 0 20px 20px;">
            <?php echo \Yii::t('pay', 'У вас уже имеются неоплаченные заказы, для их просмотра, не заполняя форму, нажмите «Перейти к оплате».');?>
          </div>
        <?php endif;?>

        <div class="actions">
          <a href="#" onclick="$('#registration_form').trigger('submit'); return false;" class="btn btn-large btn-info">
            <?=\Yii::t('pay', 'Перейти к оплате');?>
            <i class="icon-circle-arrow-right icon-white"></i>
          </a>
        </div>
        <?php echo CHtml::endForm();?>

      </div>
    </div>
  </section>




  <script type="text/template" id="event-user-row">
    <tr class="user-row">
      <td>
        <div class="p-relative">

          <input type="text" class="input-xxlarge form-element_text input-user" placeholder="<?=Yii::t('pay', 'Введите ФИО или RUNET-ID');?>">
        </div>
      </td>
      <td colspan="3" class="last-child">
        <button class="btn btn-inverse btn-register pull-right" style="display: none;"><?=Yii::t('pay', 'Зарегистрировать');?></button>
        <input type="text" class="input-medium pull-right t-center form-element_text input-promo" placeholder="Промо код" style="display: none;">
      </td>
    </tr>
  </script>

  <script type="text/template" id="event-user-row-hiddenitem">
    <input type="hidden" value="1" name="<?=CHtml::resolveName($orderForm, $_ = 'Owners[<%=productid%>][<%=runetid%>]');?>"/>
  </script>

  <script type="text/template" id="event-user-row-promoname"><?=CHtml::resolveName($orderForm, $_ = 'PromoCodes[<%=productid%>][<%=runetid%>]');?></script>

  <script type="text/template" id="event-user-row-onselect">
    <tr class="user-row">
      <td>
        <div class="p-relative">

          <input type="text" class="input-xxlarge form-element_text input-user" placeholder="<?=Yii::t('pay', 'Введите ФИО или RUNET-ID');?>">
        </div>
      </td>
      <td colspan="3" class="last-child">
        <button class="btn btn-inverse btn-register pull-right" style="display: none;"><?php echo Yii::t('tc2012', 'Зарегистрировать');?></button>
        <input type="text" name="<?=CHtml::resolveName($orderForm, $_ = 'PromoCodes[<%=productid%>][<%=runetid%>]');?>" class="input-medium pull-right t-center form-element_text input-promo" placeholder="Промо код" style="display: none;">
      </td>
    </tr>
  </script>

  <script type="text/template" id="event-user-row-withdata">
    <tr class="user-row">
      <td>
        <div class="p-relative">
          <input type="hidden" value="1" name="<?=CHtml::resolveName($orderForm, $_ = 'Owners[<%=productid%>][<%=runetid%>]');?>"/>
          <input type="text" class="input-xxlarge form-element_text input-user" placeholder="Введите ФИО или RUNET-ID" value="<%=name%>, RUNET-ID <%=runetid%>" disabled>
          <i class="icon-remove"></i>
        </div>
      </td>
      <td colspan="3" class="last-child">
        <button class="btn btn-inverse btn-register pull-right" style="display: none;"><?=Yii::t('pay', 'Зарегистрировать');?></button>
        <input type="text" class="input-medium pull-right t-center form-element_text input-promo" placeholder="Промо код" name="<?php echo CHtml::resolveName($orderForm, $_ = 'PromoCodes[<%=productid%>][<%=runetid%>]');?>" value="<%=code%>">
      </td>
    </tr>
  </script>

  <script type="text/template" id="event-user-row-add">
    <tr class="user-row" style="opacity: .25;">
      <td>
        <div class="p-relative">
          <input type="text" class="input-xxlarge form-element_text input-user" placeholder="<?=Yii::t('pay', 'Введите ФИО или RUNET-ID');?>" disabled>
        </div>
      </td>
      <td colspan="3" class="last-child">
        <button class="btn btn-inverse btn-register pull-right" style="display: none;"><?=Yii::t('pay', 'Зарегистрировать');?></button>
        <input type="text" class="input-medium pull-right t-center form-element_text input-promo" placeholder="<?=\Yii::t('pay','Промо код');?>" style="display: none;">
      </td>
    </tr>
  </script>

  <script type="text/template" id="event-user-register">
    <tr>
      <td colspan="4" class="last-child">
        <?=CHtml::beginForm('', 'POST', array('class' => 'user-register'));?>
        <header><h4 class="title"><?=\Yii::t('pay', 'Регистрация нового участника');?></h4></header>



        <div class="clearfix">
          <div class="pull-left">
            <div class="control-group">
              <label><?=\Yii::t('pay', 'Фамилия');?></label>
              <div class="required">
                <?=CHtml::activeTextField($registerForm, 'LastName');?>
              </div>
            </div>
            <div class="control-group">
              <label><?=\Yii::t('pay', 'Имя');?></label>
              <div class="required">
                <?php echo CHtml::activeTextField($registerForm, 'FirstName');?>
              </div>
            </div>
            <div class="control-group">
              <label><?=\Yii::t('pay', 'Отчество');?></label>
              <div class="controls">
                <?php echo CHtml::activeTextField($registerForm, 'SecondName');?>
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
              <label><?=\Yii::t('pay', 'Телефон');?></label>
              <?=CHtml::activeTextField($registerForm, 'Phone');?>
            </div>
            <div class="control-group">
              <label><?=\Yii::t('pay', 'Компания');?></label>
              <div class="required">
                <?=CHtml::activeTextField($registerForm, 'Company');?>
              </div>
            </div>
            <div class="control-group">
              <label><?=\Yii::t('pay', 'Должность');?></label>
              <?=CHtml::activeTextField($registerForm, 'Position');?>
            </div>
          </div>
        </div>

        <small class="muted required-notice">
          <span class="required-asterisk">*</span> &mdash; <?=\Yii::t('pay', 'поля обязательны для заполнения');?>
        </small>

        <div class="form-actions">
          <button id="event-user-register-submit" class="btn btn-inverse"><?=\Yii::t('pay', 'Зарегистрировать');?></button>
          <button id="event-user-register-cancel" class="btn"><?=\Yii::t('pay', 'Отмена');?></button>
        </div>
        <?CHtml::endForm();?>
      </td>
    </tr>
  </script>

  <script type="text/template" id="user-autocomlete-tpl">
    <p><%=item.FullName%>, <span class='muted'>RUNET-ID <%=item.RunetId%></span></p>
    <% if (typeof(item.Company) != "undefined") { %>
      <p class='muted'><%=item.Company%><% if (item.Position.length != 0) { %>, <%=item.Position%> <% } %></p>
    <% } %>
    <img src='<%=item.Photo.Small%>' alt='<%=item.FullName%>'>
  </script>
<?php endif;?>