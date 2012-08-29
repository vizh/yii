<ul class="nav nav-pills">
    <li>
        <a href="<?=RouteRegistry::GetUrl('partner', 'user', 'index');?>">Участники</a>
    </li>
    <li class="active">
        <a href="<?=RouteRegistry::GetUrl('partner', 'user', 'edit');?>">Редактирование</a>
    </li>
</ul>

<form action="" method="post">
    <div class="row">
        <div class="span12 indent-bottom3">
            <h2>Редактирование статуса участника</h2>
        </div>

        <div class="span12">
            <?if (!empty($this->Error)):?>
            <div class="alert alert-error">
                <button data-dismiss="alert" class="close">×</button>
                <strong>Ошибка!</strong> <?=$this->Error;?>
            </div>
            <?endif;?>
        </div>

        <div class="span12 indent-bottom2">
        <?php if (!empty($this->User)):?>
            <h3 class="indent-bottom1"><?=$this->User->GetFullName();?></h3>
            <?php 
                $employment = $this->User->GetPrimaryEmployment();
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
                <em><?php echo $this->User->GetEmail() !== null ? $this->User->GetEmail()->Email : $this->User->Email; ?></em>
            </p>
            <?php if (!empty($this->User->Phones)):?>
                <p><em><?php echo urldecode($this->User->Phones[0]->Phone);?></em></p>
            <?php endif;?>
        <?php else:?>
        <div class="control-group">
            <label for="NameOrRocid" class="control-label"><strong>Фамилия и Имя</strong> или <strong>rocID</strong></label>
            <div class="controls">
                <input type="text" id="NameOrRocid" name="NameOrRocid" class="input-xlarge" placeholder="Введите ФИО">
                <p class="help-inline"><input type="hidden" name="RocId" id="RocId" value=""><span id="span_rocid" style="display: none;" class="label label-success"></span></p>
                <p class="help-block">
                    <strong>Заметка:</strong> Просто начните набирать фамилию и имя или rocID пользователя. Здесь автоматически будут отображаться результаты поиска.
                </p>
            </div>
        </div>
        <?endif;?>
        </div>

        <div class="span6 indent-bottom1">
            <h4 class="indent-bottom1">Роль на мероприятии</h4>
            <?php if ( !empty ($this->Event->Days)):?>
                <table class="table">
                <?php foreach ($this->Event->Days as $eventDay):?>
                    <tr>
                        <td><?php echo $eventDay->Title;?></td>
                        <td>
                            <select name="RoleId[<?php echo $eventDay->DayId;?>]">
                                <option value="0">Отменить участие</option>
                                <?php foreach ($this->Roles as $role):?>
                                    <option value="<?php echo $role->RoleId;?>" 
                                        <?php if ( isset ($this->EventUserDays[$eventDay->DayId]) && $this->EventUserDays[$eventDay->DayId] == $role->RoleId):?>selected="selected"<?php endif;?>>
                                            <?php echo $role->Name;?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </td>
                    </tr>
                <?php endforeach;?>
                </table>
            <?php else:?>
            <select name="RoleId">
                <option value="0">Отменить участие</option>
                <?php foreach ($this->Roles as $role):?>
                    <option <?=!empty($this->EventUser)&&$this->EventUser->RoleId==$role->RoleId?'selected="selected"':'';?> value="<?php echo $role->RoleId;?>"><?php echo $role->Name;?></option>
                <?php endforeach;?>
            </select>
            <?php endif;?>
        </div>

        <div class="span12">
            <input class="btn btn-primary" type="submit" value="Сохранить">
        </div>
    </div>
</form>