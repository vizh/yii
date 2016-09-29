<section id="section" role="main">
    <style>.b-event-promo .side, .b-event-promo .all {display: none;}</style>
    <div class="b-event-promo">
      <div class="container">
        <div class="row">
          <div class="side left span4">
            <img src="<?$event->GetLogo()?>" width="95" height="53" alt="" class="logo">
          </div>

          <div class="details span4 offset4">
            <h2 class="title"><?=$event->Name?></h2>
            <div class="type">
              <img src="/images/blank.gif" alt="" class="i-event_small i-event_conference">Конференция
            </div>
            <div class="duration">
              <span class="datetime">
                <span class="date">
                  <?$dateFormatter = \Yii::app()->dateFormatter?>
                  <?if($event->DateStart == $event->DateEnd):?>
                    <span class="day"><?=$dateFormatter->format('dd', $event->DateEnd)?></span> <span class="month"><?=$dateFormatter->format('MMMM', $event->DateEnd)?></span> <span class="year"><?=$dateFormatter->format('yyyy', $event->DateEnd)?></span>
                  <?php else:?>
                    <?if($dateFormatter->format('M', $event->DateStart) == $dateFormatter->format('M', $event->DateEnd)):?>
                      <span class="day"><?=$dateFormatter->format('dd', $event->DateStart)?>-<?=$dateFormatter->format('dd', $event->DateEnd)?></span> <span class="month"><?=$dateFormatter->format('MMMM', $event->DateEnd)?></span> <span class="year"><?=$dateFormatter->format('yyyy', $event->DateEnd)?></span>
                    <?php else:?>

                    <?endif?>
                  <?endif?>
                </span>
              </span>
            </div>
            <div class="location"><?=$event->GetAddress()?></div>
          </div>
        </div>
      </div>
    </div>

    <div class="event-register">
      <div class="container">

        <div class="tabs clearfix">
          <div class="tab current pull-left">
            <span class="number img-circle">1</span>
            Регистрация
          </div>
          <div class="tab pull-left">
            <span class="number img-circle">2</span>
            Оплата
          </div>
        </div>

        <table class="table thead-actual">
          <thead>
            <tr>
              <th>Тип билета</th>
              <th class="col-width t-right">Цена</th>
              <th class="col-width t-right">Кол-во</th>
              <th class="col-width t-right last-child">Сумма</th>
            </tr>
          </thead>
        </table>


        <?=CHtml::beginForm('', 'POST', array('class' => 'registration'))?>
          <?foreach($products as $product):?>
            <table class="table">
              <thead>
                <tr data-price="<?=$product->GetPrice()?>">
                  <th>
                    <h4 class="title"><?=$product->Title?> <i class="icon-chevron-up"></i></h4>
                  </th>
                  <th class="col-width t-right"><span class="number"><?=$product->GetPrice()?></span> Р</th>
                  <th class="col-width t-right">
                    <?=CHtml::activeDropDownList($orderForm, 'Count['.$product->ProductId.']', array(0,1,2,3,4,5,6,7,8,9,10), array('class' => 'input-mini form-element_select'))?>
                  </th>
                  <th class="col-width t-right last-child"><b class="number mediate-price">0</b> Р</th>
                </tr>
              </thead>
              <tbody>
                <tr class="user-action-row">
                  <td>
                    <input type="text" class="input-xxlarge form-element_text autocomplete" placeholder="Введите ФИО или RUNET-ID" data-productid="<?=$product->ProductId?>">
                  </td>
                  <td colspan="3" class="last-child">
                    <button class="btn pull-right btn-user_register" disabled>Зарегистрировать</button>
                    <button class="btn pull-right btn-user_add" style="display: none;">Добавить</button>
                  </td>
                </tr>
                <tr class="user-row">
                  <td>
                    <label class="checkbox inline muted">
                      <?=CHtml::activeCheckBox($orderForm, 'Owners['.$product->ProductId.']['.\Yii::app()->user->getId().']')?>
                      Я, <?=\Yii::app()->user->getCurrentUser()->GetFullName()?>
                    </label>
                  </td>
                  <td colspan="3" class="last-child">
                    <?=CHtml::activeTextField($orderForm, 'PromoCodes['.$product->ProductId.']['.\Yii::app()->user->getId().']', array('class' => 'input-medium pull-right t-center form-element_text', 'placeholder' => 'Промо код'))?>
                  </td>
                </tr>
              </tbody>
            </table>
          <?endforeach?>

          <div class="total">
            <span>Итого:</span> <b id="total-price" class="number">0</b> Р
          </div>

          <div class="actions">
            <?=CHtml::submitButton('Перейти к оплате', array('class' => 'btn btn-large btn-primary'))?>
            </a>
          </div>
        <?=CHtml::endForm()?>

      </div>
    </div>
  </section>

  <!--#include virtual="_footer.html" -->
  <script type="text/template" id="event-user-row">
    <tr class="user-row">
      <td>
        <label class="checkbox inline muted">
          <input type="hidden" value="0" name="<?=CHtml::resolveName($orderForm, $_ = 'Owners[<%=productid%>][<%=rocid%>]')?>" />
          <input name="<?=CHtml::resolveName($orderForm, $_ = 'Owners[<%=productid%>][<%=rocid%>]')?>" value="1" type="checkbox" /><%= username %>
        </label>
        </td>
        <td colspan="3" class="last-child">
          <input type="text" name="<?=CHtml::resolveName($orderForm, $_ = 'PromoCodes[<%=productid%>][<%=rocid%>]')?>" class="input-medium pull-right t-center form-element_text" placeholder="Промо код">
        </td>
      </tr>
  </script>

  <script type="text/template" id="event-user-register">
    <tr>
      <td colspan="4" class="last-child">
        <?=CHtml::beginForm('', 'POST', array('class' => 'user-register'))?>
          <legend>Регистрация нового участника</legend>

          <div class="clearfix">
            <div class="pull-left">
              <div>
                <label>Фамилия</label>
                <div class="required">
                  <?=CHtml::activeTextField($registerForm, 'LastName')?>
                </div>
              </div>
              <div>
                <label>Имя</label>
                <div class="required">
                  <?=CHtml::activeTextField($registerForm, 'FirstName')?>
                </div>
              </div>
              <div>
                <label>Отчество</label>
                <?=CHtml::activeTextField($registerForm, 'SecondName')?>
              </div>
              <div>
                <label>Эл. почта</label>
                <div class="required">
                  <?=CHtml::activeTextField($registerForm, 'Email')?>
                </div>
              </div>
            </div>
            <div class="pull-right">
              <div>
                <label>Телефон</label>
                <?=CHtml::activeTextField($registerForm, 'Phone')?>
              </div>
              <div>
                <label>Компания</label>
                <div class="required">
                  <?=CHtml::activeTextField($registerForm, 'Company')?>
                </div>
              </div>
              <div>
                <label>Должность</label>
                <?=CHtml::activeTextField($registerForm, 'Position')?>
              </div>
            </div>
          </div>

          <small class="muted required-notice">
            <span class="required-asterisk">*</span> &mdash; поля, обязательные для заполнения
          </small>

          <div class="form-actions">
            <button id="event-user-register-submit" class="btn btn-primary">Зарегистрировать</button>
            <button id="event-user-register-cancel" class="btn">Отмена</button>
          </div>
        <?php CHtml::endForm()?>
      </td>
    </tr>
  </script>