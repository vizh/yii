<?php
/**
 * @var $roles \event\models\Role[]
 * @var $users array
 */
?>
<form method="get">
    <div class="row">
        <div class="span4">
            <label>Роль:</label>
            <select name="filter[RoleId]">
                <option value="">Все роли</option>
                <?php foreach ($roles as $role):?>
                    <option value="<?php echo $role->RoleId;?>"
                        <?php if ( isset ($filter['RoleId']) && $filter['RoleId'] == $role->RoleId):?>selected="selected"<?php endif;?>>
                            <?php echo $role->Name;?>
                    </option>
                <?php endforeach;?>
            </select>
        </div>
        
        <div class="span4">
            <label>ФИО:</label>
            <input type="text" name="filter[Name]" value="<?php if ( isset ($filter['Name'])) { echo $filter['Name']; } ?>" />
        </div>
        
        <div class="span4">
            <label>ROCID:</label>
            <input type="text" name="filter[RocId]" value="<?php if ( isset ($filter['RocId'])) { echo $filter['RocId']; } ?>" />
        </div>
    </div>
    <div class="row">
        <div class="span12">
            <input type="submit" value="Искать" name="" class="btn" /> 
        </div>
    </div>
</form>

<h3>Всего по запросу <?=\Yii::t('', '{n} участник|{n} участника|{n} участников|{n} участника', $count);?></h3>


<?php if($users != null):?>
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
    <?php foreach ($users as $user):?>
        <tr>
            <td><h3><a target="_blank" href="/<?=$user['Participant']->User->RocId;?>/"><?php echo $user['Participant']->User->RocId;?></a></h3></td>
            <td>
                <strong><?php echo $user['Participant']->User->GetFullName();?></strong>
                <p>
                    <em><?php echo $user['Participant']->User->GetEmail() !== null ? $user['Participant']->User->GetEmail()->Email : $user['Participant']->User->Email; ?></em>
                </p>
                <?php if (!empty($user['Participant']->User->Phones)):?>
                    <p><em><?php echo urldecode($user['Participant']->User->Phones[0]->Phone);?></em></p>
                <?php endif;?>
            </td>
            <td width="30%">
                <?php $employment = $user['Participant']->User->EmploymentPrimary();?>
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
                <?php if ( !empty ($event->Days)):?>
                    <?php foreach ($user['DayRoles'] as $dayRole):?>
                        <p>
                            <strong><?php echo $dayRole->Day->Title;?></strong> - <?php echo $dayRole->EventRole->Name;?><br/>
                            <em><?php echo Yii::app()->dateFormatter->formatDateTime($dayRole->CreationTime, 'long');?></em>
                        </p>
                    <?php endforeach;?>
                <?php else:?>
                    <?php echo $user['Participant']->Role->Name;?><br/>
                    <em><?php echo Yii::app()->dateFormatter->formatDateTime($user['Participant']->CreationTime, 'long');?></em>
                <?php endif;?>
            </td>
            <td><a href="<?=Yii::app()->createUrl('/partner/user/edit', array('rocId' => $user['Participant']->User->RocId));?>" class="btn btn-info">Редактировать</a></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?php else:?>
    <div class="alert">По Вашему запросу нет ни одного участника.</div>
<?php endif;?>

<?php //echo $this->Paginator;?>