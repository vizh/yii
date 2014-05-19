<?/**
 *  @var \link\models\forms\Datetime $formDatetime
 */
?>
<div id="preloader"></div>
<div class="cabinet">
  <a href="<?=$this->createUrl('/widget/link/index');?>" class="btn"><i class="icon-list"></i> <?=\Yii::t('app', 'Участники');?></a>
  <?if (!empty($schedule->notDistributedLinks)):?>
  <h3 class="m-bottom_20"><?=\Yii::t('app', 'Приглашения мне');?></h3>
  <?/** @var \link\models\Link $link */?>
  <?foreach ($schedule->notDistributedLinks as $link):?>
     <div class="row-fluid link-row">
       <div class="span5 clearfix">
         <div class="pull-left photo">
           <a href="<?=$link->User->getUrl();?>"><?=\CHtml::image($link->User->getPhoto()->get50px());?></a>
         </div>
         <h4><a href="<?=$link->User->getUrl();?>"><?=$link->User->getFullName();?></a></h4>
         <?if ($link->User->getEmploymentPrimary() !== null):?>
          <?=$link->User->getEmploymentPrimary();?>
         <?endif;?>
       </div>
       <div class="span7 text-right">
         <?=\CHtml::form('','',['class' => 'form-inline hide', 'data-url' => $this->createUrl('/widget/link/cabinet', ['action'=>'setDatetime','linkId'=>$link->Id])]);?>
            <input type="text" name="<?=\CHtml::activeName($formDatetime, 'Date');?>" placeholder="<?=$formDatetime->getAttributeLabel('Date');?>" class="input-small" value="" />
            <input type="text" name="<?=\CHtml::activeName($formDatetime, 'Time');?>" placeholder="<?=$formDatetime->getAttributeLabel('Time');?>" class="input-small" value="" />
            <?=\CHtml::submitButton(\Yii::t('app', 'Подтвердить'), ['class' => 'btn btn-success']);?>
         <?=\CHtml::endForm();?>
         <div class="btn-group">
           <button class="btn btn-success settime"><?=\Yii::t('app', 'Принять');?></button>
           <button class="btn btn-danger reject" data-url="<?=$this->createUrl('/widget/link/cabinet', ['action'=>'reject','linkId'=>$link->Id]);?>"><?=\Yii::t('app', 'Отклонить');?></button>
         </div>
       </div>
     </div>
  <?endforeach;?>
  <?endif;?>

  <?if (!empty($schedule->links)):?>
    <h3 class="m-bottom_20"><?=\Yii::t('app', 'Мои встречи');?></h3>
    <?foreach ($schedule->links as $link):?>
      <?$user = $link->OwnerId == \Yii::app()->getUser()->getId() ? $link->User : $link->Owner;?>
      <div class="row-fluid link-row">
        <div class="span8 clearfix">
          <h4 class="datetime"><?=$link->getFormattedMeetingTime('dd MMMM yyyy, HH:mm');?></h4>
          <div class="pull-left photo">
            <a href="<?=$user->getUrl();?>" target="_blank"><?=\CHtml::image($user->getPhoto()->get50px());?></a>
          </div>
          <h4><a href="<?=$user->getUrl();?>" target="_blank"><?=$user->getFullName();?></a></h4>
          <?if ($user->getEmploymentPrimary() !== null):?>
            <?=$user->getEmploymentPrimary();?>
          <?endif;?>
        </div>
        <?if ($link->OwnerId == \Yii::app()->getUser()->getId()):?>
        <div class="span4 text-right">
          <?=\CHtml::form('','',['class' => 'form-inline hide', 'data-url' => $this->createUrl('/widget/link/cabinet', ['action'=>'setDatetime','linkId'=>$link->Id])]);?>
            <input type="text" name="<?=\CHtml::activeName($formDatetime, 'Date');?>" placeholder="<?=$formDatetime->getAttributeLabel('Date');?>" class="input-small" value="<?=$link->getFormattedMeetingTime('dd.MM.yyyy');?>"/>
            <input type="text" name="<?=\CHtml::activeName($formDatetime, 'Time');?>" placeholder="<?=$formDatetime->getAttributeLabel('Time');?>" class="input-mini" value="<?=$link->getFormattedMeetingTime('HH:mm');?>"/>
            <?=\CHtml::submitButton(\Yii::t('app', 'Подтвердить'), ['class' => 'btn btn-success']);?>
          <?=\CHtml::endForm();?>
          <div class="btn-group">
            <button class="btn settime"><?=\Yii::t('app', 'Изменить время');?></button>
          </div>
        </div>
        <?endif;?>
      </div>
    <?endforeach;?>
  <?endif;?>