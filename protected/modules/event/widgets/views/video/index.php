<?php
/**
 * @var \event\widgets\Video $this
 */
?>
<script type="text/javascript">
  $(function(){
    var videoTabs = $('#video-tabs');
    videoTabs.tabs();
    videoTabs.find('li>a').on('click', function (e) {
      var target = $(e.currentTarget);
      $('#video-tabs').find('iframe').attr('src', target.data('video'));
    });
  });
</script>

<style type="text/css">
  #video-tabs div.video-content{
    width: 640px;
    margin: 0 auto;
  }
</style>

<div id="video-tabs" class="tabs">
  <ul class="nav content-nav">
    <li><a data-video="<?=Yii::app()->createUrl('/event/view/index', ['idName' => $this->event->IdName, 'video' => '0b75ffed81'])?>" href="#congress-hall" class="pseudo-link">Конгресс-центр</a></li>
    <li>/</li>
    <li><a data-video="<?=Yii::app()->createUrl('/event/view/index', ['idName' => $this->event->IdName, 'video' => '74f08d3c86'])?>" href="#small-hall" class="pseudo-link">Малый зал</a></li>
    <li>/</li>
    <li><a data-video="<?=Yii::app()->createUrl('/event/view/index', ['idName' => $this->event->IdName, 'video' => 'c581301c22'])?>" href="#library-hall" class="pseudo-link">Библиотека</a></li>
  </ul>

  <div class="video-content">
    <iframe width="640" height="352" src="<?=Yii::app()->createUrl('/event/view/index', ['idName' => $this->event->IdName, 'video' => '0b75ffed81'])?>" frameborder="0"></iframe>
  </div>


  <div id="congress-hall" class="tab"></div>
  <div id="small-hall" class="tab"></div>
  <div id="library-hall" class="tab"></div>

  <p class="muted" style="width: 640px; margin: 0 auto; font-size: 12px;">ВНИМАНИЕ: для просмотра конференций необходимо использовать последние версии браузеров Mozilla Firefox (только для windows-пользователей) или Google Chrome.<br>
    Двойным нажатием мыши на окно трансляции возможно развернуть его на полный экран.</p>

</div>


