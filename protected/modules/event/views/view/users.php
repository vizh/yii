<?php
/**
 * @var $event \event\models\Event
 * @var $this ViewController
 * @var $users \user\models\User
 * @var $paginator \application\components\utility\Paginator
 */
?>
<?foreach($event->Widgets as $widget):?>
  <?if($widget->getPosition() == \event\components\WidgetPosition::Header):?>
    <?$widget->run()?>
  <?endif?>
<?endforeach?>

<div class="event-page">
  <div class="container">
    <div class="row">
      <aside class="sidebar span3 pull-left">
        <div class="contacts">
          <a href="<?=Yii::app()->createUrl('/event/view/index', array('idName' => $event->IdName))?>"><?=\Yii::t('app', 'На страницу мероприятия')?></a>
        </div>

        <?foreach($event->Widgets as $widget):?>
          <?if($widget->getPosition() == \event\components\WidgetPosition::Sidebar):?>
            <?
            $widget->getEvent()->FullWidth = false;
            $widget->run();
           ?>
          <?endif?>
        <?endforeach?>
      </aside>

      <div class="span8 pull-right">
        <div class="m-bottom_30">
        <form method="get" action="<?=Yii::app()->createUrl('/event/view/users', array('idName' => $event->IdName))?>" class="form-inline form-filter light">
          <input type="text" id="Filter_Query" name="term" placeholder="<?=\Yii::t('app', 'Поиск среди участников мероприятия')?>" class="span7" value="<?=\Yii::app()->request->getParam('term', '')?>">
          <input width="20" type="image" height="19" value="submit" name="" src="/images/search-type-image-dark.png" class="form-element_image">
        </form>
        </div>
        <?=$users?>
      </div>
    </div>
  </div>
</div>