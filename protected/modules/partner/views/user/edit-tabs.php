<?php
/**
 * @var $participants \event\models\Participant[]
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
    <h3 class="indent-bottom1"><?=$this->action->user->GetFullName();?></h3>
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

      </div>

      <div class="tab-pane" id="coupon">

      </div>
      <div class="tab-pane" id="orderitem">

      </div>
    </div>
  </div>
</div>