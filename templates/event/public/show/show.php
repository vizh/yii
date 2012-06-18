<?php echo $this->FbRoot;?>

<h1 class="event"><span>МЕРОПРИЯТИЯ</span> / <?=$this->Name?></h1>

<div id="large-left">

  <?=$this->Date?>



  <?=$this->FullInfo?>

  <div class="b-share">
    <div class="b-share-tweet">
      <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a>
      <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    </div>
    <div class="b-share-facebook">
      <fb:like href="" layout="button_count" show_faces="false" width="100" font=""></fb:like>
    </div>
  </div>

  <div class="clear"></div>

  <?php echo $this->Comments; ?>

  <div class="clear"></div>

  <!-- end large-left -->
</div>
<div class="sidebar sidebarrapple">

  <?if (empty($this->EventUser) && !empty($this->FastRegistrationRole)):?>
  <a href="<?=RouteRegistry::GetUrl('event', '', 'register', array('idName' => $this->IdName));?>">
    <img src="/images/become-member.gif" width="242" height="45" alt="" />
  </a>
  <?elseif (empty($this->EventUser) && !empty($this->UrlRegistration)):?>
  <a target="_blank" href="<?=$this->UrlRegistration;?>">
    <img src="/images/become-member.gif" width="242" height="45" alt="" />
  </a>
  <?endif;?>


  <?php echo $this->ShareButtons;?>


  <?php echo $this->Users;?>
  <?if (false && $_SERVER['REMOTE_ADDR'] == '82.142.129.35'):?>
  <?php echo $this->Map;?>
  <?endif;?>

  <?php //echo $this->ShortInfo;?>

  <!--<h2>Материалы</h2>

  <div class="rapple-adv">
    <div class="h"></div>
    <div class="c">
      <img src="/images/uuuuuu.gif" width="202" height="133" alt="" />

      <div class="d"><span>21</span> июля</div>

      <h4>Опубликован отчет о проедшем фестивале REDAPPLE2008</h4>

      <p>16 декабря в рамках Третьей
        конференции i-СМИ пройдет финал конкурса «Слово года»</p>


    </div>
    <div class="b"></div>
  </div>


  <div class="rapple-adv">
    <div class="h"></div>
    <div class="c">
      <img src="/images/uuuuuu.gif" width="202" height="133" alt="" />

      <div class="d"><span>21</span> июля</div>

      <h4>Опубликован отчет о проедшем фестивале REDAPPLE2008</h4>

      <p>16 декабря в рамках Третьей
        конференции i-СМИ пройдет финал конкурса «Слово года»</p>


    </div>
    <div class="b"></div>
  </div>-->


  <!--<div class="rapple-news">
    <div class="d"><span>21</span> июля</div>
    <p><a href="">Доклад директора rocID на фестивале REDAPPLE2008</a></p>


  </div>
  <div class="rapple-news">
    <div class="d"><span>21</span> июля</div>
    <p><a href="">Доклад директора rocID на фестивале REDAPPLE2008</a></p>


  </div>
  <div class="rapple-news">
    <div class="d"><span>21</span> июля</div>
    <p><a href="">Доклад директора rocID на фестивале REDAPPLE2008</a></p>


  </div>-->
  <?php echo $this->Banner;?>

  <!-- end sidebar -->
</div>

<div class="clear"></div>

<!-- modal content -->
<div id='confirm'>
  <div class='header'><span>Внимание</span></div>
  <div class='message'>Некоторые данные <strong>не сохранены</strong>. После перехода на другую страницу они могут быть утеряны.</div>
  <div class='buttons'>
    <div class='no simplemodal-close'>ОК</div>
  </div>
</div>