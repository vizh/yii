<?
/** @var $categories NewsCategories[] */
$categories = $this->Categories;
?>
<div id="content-nav">
  <ul>
    <?foreach($categories as $category):?>
      <li <?=in_array($category->NewsCategoryId, $this->ActiveId)?'class="active"':'';?>>
        <?if ($category->Special == 0 || $category->GetSpecialIcon() == null):?>
          <a href="/news/category/<?=$category->Name;?>/"><?=$category->Title;?></a>
        <?else:?>
        <a href="/news/category/<?=$category->Name;?>/">
          <div class="special-img">
            <img src="<?=$category->GetSpecialIcon();?>" alt="<?=$category->Title;?>" >
          </div>
        </a> <a href="/news/category/<?=$category->Name;?>/"><?=$category->Title;?></a>
        <?endif;?>
      </li>
    <?endforeach;?>
  </ul>
  <div class="clear"></div>
</div>