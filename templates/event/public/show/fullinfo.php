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
  <p class="event-site">
    <!-- <a href="">Программа фестиваля</a> <br> -->
    <noindex><a rel="nofollow" href="<?=$this->Site?>" target="_blank" style="color: #000;">
    Посетить сайт</a></noindex>
  </p>

  <p class="event-tann"><strong><?=$this->Info?></strong></p>

  <?php echo $this->FullInfo;?>

  <!-- end event-content -->
</div>