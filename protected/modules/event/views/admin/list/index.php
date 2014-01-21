<?/**
 * @var \event\models\Event[] $events
 */
?>


<div class="row-fluid">
  <div class="btn-toolbar clearfix">
    <?=\CHtml::form($this->createUrl('/event/admin/list/index'), 'GET', array('class' => 'form-inline pull-left'));?>
      <?=\CHtml::textField('Query', \Yii::app()->request->getParam('Query', ''), array('placeholder' => \Yii::t('app', 'ID или навзание мероприятия'), 'style' => 'margin-right:5px'));?>
      <?=\CHtml::submitButton(\Yii::t('app', 'Искать'), array('class' => 'btn'));?>
    <?=\CHtml::endForm();?>

    <a href="<?=$this->createUrl('/event/admin/edit/index');?>" class="btn btn-success pull-right"><?=\Yii::t('app', 'Добавить мероприятие');?></a>
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
          <?/** @var \event\models\Event $event; */?>
          <tr>
            <td><strong><?=$event->Id;?></strong></td>
            <td><?=$event->IdName;?></td>
            <td><?=\CHtml::image($event->getLogo()->getMini());?></td>
            <td><a href="<?=$this->createUrl('/event/admin/edit/index', array('eventId' => $event->Id));?>"><?=$event->Title;?></a></td>
            <td><?$this->widget('event\widgets\Date', array('event' => $event));?></td>
            <td>
              <div class="btn-group">
                <?if ($event->getCanBeRemoved()):?>
                  <a href="<?=$this->createUrl('/event/admin/list/index', ['EventId' => $event->Id, 'Action' => 'Delete', 'BackUrl' => \Yii::app()->getRequest()->getRequestUri()]);?>" class="btn btn-danger"><i class="icon-remove icon-white"></i></a>
                <?endif;?>
                <a href="<?=$this->createUrl('/event/admin/edit/index', ['eventId' => $event->Id]);?>" class="btn"><i class="icon-edit"></i> <?=\Yii::t('app', 'Редактировать');?></a>
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