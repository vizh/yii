<?php
/**
 * @var $user \user\models\User
 * @var $event \event\models\Event
 * @var $roles \event\models\Role[]
 * @var $participants \event\models\Participant[]
 */
?>
<div class="row">
<div class="span12 m-bottom_30">
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
  <input type="hidden" name="runetId" value="<?=$user->RunetId;?>">
  <h3><?=\Yii::t('app', 'Персональные данные');?></h3> 
  <div class="row">
    <div class="span1">
      <img src="<?=$user->getPhoto()->get58px();?>" title="" class="pull-left" />
    </div>
    <div class="span10">
      <strong>
        <?php
          echo $user->getFullName();
          $user->setLocale('en');
          echo ' ('.$user->getFullName().')';
        ?>
      </strong>
      <?$employment = $user->getEmploymentPrimary();?><sup><?=$user->RunetId;?></sup>
      <?if ($employment !== null):?>
        <br/><span class="small">
          <?php
            echo $employment->Company->Name;
            $employment->Company->setLocale('en');
            echo ' ('.$employment->Company->Name.')';
          ?>
        </span>
      <?endif;?>
      <div class="m-top_10"><a href="<?=$this->createUrl('/partner/user/translate', array('runetId' => $user->RunetId));?>" class="btn btn-mini"><?=\Yii::t('app', 'Редактировать');?></a></div>
    </div>
  </div>
</div>


<div class="span12 indent-top2">
  <h3><?=\Yii::t('app', 'Роль на мероприятии');?></h3>
  <?if (sizeof($event->Parts) === 0):?>
      <?$roleId = isset($participants[0]) ? $participants[0]->RoleId : null;?>
      <div class="row">
        <div class="span4">
          <label for="roleId" class="large">Роль на мероприятии</label>
        </div>
        <div class="span8">
          <select data-part-id="" id="roleId" name="roleId">
            <option value="0" <?=$roleId === null ? 'selected="selected"' : '';?>>Не участвует</option>
            <?php foreach ($roles as $role):?>
              <option value="<?=$role->Id;?>" <?=$roleId == $role->Id ? 'selected="selected"' : '';?>><?=$role->Title;?></option>
            <?endforeach;?>
          </select>
        </div>
      </div>
  <?else:?>
      <?foreach ($event->Parts as $part):?>
        <?$roleId = isset($participants[$part->Id]) ? $participants[$part->Id]->RoleId : null;?>
      <div class="row">
        <div class="span4">
          <label for="roleId<?=$part->Id;?>" class="large"><?=$part->Title;?></label>
        </div>
        <div class="span8">
          <select data-part-id="<?=$part->Id;?>" id="roleId<?=$part->Id;?>" name="roleId">
            <option value="0" <?=$roleId === null ? 'selected="selected"' : '';?>>Не участвует</option>
            <?php foreach ($roles as $role):?>
              <option value="<?=$role->Id;?>" <?=$roleId == $role->Id ? 'selected="selected"' : '';?>><?=$role->Title;?></option>
            <?endforeach;?>
          </select>
        </div>
      </div>
      <?endforeach;?>
  <?endif;?>

  <?/** TODO: это от devcon14, нужно не забыть убрать */?>
  <?if ($event->Id == 831):?>
    <div class="row">
      <div class="span4">
        <label for="event831Product" class="large">Продукт</label>
      </div>
      <div class="span8">
        <form class="form-inline" method="post">
        <?=\CHtml::dropDownList('event831Product', $event831OrderItem !== null ? $event831OrderItem->Product->Id : '', ['' => 'Не задан'] + \CHtml::listData($event831Products, 'Id', 'Title'));?>
        <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn']);?>
        </form>
      </div>
    </div>
  <?endif;?>
</div>
</div>
