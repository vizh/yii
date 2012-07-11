<ul class="nav nav-pills">
  <li class="active">
    <a href="<?=RouteRegistry::GetUrl('partner', 'user', 'index');?>">Участники</a>
  </li>
  <li>
    <a href="<?=RouteRegistry::GetUrl('partner', 'user', 'edit');?>">Редактирование</a>
  </li>
</ul>


<form method="get">
    <div class="row">
        <div class="span4">
            <label>Роль:</label>
            <select name="filter[RoleId]">
                <option value="">Все роли</option>
                <?php foreach ($this->Roles as $role):?>
                    <option value="<?php echo $role->RoleId;?>"
                        <?php if ( isset ($this->Filter['RoleId']) && $this->Filter['RoleId'] == $role->RoleId):?>selected="selected"<?php endif;?>>
                            <?php echo $role->Name;?>
                    </option>
                <?php endforeach;?>
            </select>
        </div>
        
        <div class="span4">
            <label>ФИО:</label>
            <input type="text" name="filter[Name]" value="<?php if ( isset ($this->Filter['Name'])) { echo $this->Filter['Name']; } ?>" />
        </div>
        
        <div class="span4">
            <label>ROCID:</label>
            <input type="text" name="filter[RocId]" value="<?php if ( isset ($this->Filter['RocId'])) { echo $this->Filter['RocId']; } ?>" />
        </div>
    </div>
    <div class="row">
        <div class="span12">
            <input type="submit" value="Искать" name="" class="btn" /> 
        </div>
    </div>
</form>

<h3>Всего по запросу <?=\Yii::t('', '{n} участник|{n} участника|{n} участников|{n} участника', $this->Count);?></h3>


<?php if($this->Users != null):?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ROCID</th>
            <th>Ф.И.О.</th>
            <th>Работа</th>
            <th>Роль</th>
            <th>Управление</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($this->Users as $user):?>
        <tr>
            <td><h3><a target="_blank" href="/<?=$user['EventUser']->User->RocId;?>/"><?php echo $user['EventUser']->User->RocId;?></a></h3></td>
            <td>
                <strong><?php echo $user['EventUser']->User->GetFullName();?></strong>
                <p>
                    <em><?php echo $user['EventUser']->User->GetEmail() !== null ? $user['EventUser']->User->GetEmail()->Email : $user['EventUser']->User->Email; ?></em>
                </p>
                <?php if (!empty($user['EventUser']->User->Phones)):?>
                    <p><em><?php echo urldecode($user['EventUser']->User->Phones[0]->Phone);?></em></p>
                <?php endif;?>
            </td>
            <td width="30%">
                <?php $employment = $user['EventUser']->User->EmploymentPrimary();?>
                <?php if ($employment !== null):?>
                    <strong><?php echo $employment->Company->Name;?></strong>
                    <p class="position">
                        <?php echo $employment->Position;?>
                    </p>
                <?php else:?>
                    Место работы не указано
                <?php endif;?>
            </td>
            <td>
                <?php if ( !empty ($this->Event->Days)):?>
                    <?php foreach ($user['DayRoles'] as $dayRole):?>
                        <p>
                            <strong><?php echo $dayRole->Day->Title;?></strong> - <?php echo $dayRole->EventRole->Name;?><br/>
                            <em><?php echo yii::app()->dateFormatter->formatDateTime($dayRole->CreationTime, 'long');?></em>
                        </p>
                    <?php endforeach;?>
                <?php else:?>
                    <?php echo $user['EventUser']->EventRole->Name;?><br/>
                    <em><?php echo yii::app()->dateFormatter->formatDateTime($user['EventUser']->CreationTime, 'long');?></em>
                <?php endif;?>
            </td>
            <td><a href="<?=RouteRegistry::GetUrl('partner', 'user', 'edit', array('rocId' => $user['EventUser']->User->RocId));?>" class="btn btn-info">Редактировать</a></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?php else:?>
    <div class="alert">По Вашему запросу нет ни одного участника.</div>
<?php endif;?>

<?php echo $this->Paginator;?>