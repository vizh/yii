<?php
/**
 * @var $products \pay\models\Product[]
 * @var $orderForm \pay\models\forms\OrderForm
 */
?>

<section id="section" role="main">
  <div class="event-register">
    <div class="container">
      <div class="tabs clearfix">
        <div class="tab current pull-left">
          <span class="number img-circle">1</span>
          <?=\Yii::t('tc2012', 'Регистрация');?>
        </div>
        <div class="tab pull-left">
          <span class="number img-circle">2</span>
          <?=\Yii::t('tc2012', 'Оплата');?>
        </div>
      </div>
      <?php //echo CHtml::errorSummary($orderForm, '<div class="alert alert-error">', '</div>');?>
      <table class="table thead-actual">
        <thead>
        <tr>
          <th><?=\Yii::t('tc2012', 'Тип билета');?></th>
          <th class="col-width t-right"><?=\Yii::t('tc2012', 'Цена');?></th>
          <th class="col-width t-center"><?=\Yii::t('tc2012', 'Кол-во');?></th>
          <th class="col-width t-right last-child"><?=\Yii::t('tc2012', 'Сумма');?></th>
        </tr>
        </thead>
      </table>
      
      <?=\CHtml::beginForm('', 'POST', array('class' => 'registration'));?>
      <?foreach ($products as $product):?>
        <table class="table">
          <thead>
            <tr data-product-id="<?=$product->Id;?>" data-price="<?php echo $product->getPrice();?>" data-user-max="1" data-user-current="1">
              <th>
                <h4 class="title"><?=$product->Title;?> <i class="icon-chevron-up"></i></h4>
              </th>
              <th class="col-width t-right"><span class="number"><?php echo $product->GetPrice();?></span> Р</th>
              <th class="col-width t-center">
                <span class="number quantity"></span>
              </th>
              <th class="col-width t-right last-child"><b class="number mediate-price">0</b> Р</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      <?endforeach;?>
      <?=\CHtml::endForm();?>

      <div class="total">
        <span>Итого:</span> <b id="total-price" class="number">0</b> Р
      </div>
        
      <script type="text/javascript">
        var products = [];
        <?php
          $currentUser = new \stdClass();
          $currentUser->runetid = \Yii::app()->user->CurrentUser()->RunetId;
          $currentUser->name = \Yii::app()->user->CurrentUser()->getFullName();
        ?>
        var currentUser = <?=json_encode($currentUser);?>;
      </script> 
      
      <div class="actions">
        <a href="#" onclick="$('#registration_form').trigger('submit'); return false;" class="btn btn-large btn-info">
          <?=\Yii::t('tc2012', 'Перейти к оплате');?>
          <i class="icon-circle-arrow-right icon-white"></i>
        </a>
      </div>
    </div>
  </div>
</section>






<script type="text/template" id="event-user-row">
  <tr class="user-row">
    <td>
      <div class="p-relative">
        <input type="text" class="input-xxlarge form-element_text input-user" placeholder="<?=\Yii::t('app', 'Введите ФИО или RUNET-ID');?>">
      </div>
    </td>
    <td colspan="3" class="last-child">
      <button class="btn btn-inverse btn-register pull-right" style="display: none;"><?=\Yii::t('app', 'Зарегистрировать');?></button>
      <input type="text" class="input-medium pull-right t-center form-element_text input-promo" placeholder="<?=\Yii::t('app', 'Промо код');?>" style="display: none;">
    </td>
  </tr>
</script>

<script type="text/template" id="event-user-row-hiddenitem">
  <input type="hidden" value="1" name="<?php echo CHtml::resolveName($orderForm, $_ = 'Owners[<%=productid%>][<%=rocid%>]');?>"/>
</script>

<script type="text/template" id="event-user-row-promoname">
  <?php echo CHtml::resolveName($orderForm, $_ = 'PromoCodes[<%=productid%>][<%=rocid%>]');?>
</script>

<script type="text/template" id="event-user-row-onselect">
  <tr class="user-row">
    <td>
      <div class="p-relative">
        <input type="text" class="input-xxlarge form-element_text input-user" placeholder="<?=\Yii::t('app', 'Введите ФИО или RUNET-ID');?>">
      </div>
    </td>
    <td colspan="3" class="last-child">
      <button class="btn btn-inverse btn-register pull-right" style="display: none;"><?=\Yii::t('tc2012', 'Зарегистрировать');?></button>
      <input type="text" name="<?php echo CHtml::resolveName($orderForm, $_ = 'PromoCodes[<%=productid%>][<%=rocid%>]');?>" class="input-medium pull-right t-center form-element_text input-promo" placeholder="<?=\Yii::t('app', 'Промо код');?>" style="display: none;">
    </td>
  </tr>
