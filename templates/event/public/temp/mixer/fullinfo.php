<div class="event-content">
  <?if (! empty($this->Logo)):?>
  <img src="<?=$this->Logo;?>" class="event-logo">
  <?endif;?>
  <p class="m100"></p>
  <h2>ИНФОРМАЦИЯ</h2>
  <p class="event-location">
    
  </p>

  <p class="event-tann"><strong><?=$this->Info?></strong></p>

  <?if (!empty($this->UrlRegistration) || !empty($this->Site)):?>
  <ul class="event-links">
    <?if (!empty($this->UrlRegistration)):?>
    <li><a href="<?=$this->UrlRegistration?>" class="registration">Регистрация</a></li>
    <?endif;?>
    <?if (!empty($this->Site)):?>
    <li><a rel="nofollow" target="_blank" href="<?=$this->Site;?>">Сайт</a></li>
    <?endif;?>
    <!--<li><a href="#">Выставка</a></li>
    <li><a href="#">Проезд</a></li>-->
  </ul>
  <?endif;?>

  <?php echo $this->FullInfo;?>

  <!-- end event-content -->
</div>