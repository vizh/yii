<?php echo $this->FbRoot;?>

<h1 class="event"><span>МЕРОПРИЯТИЯ</span> / <?=$this->Name?></h1>

<div class="content">
<div id="large-left">

  <?=$this->Date?>



  <?=$this->FullInfo?>


  <?=$this->Form;?>



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
  <ul style="list-style: none outside none;">
    <li style="padding: 10px; text-align: center;"><a href="http://raec.ru/"><img src="/files/events/startupmixer2012/raec.png" alt=""></a></li>
    <li style="padding: 10px; text-align: center;"><a href="http://digitaloctober.ru/"><img src="/files/events/startupmixer2012/digital-october.png" alt=""></a></li>
    <li style="padding: 10px; text-align: center;"><a href="http://therunet.com/"><img src="/files/events/startupmixer2012/therunet.png" alt=""></a></li>
    <li style="padding: 10px; text-align: center;"><a href="http://geeksonaplane.com/"><img src="/files/events/startupmixer2012/goap-europe.png" alt=""></a></li>
    <li style="padding: 10px; text-align: center;"><a href="http://500.co/"><img src="/files/events/startupmixer2012/500startups.png" alt=""></a></li>
  </ul>

    <?php echo $this->Users;?>
    <?php echo $this->Map;?>
    <?php echo $this->Banner;?>
  <!-- end sidebar -->
</div>

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