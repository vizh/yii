<?php
/**
 * @var \event\widgets\Video $this
 */
?>
<script type="text/javascript">
  $(function(){
    $('#video-tabs').tabs();
  });
</script>

<style type="text/css">
  #video-tabs div.tab{
    width: 640px;
    margin: 0 auto;
  }
</style>

<div id="video-tabs" class="tabs">
  <ul class="nav content-nav">
    <li><a href="#small-hall" class="pseudo-link">Малый зал</a></li>
    <li>/</li>
    <li><a href="#library-hall" class="pseudo-link">Библиотека</a></li>
    <li>/</li>
    <li><a href="#congress-hall" class="pseudo-link">Конгресс-центр</a></li>
    <li>/</li>
    <li><a href="#internetconf-hall" class="pseudo-link">Интернет-конференция</a></li>
  </ul>

  <div id="small-hall" class="tab">
    <iframe width="640" height="352" src="<?=Yii::app()->createUrl('/event/view/index', ['idName' => $this->event->IdName, 'video' => 'c67f2eabd8']);?>" frameborder="0"></iframe>
  </div>

  <div id="library-hall" class="tab">
    <iframe width="640" height="352" src="<?=Yii::app()->createUrl('/event/view/index', ['idName' => $this->event->IdName, 'video' => 'c581301c22']);?>" frameborder="0"></iframe>
  </div>

  <div id="congress-hall" class="tab">
    <iframe width="640" height="352" src="<?=Yii::app()->createUrl('/event/view/index', ['idName' => $this->event->IdName, 'video' => 'dcad56b677']);?>" frameborder="0"></iframe>
  </div>

  <div id="internetconf-hall" class="tab">
    <iframe width="640" height="352" src="<?=Yii::app()->createUrl('/event/view/index', ['idName' => $this->event->IdName, 'video' => 'baa229dd42']);?>" frameborder="0"></iframe>
  </div>
</div>
