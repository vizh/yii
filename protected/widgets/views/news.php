<div class="b-news">
  <div class="container">
    <h2 class="b-header_large light">
      <div class="line"></div>
      <div class="container">
        <span class="backing logo">
          <a href="http://therunet.com/" target="_blank">
            <img src="/images/logo-the-runet.png" width="74" height="11" alt="">
          </a>
        </span>
        <div class="title">
          <span class="backing runet">Runet</span>
          <span class="backing text"><?=\Yii::t('app','Новости');?></span>
        </div>
        <span class="backing url">
          <a href="http://therunet.com/" target="_blank">www.therunet.com</a>
        </span>
      </div>
    </h2>
    <?foreach ($news as $newsItem):?>
    <div class="row clearfix">
      <div class="offset1 span10 news">
        <a href="<?=$newsItem->Url;?>" target="_blank">
          <img src="<?=$newsItem->getPhoto()->get140px();?>" alt="<?=$newsItem->Title;?>" class="pull-left">
        </a>
        <div class="details">
          <header>
            <h4 class="title">
              <a href="<?=$newsItem->Url;?>" target="_blank"><?=$newsItem->Title;?></a>
            </h4>
            <span class="datetime">
              <span class="date">
                <?=\Yii::app()->dateFormatter->format('dd MMMM yyyy', $newsItem->Date);?>
              </span>
            </span>
          </header>
          <article>
            <p><?=$newsItem->PreviewText;?></p>
          </article>
        </div>
      </div>
    </div>
    <?endforeach;?>
  </div>
</div>
