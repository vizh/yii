<div id="news">
  <?if ($this->ShowHeader):?>
  <!--<div id="news-header">
    <div class="title">Новости Интернета
      <a href="#"><img src="images/rss-icon.gif" class="rss-icon" alt="" /></a>
    </div>
    <div class="news-links"><a class="all" href="#">все</a> <a href="#">календарь</a></div>
  </div>-->
  <?endif;?>
  <div id="news-gallery">
    <ul id="carousel-big" class="slides">
      <?php echo $this->PromoList;?>
    </ul>
  </div>
</div>