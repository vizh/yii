<script type="text/javascript">
  $(function(){
    $('#userTabs a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    });
  });
</script>

<form action="" method="post">
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
      <?php if (!empty($this->action->user)):?>
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
      <?php else:?>
      <div class="control-group">
        <label for="NameOrRocid" class="control-label"><strong>Фамилия и Имя</strong> или <strong>rocID</strong></label>
        <div class="controls">
          <input type="text" id="NameOrRocid" name="NameOrRocid" class="input-xlarge" placeholder="Введите ФИО">
          <p class="help-inline"><input type="hidden" name="rocId" id="RocId" value=""><span id="span_rocid" style="display: none;" class="label label-success"></span></p>
          <p class="help-block">
            <strong>Заметка:</strong> Просто начните набирать фамилию и имя или rocID пользователя. Здесь автоматически будут отображаться результаты поиска.
          </p>
        </div>
      </div>
      <?endif;?>
    </div>

    <div class="span6 indent-bottom1">
      <h4 class="indent-bottom1">Роль на мероприятии</h4>

      <select name="RoleId">
        <option value="0">Отменить участие</option>
        <?php foreach ($this->action->roles as $role):?>
        <option <?=!empty($participant)&&$participant->RoleId==$role->RoleId?'selected="selected"':'';?> value="<?php echo $role->RoleId;?>"><?php echo $role->Name;?></option>
        <?php endforeach;?>
      </select>
    </div>

    <div class="span12">
      <input class="btn btn-primary" type="submit" value="Сохранить">
    </div>

    <div class="span12 indent-top2">
      <ul class="nav nav-tabs" id="userTabs">
        <li class="active"><a href="#participant">Участие в мероприятии</a></li>
        <li><a href="#coupon">Промо-коды</a></li>
        <li><a href="#orderitem">Заказы</a></li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="participant">

        </div>
        <div class="tab-pane" id="coupon">

        </div>
        <div class="tab-pane" id="orderitem">

        </div>
      </div>
    </div>

  </div>
</form>