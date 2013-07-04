<?$roleDDlist = '<select name="RoleId" class="input-medium">';
foreach ($roles as $role):
  $roleDDlist .= '<option value="'.$role->Id.'" '.($role->Id == 1 ? 'selected="seleceted"' : '').'>'.$role->Title.'</option>';
endforeach;
$roleDDlist .= '</select>';
?>


<div class="row">
  <div class="span12">
    <?=\CHtml::form('','POST',array('id' => 'invite-generator'));?>
    <div class="alert m-bottom_40">
      <h4 class="m-bottom_10"><?=\Yii::t('app', 'Генерация пришглашений');?></h4>
      <?=$roleDDlist;?>
      <div class="input-prepend">
        <button class="btn" type="submit"><?=\Yii::t('app', 'Сгенерировать!');?></button>
        <input class="input-xxlarge" type="text" readonly="readonly" />
      </div>
    </div>
    <?=\CHtml::hiddenField('Action', 'generate');?>
    <?=\CHtml::endForm();?>
    
    <?if ($showInviteRequests):?>
      <h3><?=\Yii::t('app', 'Поданные заявки');?></h3>
      <?=\CHtml::form(\Yii::app()->createUrl('/partner/user/invite/'), 'get');?>
        <div class="row">
          <div class="span4">
            <?=\CHtml::activeLabel($filter, 'User');?>
            <?=\CHtml::activeTextField($filter, 'User');?>
          </div>
          <div class="span4">
            <?=\CHtml::activeLabel($filter, 'Data');?>
            <?=\CHtml::activeTextField($filter, 'Data');?>
          </div>
          <div class="span4">
            <?=\CHtml::activeLabel($filter, 'Approved');?>
            <?=\CHtml::activeDropDownList($filter, 'Approved', ['' => \Yii::t('app', 'Все')] + \event\models\Approved::getLabels());?>
          </div>
        </div>
        <div class="row m-top_20">
          <div class="span3">
            <button type="submit" class="btn btn-large"><i class=icon-search></i> <?=\Yii::t('app', 'Искать');?></button>
          </div>
        </div>
      <?=\CHtml::endForm();?>
      
      
      <?if (!empty($inviteRequests)):?>
        <table class="table table-striped">
          <thead>
            <th><?=\Yii::t('app', 'ФИО');?></th>
            <th><?=\Yii::t('app', 'Компания');?></th>
            <th><?=\Yii::t('app', 'Информация');?></th>
            <th><?=\Yii::t('app', 'Дата подачи');?></th>
            <th><?=\Yii::t('app', 'Статус');?></th>
          </thead>
          <tbody>
            <?foreach($inviteRequests as $request):?>
              <tr>
                <td><strong><?=$request->User->getFullName();?></strong><br/><?=\CHtml::mailto($request->User->Email);?><br/><?=\Yii::t('app', 'Тел.:');?> <?=$request->Phone;?></td>
                <td><?=$request->Company;?><br/>(<?=$request->Position;?>)</td>
                <td><?=$request->Info;?></td>
                <td><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy HH:mm', $request->CreationTime);?></td>
                <td>
                  <?if ($request->Approved == \event\models\Approved::Yes):?>
                  <span class="label label-success"><?=\event\models\Approved::getLabels()[\event\models\Approved::Yes];?></span>
                  <?elseif ($request->Approved == \event\models\Approved::No):?>
                    <span class="label label-important"><?=\event\models\Approved::getLabels()[\event\models\Approved::No];?></span>
                  <?else:?>
                    <?=\CHtml::form('', 'POST', array('class' => 'form-horizontal'));?>
                      <?=$roleDDlist;?>
                      <div class="btn-group m-top_5">
                        <button class="btn btn-success" type="submit" name="Action" value="approved" title="<?=\Yii::t('app', 'Подтвердить');?>"><i class="icon-ok-circle icon-white"></i></button>
                        <button class="btn btn-danger" type="submit" name="Action" value="disapproved" title="<?=\Yii::t('app', 'Отклонить');?>"><i class="icon-ban-circle icon-white"></i></button>
                      </div>
                      <?=\CHtml::hiddenField('InviteId', $request->Id);?>
                    <?=\CHtml::endForm();?>
                  <?endif;?>
                </td>
              </tr>
            <?endforeach;?>
          </tbody>
        </table>
      
        <?$this->widget('\application\widgets\Paginator', array('paginator' => $paginator));?>
      <?else:?>
        <div class="alert alert-error"><?=\Yii::t('app', 'Не найдено ни одной заявки на участие!');?></div>
      <?endif; ?>
    <?endif;?>
  </div>
</div>


