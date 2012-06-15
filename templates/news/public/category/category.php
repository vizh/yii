<?php echo $this->Categories;?>

<?if (! empty($this->BannerInnewsTop)):?>
<div class="banner-innews-top">
<?=$this->BannerInnewsTop;?>
</div>
<?endif;?>

<h1 class="event"><?=$this->CategoryTitle;?></h1>

<div class="news_block" >
  <ul class="large">
    <?php echo $this->News;?>
  </ul>
  <div class="ads">
    <?php echo $this->PartnerBanner;?>
    <?php echo $this->Banner;?>
  </div>

  <?php echo $this->Paginator; ?>

</div>