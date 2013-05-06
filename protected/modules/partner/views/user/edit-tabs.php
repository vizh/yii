<?php
/**
 * @var $user \user\models\User
 * @var $event \event\models\Event
 * @var $roles \event\models\Role[]
 * @var $participants \event\models\Participant[]
 */
?>
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
  <input type="hidden" name="runetId" value="<?=$user->RunetId;?>">
  <h3 class="indent-bottom1"><?=$user->getFullName();?> <sup  style="font-weight: normal;" class="muted"><?=$user->RunetId;?></sup></h3>
  <?$employment = $user->getEmploymentPrimary();
  if (!empty($employment)):?>
  <p>
    <strong><?=$employment->Company->Name;?></strong><br>
    <?=$employment->Position;?>
  </p>

  <?php else:?>
  <p><strong><em>Место работы не указано</em></strong></p>
  <?php endif;?>
</div>


<div class="span12 indent-top2">
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
</div>
</div>