</script>

<script type="text/template" id="event-user-row-withdata">
  <tr class="user-row">
    <td>
      <div class="p-relative">
        <input type="hidden" value="1" name="<?php echo CHtml::resolveName($orderForm, $_ = 'Owners[<%=productid%>][<%=rocid%>]');?>"/>
        <input type="text" class="input-xxlarge form-element_text input-user" placeholder="<?=\Yii::t('app', 'Введите ФИО или RUNET-ID');?>" value="<%=name%>, RUNET-ID <%=runetid%>" disabled>
        <i class="icon-remove"></i>
      </div>
    </td>
    <td colspan="3" class="last-child">
      <button class="btn btn-inverse btn-register pull-right" style="display: none;"><?=\Yii::t('app', 'Зарегистрировать');?></button>
      <input type="text" class="input-medium pull-right t-center form-element_text input-promo" placeholder="<?=\Yii::t('app', 'Промо код');?>" name="<?php echo CHtml::resolveName($orderForm, $_ = 'PromoCodes[<%=productid%>][<%=rocid%>]');?>" value="<%=code%>">
    </td>
  </tr>
</script>

<script type="text/template" id="event-user-row-add">
  <tr class="user-row" style="opacity: .25;">
    <td>
      <div class="p-relative">
        <input type="text" class="input-xxlarge form-element_text input-user" placeholder="<?=\Yii::t('app', 'Введите ФИО или RUNET-ID');?>" disabled>
      </div>
    </td>
    <td colspan="3" class="last-child">
      <button class="btn btn-inverse btn-register pull-right" style="display: none;"><?=\Yii::t('app', 'Зарегистрировать');?></button>
      <input type="text" class="input-medium pull-right t-center form-element_text input-promo" placeholder="<?=\Yii::t('app','Промо код');?>" style="display: none;">
    </td>
  </tr>
</script>

<script type="text/template" id="event-user-register">
  <tr>
    <td colspan="4" class="last-child">
      <?php// echo CHtml::beginForm('', 'POST', array('class' => 'user-register'));?>
        <header><h4 class="title"><?//=\Yii::t('mblt2013', 'Регистрация нового участника');?></h4></header>
        <div class="clearfix">
          <div class="pull-left">
            <div class="control-group">
              <label><?//=\Yii::t('tc2012', 'Фамилия');?></label>
              <div class="required">
                <?php// echo CHtml::activeTextField($registerForm, 'LastName');?>
              </div>
            </div>
            <div class="control-group">
              <label><?//=\Yii::t('tc2012', 'Имя');?></label>
              <div class="required">
                <?php// echo CHtml::activeTextField($registerForm, 'FirstName');?>
              </div>
            </div>
            <div class="control-group">
              <label><?//=\Yii::t('tc2012', 'Отчество');?></label>
              <div class="controls">
                <?php// echo CHtml::activeTextField($registerForm, 'SecondName');?>
              </div>
            </div>
            <div class="control-group">
              <label>Email</label>
              <div class="controls required">
                <?php// echo CHtml::activeTextField($registerForm, 'Email');?>
              </div>
            </div>
          </div>
          <div class="pull-right">
            <div class="control-group">
              <label><?//=\Yii::t('tc2012', 'Телефон');?></label>
              <?php// echo CHtml::activeTextField($registerForm, 'Phone');?>
            </div>
            <div class="control-group">
              <label><?//=\Yii::t('tc2012', 'Компания');?></label>
              <div class="required">
                <?php// echo CHtml::activeTextField($registerForm, 'Company');?>
              </div>
            </div>
            <div class="control-group">
              <label><?//=\Yii::t('tc2012', 'Должность');?></label>
              <?php// echo CHtml::activeTextField($registerForm, 'Position');?>
            </div>
          </div>
        </div>

        <small class="muted required-notice">
          <span class="required-asterisk">*</span> &mdash; <?//=\Yii::t('tc2012', 'поля обязательны для заполнения');?>
        </small>

        <div class="form-actions">
          <button id="event-user-register-submit" class="btn btn-inverse"><?//=\Yii::t('tc2012', 'Зарегистрировать');?></button>
          <button id="event-user-register-cancel" class="btn"><?//=\Yii::t('tc2012', 'Отмена');?></button>
        </div>
      <?php// CHtml::endForm();?>
    </td>
  </tr>
</script>

