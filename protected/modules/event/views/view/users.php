<?php
/**
 * @var $event \event\models\Event
 * @var $this ViewController
 * @var $users \user\models\User
 * @var $paginator \application\components\utility\Paginator
 */
?>
<?foreach ($event->Widgets as $widget):?>
  <?if ($widget->getPosition() == \event\components\WidgetPosition::Header):?>
    <?$widget->run();?>
  <?endif;?>
<?endforeach;?>

<div class="event-page">
  <div class="container">
    <div class="row">
      <aside class="sidebar span3 pull-left">
        <div class="contacts">
          <a href="<?=Yii::app()->createUrl('/event/view/index', array('idName' => $event->IdName));?>">На страницу мероприятия</a>
        </div>

        <?foreach ($event->Widgets as $widget):?>
          <?if ($widget->getPosition() == \event\components\WidgetPosition::Sidebar):?>
            <?$widget->run();?>
          <?endif;?>
        <?endforeach;?>
      </aside>

      <div class="span8 pull-right">
        <div class="m-bottom_30">
        <form method="get" action="<?=Yii::app()->createUrl('/event/view/users', array('idName' => $event->IdName));?>" class="form-inline form-filter">
          <input type="text" id="Filter_Query" name="term" placeholder="Поиск" class="span7">
          <input width="20" type="image" height="19" value="submit" name="" src="/images/search-type-image-light.png" class="form-element_image">
        </form>
        </div>


        <div class="row participants units"><?
          foreach ($users as $user):
          ?><div class="span2 participant unit">
          <a href="<?=Yii::app()->createUrl('/user/view/index', array('runetId' => $user->RunetId));?>">
            <img src="<?=$user->getPhoto()->get58px();?>" alt="" width="58" height="58" class="photo">
            <div class="name"><?=$user->getName();?></div>
          </a>
          <?if ($user->getEmploymentPrimary() != null):?>
            <div class="company">
              <small class="muted"><?=$user->getEmploymentPrimary()->Company->Name;?></small>
            </div>
          <?endif;?>
          </div><?
          endforeach;
          ?></div>

        <?$this->widget('\application\widgets\Paginator', array('paginator' => $paginator));?>
      </div>
    </div>
  </div>
</div>