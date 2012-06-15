<div class="content">
  <div id="video">
    <div class="left">
      <a class="video-link" href="/video/<?=$this->Url;?>/"><img alt="<?=$this->VideoTitle;?>" src="<?=$this->Image;?>"></a>
      <h3><a class="video-link" href="/video/<?=$this->Url;?>/"><?=$this->VideoTitle;?></a></h3>
      <p><?=$this->Description;?></p>
    </div>
    <div class="right">
      <ul class="video-links">
        <?php echo $this->TopVideo;?>
      </ul>
    </div>
  </div>
  <div class="clear mbot60"></div>
  <div class="last_video">
    <h2>Все видео</h2>
    <ul class="video-links">
      <?php echo $this->BottomVideo;?>
    </ul>
    <?php echo $this->Banner;?>
  </div>
  <div class="clear mbot30"></div>
</div>


<!-- video container -->
<div id="video-player">
  <div id="ytapiplayer">
    You need Flash player 8+ and JavaScript enabled to view this video.
  </div>
</div>