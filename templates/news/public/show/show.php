<?php echo $this->Categories;?>

<?if (! empty($this->BannerInnewsTop)):?>
<div class="banner-innews-top">
<?=$this->BannerInnewsTop;?>
</div>
<?endif;?>

<div id="large-left">
  <div class="web-news-2">
    <?if (isset($this->Image)):?>
    <div class="web-news-2-pic">
      <img src="<?=$this->Image;?>" class="web-news-2-pic" alt="<?=htmlspecialchars($this->TitleNews);?>" />

      <span class="web-news-2-copyright">
        <?if (!empty($this->Copyright)):?>
        &copy;&nbsp;<?=$this->Copyright;?>
        <?else:?>
        &nbsp;
        <?endif;?>
      </span>

    </div>
    <?endif;?>


    <div class="">
      <div class="web-news-2-date">
        <strong>
          <span><?=$this->Date['mday'];?></span> <?=$this->words['calendar']['months'][2][$this->Date['mon']];?>
        </strong>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;<?=$this->words['calendar']['daynames'][$this->Date['wday']];?>
      </div>

      <table>
        <tr><td style="padding: 0;"><h2><?=$this->TitleNews;?></h2></td></tr>
      </table>

      <?=$this->ContentNews;?>

      <?if (isset($this->LinkFromRss)):?>
      <p class="auth">Полная версия:
        <noindex>
          <a rel="nofollow external" target="_blank" href="<?=$this->LinkFromRss?>">
            <?=$this->LinkFromRss?>
          </a>
        </noindex>
      </p>
      <?endif;?>

      <div class="b-share">
        <div class="b-share-tweet">
          <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a>
          <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
        </div>
        <div class="b-share-facebook">
          <script src="http://connect.facebook.net/ru_RU/all.js#xfbml=1"></script>
          <fb:like href="<?=$this->Url;?>" layout="button_count" show_faces="false" width="100" font=""></fb:like>
        </div>
      </div>





      <!--<div class="glamour-cite">
        <p>
          Вещание из Свердловска шло на весь Советский Союз. На стене Юрия Борисовича висели настенные часы, показывающие точное московское время.
        </p>
      </div>-->

    </div>
    <!-- end web-news-2 -->
  </div>

  <div class="clear"></div>

  <?php echo $this->Comments; ?>

  <div class="clear mbot30"></div>

  <div class="love_ad" id="love_h">

    <script type="text/javascript">

      var love_anketa_id = undefined;

      var love_partner_id = 134;

      var love_cnt = 2;

      document.write('<iframe src="http://loveadvert.ru/hview2.html?aid='+love_anketa_id+'&pid='+love_partner_id+'&cnt='+love_cnt+'" width="680" height="102" frameborder="0" scrolling="no"></iframe>');

    </script>

  </div>

  <!-- end large-left -->
</div>
<div class="sidebar sidebarcomp sidebarnews">
  <?php echo $this->PartnerBanner;?>
  <?php echo $this->Banner;?>

  <?php echo $this->LastNews;?>


</div>