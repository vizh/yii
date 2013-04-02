<div class="row-fluid">
  <div class="btn-toolbar">
    <?=\CHtml::form($this->createUrl('/event/admin/list/index'), 'GET', array('class' => 'form-inline'));?>
      <?=\CHtml::textField('Query', \Yii::app()->request->getParam('Query', ''), array('placeholder' => \Yii::t('app', 'ID или навзание мероприятия'), 'style' => 'margin-right:5px'));?>
      <?=\CHtml::submitButton(\Yii::t('app', 'Искать'), array('class' => 'btn'));?>
    <?=\CHtml::endForm();?>
  </div>
  <div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Код</th>
          <th>Лого</th>
          <th>Название</th>
          <th>Даты проведения</th>
          <th style="width: 26px;"></th>
        </tr>
      </thead>
      <tbody>
        <?foreach ($events as $event):?>
        <tr>
          <td><strong><?=$event->Id;?></strong></td>
          <td><?=$event->IdName;?></td>
          <td><?=\CHtml::image($event->getLogo()->getMini());?></td>
          <td><a href="<?=$this->createUrl('/event/admin/edit/index', array('eventId' => $event->Id));?>"><?=$event->Title;?></a></td>
          <td><?=$event->getFormattedStartDate();?> &ndash; <?=$event->getFormattedEndDate();?></td>
          <td>
            <div class="btn-group">
              <a href="<?=$this->createUrl('/event/admin/edit/index', array('eventId' => $event->Id));?>" class="btn"><i class="icon-edit"></i> <?=\Yii::t('app', 'Редактировать');?></a>
            </div>
          </td>
        </tr>
        <?endforeach;?>
      </tbody>
    </table>
  </div>
  <?$this->widget('application\widgets\Paginator', array(
    'paginator' => $paginator
  ));?>
</div>