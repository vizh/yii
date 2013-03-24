<?php
/**
 * @var $participants \event\models\Participant[]
 * @var $couponActivation \pay\models\CouponActivated
 * @var $orderItems \pay\models\OrderItem[]
 */
?>
<script type="text/javascript">
  $(function(){
    $('#userTabs a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    });
  });
</script>


<div class="row">
<div class="span12 indent-bottom3">
  <h2>Редактирование участника</h2>
</div>

<div class="span12">
  <?if (!empty($this->action->error)):?>
  <div class="alert alert-error">
    <button data-dismiss="alert" class="close">×</button>
    <strong>Ошибка!</strong> <?=$this->action->error;?>
  </div>
  <?endif;?>
</div>

<div class="span12 indent-bottom2">
  <input type="hidden" name="rocId" value="<?=$this->action->user->RocId;?>">
  <h3 class="indent-bottom1"><?=$this->action->user->GetFullName();?> <sup  style="font-weight: normal;" class="muted"><?=$this->action->user->RocId;?></sup></h3>
  <?php
  $employment = $this->action->user->GetPrimaryEmployment();
  ?>
  <?php if (!empty($employment)):?>
  <p>
    <strong><?=$employment->Company->Name;?></strong><br>
    <?=$employment->Position;?>
  </p>

  <?php else:?>
  <p><strong><em>Место работы не указано</em></strong></p>
  <?php endif;?>

  <p>
    <em><?php echo $this->action->user->GetEmail() !== null ? $this->action->user->GetEmail()->Email : $this->action->user->Email; ?></em>
  </p>
  <?php if (!empty($this->action->user->Phones)):?>
  <p><em><?php echo urldecode($this->action->user->Phones[0]->Phone);?></em></p>
  <?php endif;?>
</div>


<div class="span12 indent-top2">
<ul class="nav nav-tabs" id="userTabs">
  <li class="active"><a href="#event">Участие в мероприятии</a></li>
  <li><a href="#coupon">Промо-коды</a></li>
  <li><a href="#orderitem">Заказы</a></li>

  <?if (Yii::app()->partner->getAccount()->EventId == 391):?>
  <li><a href="#personal">Личные данные</a></li>
  <?endif;?>
</ul>

<div id="user-edit-tabs" class="tab-content">
<div class="tab-pane active" id="event">

  <?foreach ($participants as $dayId => $participant):?>
  <div class="row">
    <div class="span4">
      <?if ($dayId === 0):?>
      <span class="large">Роль на мероприятии</span>
      <?else:?>
      <span class="large"><?=$this->action->days[$dayId]->Title;?></span>
      <?endif;?>
    </div>
    <div class="span8">
      <select data-day-id="<?=$dayId;?>" name="roleId">
        <option value="0" <?=$participant->RoleId == 0 ? 'selected="selected"' : '';?>>Не участвует</option>
        <?php foreach ($this->action->roles as $role):?>
        <option value="<?=$role->RoleId;?>" <?=$participant->RoleId == $role->RoleId ? 'selected="selected"' : '';?>><?=$role->Name;?></option>
        <?endforeach;?>
      </select>
    </div>
  </div>
  <?endforeach;?>

  <?if (Yii::app()->partner->getAccount()->EventId == 391):?>
  <div id="options" class="row">
    <div class="span12">
      <ul class="unstyled indent-top3">
        <li style="">
          <label class="checkbox">
            <input type="checkbox" value="1" checked="checked" disabled="disabled">
            Выдача бейджа
          </label>
        </li>
        <li>
          <label class="checkbox">
            <input type="checkbox" value="1" checked="checked" disabled="disabled">
            Чип
          </label>
        </li>
        <li>
          <label class="checkbox">
            <input type="checkbox" name="OptionProductId" value="<?=$option1->ProductId;?>" <?=!empty($optionOrderItem1) && $optionOrderItem1->Paid == 1 ? 'checked="checked"' : '';?>>
            <?=$option1->Title;?>
          </label>
        </li>
        <li>
          <label class="checkbox">
            <input type="checkbox" name="OptionProductId" value="<?=$option2->ProductId;?>" <?=!empty($optionOrderItem2) && $optionOrderItem2->Paid == 1 ? 'checked="checked"' : '';?>>
            <?=$option2->Title;?>
          </label>
        </li>
      </ul>
    </div>
  </div>
  <?endif;?>

</div>

<div class="tab-pane" id="coupon">
  <div class="row indent-bottom2">
    <div class="span12">
      <?if (!empty($couponActivation)):?>
      <p class="large">Активирован промо-код: <strong class="text-success"><?=$couponActivation->Coupon->Code;?></strong></p>
      <p class="large">Размер скидки: <strong><?=$couponActivation->Coupon->Discount * 100;?>%</strong></p>
      <p>
        <?if (empty($couponActivation->OrderItems)):?>
        <a onclick="return confirm('Вы уверены, что хотите удалить промо-код участника?');" class="btn btn-danger" href="<?=\Yii::app()->createUrl('/partner/user/edit', array('rocId' => $this->action->user->RocId, 'do' => 'deleteCoupon'));?>">Удалить промо-код</a>
        <?else:?>
        <span class="label label-success">По промо-коду произведена оплата.</span>
        <?endif;?>
      </p>
      <?else:?>
      <h4 class="text-error">Нет активированных промо-кодов</h4>
      <?endif;?>
    </div>
  </div>

  <div class="row">
    <div class="span12">
      <h4>Активировать новый промо-код</h4>
    </div>
    <div class="span6">
      <div class="input-append">
        <input class="span4" id="couponCode" name="couponCode" placeholder="Введите промо-код" type="text"><a id="couponCodeActivate" class="btn btn-success" href="">Активировать!</a>
      </div>
    </div>
    <div id="couponError" class="span6"></div>
  </div>
</div>
<div class="tab-pane" id="orderitem">
  <div class="row">
    <div class="span12">
      <p>
        <a target="_blank" class="btn btn-success" href="<?=\Yii::app()->createUrl('/partner/orderitem/create');?>">Перейти к интерфейсу добавления заказов</a>
      </p>

      <?if (!empty($orderItems)):?>
      <table class="table table-striped">
        <thead>
        <th>Товар</th>
        <th>Плательщик</th>
        <th>Получатель</th>
        <th>Сумма</th>
        <th>Статус</th>
        </thead>
        <tbody>
          <?php foreach ($orderItems as $orderItem):?>
        <tr>
          <td><?php echo $orderItem->Product->Title;?></td>
          <td>
            <?php echo $orderItem->Payer->RocId;?>, <strong><?php echo $orderItem->Payer->GetFullName();?></strong>
            <p><em><?php echo $orderItem->Payer->GetEmail() !== null ? $orderItem->Payer->GetEmail()->Email : $orderItem->Payer->Email; ?></em></p>
          </td>
          <td>
            <?php echo $orderItem->Owner->RocId;?>, <strong><?php echo $orderItem->Owner->GetFullName();?></strong>
            <p><em><?php echo $orderItem->Owner->GetEmail() !== null ? $orderItem->Owner->GetEmail()->Email : $orderItem->Owner->Email; ?></em></p>
          </td>
          <td>
            <strong><?=$orderItem->PriceDiscount();?></strong>&nbsp;руб.
          </td>
          <td>
            <?php if ($orderItem->Paid == 1):?>
            <span class="label label-success">Оплачен</span>
            <?php else:?>
            <span class="label">Не оплачен</span>
            <?php endif;?>

            <?php if ($orderItem->Deleted == 1 && $orderItem->Paid == 0):?>
            <span class="label label-warning">Удален</span>
            <?php endif;?>
          </td>
        </tr>
          <?php endforeach;?>
        </tbody>
      </table>

      <?else:?>
      <?endif;?>
    </div>
  </div>
</div>

<?if (Yii::app()->partner->getAccount()->EventId == 391):?>
<div class="tab-pane" id="personal">
  <div class="row">
    <div class="span12">
      <?php echo CHtml::beginForm('', 'POST', array('class' => 'form-horizontal'));?>
      <input type="hidden" name="do" value="editUser">

      <div class="control-group">
        <label class="control-label"><?php echo CHtml::activeLabel($editFormModel, 'LastName');?></label>
        <div class="controls">
          <div class="row">
            <?php foreach ($locales as $locale):?>
            <div class="span4">
              <div class="input-append">
                <?php echo CHtml::activeTextField($editFormModel, 'LastName['.$locale.']');?>
                <span class="add-on m-right_20"><?php echo $locale;?></span>
              </div>
            </div>
            <?php endforeach;?>
          </div>
        </div>
      </div>

      <div class="control-group">
        <label class="control-label"><?php echo CHtml::activeLabel($editFormModel, 'FirstName');?></label>
        <div class="controls">
          <div class="row">
            <?php foreach ($locales as $locale):?>
            <div class="span4">
              <div class="input-append m-bottom_10">
                <?php echo CHtml::activeTextField($editFormModel, 'FirstName['.$locale.']');?>
                <span class="add-on m-right_20"><?php echo $locale;?></span>
              </div>
            </div>
            <?php endforeach;?>
          </div>
        </div>
      </div>

      <div class="control-group">
        <label class="control-label"><?php echo CHtml::activeLabel($editFormModel, 'FatherName');?></label>
        <div class="controls">
          <div class="row">
            <?php foreach ($locales as $locale):?>
            <div class="span4">
              <div class="input-append">
                <?php echo CHtml::activeTextField($editFormModel, 'FatherName['.$locale.']');?>
                <span class="add-on m-right_20"><?php echo $locale;?></span>
              </div>
            </div>
            <?php endforeach;?>
          </div>
        </div>
      </div>

      <div class="control-group">
        <?=CHtml::activeHiddenField($editFormModel, 'CompanyId');?>
        <?=CHtml::activeLabel($editFormModel, 'CompanyName', array('class' => 'control-label', 'style' => 'padding-top: 20px;'));?>
        <div class="controls">
          <div class="row">


            <?php foreach ($locales as $locale):?>
            <div class="span4">
              <span class="help-block"><?=$locale=='ru'? 'Оригинальное название': 'Английское название';?></span>
              <?php echo CHtml::activeTextField($editFormModel, 'CompanyName['.$locale.']');?>
            </div>
            <?php endforeach;?>
          </div>
        </div>
      </div>


      <div class="control-group">
        <div class="controls">
          <?php echo CHtml::submitButton('Сохранить', array('class' => 'btn btn-primary'));?>
        </div>
      </div>
      <?php echo CHtml::endForm();?>
    </div>
  </div>
</div>
  <?endif;?>
</div>
</div>
</div>