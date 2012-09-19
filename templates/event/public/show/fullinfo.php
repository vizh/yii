<div class="event-content">
  <?if (! empty($this->Logo)):?>
  <img src="<?=$this->Logo;?>" class="event-logo">
  <?endif;?>
  <p class="m100"></p>
  <h2>ИНФОРМАЦИЯ</h2>
  <p class="event-location">
    <strong>Место проведения:</strong>
    <?php if ($this->IsSetAddress): ?>
    г. <?=$this->City?>
    <?php if ($this->Street) : ?>
      , <?=$this->Street?>
      <?php if (! empty($this->House[0])):?>
        <?=$this->words['address']['house'][0]?> <?=$this->House[0]?>
        <?php endif; ?>
      <?php if (! empty($this->House[1])):?>
        <?=$this->words['address']['house'][1]?> <?=$this->House[1]?>
        <?php endif; ?>
      <?php if (! empty($this->House[2])):?>
        <?=$this->words['address']['house'][2]?> <?=$this->House[2]?>
        <?php endif; ?>
      <? endif; ?><br />
    <?php endif; ?>
    <?=$this->Place?> <br />
    <?=$this->Phones?>
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


  <?if (!empty($this->UrlRegistration)):?>
  <div style="text-align: center;" class="response">
    <a style="width: 300px; display: inline-block;" href="<?=$this->UrlRegistration;?>">Зарегистрироваться</a>
  </div>
  <?endif;?>

  <!-- end event-content -->
</div>