<div class="btn-toolbar"></div>
<div class="well">
  <div class="row-fluid">
    <div class="span12">
      <input type="text" name="CompanyName" class="input-block-level" placeholder="<?=\Yii::t('app','Название компании');?>" value="<?if ($company !== null):?><?=!empty($company->FullName) ? $company->FullName : $company->Name;?><?endif;?>" />
    </div>
    
    <?if ($company !== null):?>
      <table class="table table-striped">
        <tbody>
          <?foreach ($company->LinkModerators as $linkModerator):?>
            <tr>
              <td style="width: 80%; vertical-align: middle;"><strong><?=$linkModerator->User->RunetId;?>, <?=$linkModerator->User->getFullName();?></strong></td>
              <td>
                <a href="<?=$this->createUrl('/company/admin/moderator/index', array('companyId' => $company->Id, 'Action' => 'RemoveModerator', 'RunetId' => $linkModerator->User->RunetId));?>" class="btn btn-danger">
                  <i class="icon-remove icon-white"></i> <?=\Yii::t('app','Удалить');?>
                </a>
              </td>
            </tr>
          <?endforeach;?>
          <tr>
            <td>
              <?=\CHtml::form('', 'POST', array('class' => 'form-inline create-moderator'));?>
                <?=\CHtml::textField('RunetId', '', array('placeholder' => \Yii::t('app', 'RUNETID пользователя')));?>
                <?=\CHtml::submitButton(\Yii::t('app', 'Добавить модератора'), array('class' => 'btn'));?>
                <?=\CHtml::hiddenField('Action', 'CreateModerator');?>
              <?=\CHtml::endForm();?>
            </td>
            <td></td>
          </tr>
        </tbody>
      </table>
    <?endif;?>
  </div>
</div>
<?=\CHtml::endForm();?>