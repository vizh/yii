<?php
/** @var $category NewsCategories */
$category = $this->Category;
?>
<div class="news_block category">
  <h2><a href="<?=RouteRegistry::GetUrl('news', '', 'category', array('catName' => $category->Name));?>"><?=$category->Title;?></a><a class="rss" target="_blank" title="Подписаться на RSS <?=CHtml::encode($category->Title);?>" href="<?=$this->RssUrl;?>"></a></h2>
  <hr>
  <ul class="left">
    <?php echo $this->Left;?>
  </ul>
  <ul class="center">
    <?php echo $this->Center;?>
  </ul>
  <?if (!$this->WithAds):?>
  <ul class="right">
    <?php echo $this->Right;?>
  </ul>
  <?else:?>
  <div class="ads">
    <?php echo $this->Banner;?>
  </div>
  <?endif;?>

  <div class="clear"></div>

</div>
<div class="clear mbot30"></div>