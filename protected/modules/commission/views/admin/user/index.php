<?=\CHtml::form('','POST',array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'));?>
<div class="btn-toolbar">
  <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), array('class' => 'btn btn-success'));?>
</div>
<div class="well">
  <div class="row-fluid">
    <?if (\Yii::app()->user->hasFlash('success')):?>
      <div class="alert alert-success"><?=\Yii::app()->user->getFlash('success');?></div>
    <?endif;?>
    <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
      
    <table class="table table-striped table-bordered commission-user-items">
      <thead>
        <tr>
          <th><?=$form->getAttributeLabel('RunetId');?></th>
          <th><?=$form->getAttributeLabel('JoinDate');?></th>
          <th><?=$form->getAttributeLabel('ExitDate');?></th>
          <th><?=$form->getAttributeLabel('RoleId');?></th>
        </tr>
      </thead>
      <tbody>
       
      </tbody>
    </table>
  </div>
</div>
<?=\CHtml::endForm();?>

<script type="text/javascript">
  var commissionUsers = [];
  <?foreach ($form->Users as $formUser):?>
    var commissionUser = {
      'Id'       : '<?=$formUser->Id;?>',
      'RunetId'  : '<?=$formUser->RunetId;?>',
      'JoinDate' : '<?=$formUser->JoinDate;?>',
      'ExitDate' : '<?=$formUser->ExitDate;?>',
      'RoleId'   : '<?=$formUser->RoleId;?>',
      'FullName' : '',
    };
    <?php 
      $user = \user\models\User::model()->byRunetId($formUser->RunetId)->find();
      if ($user !== null):?>
        commissionUser['FullName'] = '<?=$user->getFullName();?>';
    <?endif;?>
    commissionUsers.push(commissionUser);
  <?endforeach;?>
</script>

<script type="text/template" id="commission-user-tpl">
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'Role');?>
  </div>
</script>

<script type="text/template" id="commission-user-withdata-tpl">
  <tr>
    <td>
      <input type="text" name="<?=\CHtml::resolveName($form, $_ = 'Users[<%=i%>][RunetId]');?>" value="<%=RunetId%>" class="input-small" disabled="disabled"/>
      <span class="help-inline"><%=FullName%></span>        
    </td>
    <td><input type="text" name="<?=\CHtml::resolveName($form, $_ = 'Users[<%=i%>][JoinDate]');?>" value="<%=JoinDate%>" class="input-small"/></td>
    <td><input type="text" name="<?=\CHtml::resolveName($form, $_ = 'Users[<%=i%>][ExitDate]');?>" value="<%=ExitDate%>" class="input-small"/></td>       
    <td>
      <select name="<?=\CHtml::resolveName($form, $_ = 'Users[<%=i%>][RoleId]');?>">
        <?foreach(\commission\models\Role::model()->findAll() as $role):?>
          <option value="<?=$role->Id;?>" <%if(RoleId != <?=$role->Id;?>){%>selected<%}%>><?=$role->Title;?></option>
        <?endforeach;?>
      </select>
    </td>  
  </tr>
</script>
