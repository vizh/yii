<div id="top_news">
  <div class="left">
    <img src="<?=$this->MainNews->GetMainTapeImageBig();?>" alt="<?=$this->MainNews->Title;?>">
    <h3>
      <a href="/news/<?=$this->MainNews->GetLink();?>/"><?=$this->MainNews->Title;?></a>
      <span><?=date('d.m.Y H:i', strtotime($this->MainNews->PostDate));?></span>
    </h3>
    <p>
      <?=$this->MainNews->Quote;?> <a href="/news/<?=$this->MainNews->GetLink();?>/">Читать дальше</a>.
    </p>
  </div>
  <div class="right">
    <div class="ads">
      <?php echo $this->Banner;?>
    </div>
    <ul>
      <?php
      $i=0;
      foreach($this->CenterNews as $news):?>
      <li <?=$i == (sizeof($this->CenterNews) - 1) ?  'class="last"' : '';?>>
        <?if($i != (sizeof($this->CenterNews) - 1)):?><img src="<?=$news->GetMainTapeImage();?>" alt="<?=$news->Title;?>"><?endif;?>
        <h4><a href="/news/<?=$news->GetLink();?>/"><?=$news->Title;?></a></h4>
        <p><?=$news->Quote;?></p>
      </li>
      <?
      $i++;
      endforeach;?>

      

     <!-- <li>
        <img src="news_files/top_news_s.jpg" alt="">
        <h4><a href="#">Lorem ipsum dolor sit amet</a></h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
      </li>
      <li>
        <img src="news_files/top_news_s.jpg" alt="">
        <h4><a href="#">Lorem ipsum dolor sit amet</a></h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
      </li> -->
    </ul>
  </div>
</div>
<div class="clear mbot30"></div>