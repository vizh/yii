<?php

/**
 * @var \application\components\controllers\AdminMainController $this
 * @var \raec\models\forms\admin\Users $form
 * @var \raec\models\Commission $commission
 */

Yii::app()->getClientScript()->registerPackage('runetid.backbone');

$this->setPageTitle(\Yii::t('app', '{commission} &mdash; члены', ['{commission}' => $commission->Title]));
$this->getClientScripts()->registerPackage('runetid.backbone');

$webUser = Yii::app()->getUser();

?>

<?=CHtml::form('', 'POST', ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'])?>
<div class="btn-toolbar">
    <?=CHtml::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success'])?>
    <?=CHtml::button(Yii::t('app', 'Добавить участника'), ['class' => 'btn pull-right'])?>
</div>
<div class="well">
    <?if($webUser->hasFlash('success')):?>
        <div class="alert alert-success"><?=$webUser->getFlash('success')?></div>
    <?endif?>
    <?=CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>')?>
    <div class="row-fluid">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th><?=$form->getAttributeLabel('RunetId')?></th>
                <th><?=$form->getAttributeLabel('JoinDate')?></th>
                <th><?=$form->getAttributeLabel('ExitDate')?></th>
                <th><?=$form->getAttributeLabel('RoleId')?></th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<?=CHtml::endForm()?>

<script type="text/javascript">
    var commissionUsers = [];
    <?foreach($form->Users as $formUser):?>
    var commissionUser = {
        'Id':'<?=$formUser->Id?>',
        'RunetId':'<?=$formUser->RunetId?>',
        'JoinDate':'<?=$formUser->JoinDate?>',
        'ExitDate':'<?=$formUser->ExitDate?>',
        'RoleId':'<?=$formUser->RoleId?>',
        'FullName':'',
        'HasErrors':false
    };
    <?if(!$formUser->hasErrors('RunetId')):
    $user = \user\models\User::model()->byRunetId($formUser->RunetId)->find();
    ?>
    commissionUser['FullName'] = '<?=CHtml::encode($user->getFullName())?>'
    <?endif?>
    <?if($formUser->hasErrors()):?>
    commissionUser['HasErrors'] = true;
    <?endif?>
    commissionUsers.push(commissionUser);
    <?endforeach?>
</script>

<script type="text/template" id="commission-user-tpl">
    <tr class="warning">
        <td>
            <input name="<?=CHtml::resolveName($form, $_ = 'Users[<%=i%>][RunetId]')?>" value="" class="input-small"/>
            <span class="help-inline"></span>
        </td>
        <td><input name="<?=CHtml::resolveName($form, $_ = 'Users[<%=i%>][JoinDate]')?>" value="" class="input-small"/></td>
        <td><input name="<?=CHtml::resolveName($form, $_ = 'Users[<%=i%>][ExitDate]')?>" value="" class="input-small"/></td>
        <td>
            <select name="<?=CHtml::resolveName($form, $_ = 'Users[<%=i%>][RoleId]')?>">
                <? foreach ($form->getRoleList() as $roleId => $title): ?>
                    <option value="<?=$roleId?>"><?=$title?></option>
                <? endforeach ?>
            </select>
        </td>
    </tr>
</script>

<script type="text/template" id="commission-user-withdata-tpl">
    <tr <%if(HasErrors){%>class="error"<%}%>>
    <td>
        <input name="<?=CHtml::resolveName($form, $_ = 'Users[<%=i%>][RunetId]')?>" value="<%=RunetId%>" class="input-small"/>
        <span class="help-inline"><%=FullName%></span>
    </td>
    <td><input name="<?=CHtml::resolveName($form, $_ = 'Users[<%=i%>][JoinDate]')?>" value="<%=JoinDate%>" class="input-small"/></td>
    <td><input name="<?=CHtml::resolveName($form, $_ = 'Users[<%=i%>][ExitDate]')?>" value="<%=ExitDate%>" class="input-small"/></td>
    <td>
        <select name="<?=CHtml::resolveName($form, $_ = 'Users[<%=i%>][RoleId]')?>">
            <?foreach($form->getRoleList() as $roleId => $title):?>
                <option value="<?=$roleId?>" <%if(RoleId == <?=$roleId?>){%>selected<%}%>><?=$title?></option>
            <?endforeach?>
        </select>
        <%if(Id != ''){%>
        <input type="hidden" name="<?=CHtml::resolveName($form, $_ = 'Users[<%=i%>][Id]')?>" value="<%=Id%>"/>
        <%}%>
    </td>
    </tr>
</script>
