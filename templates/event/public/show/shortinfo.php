<h2>Информация</h2>

<div class="rapple-info">
<p><strong>Место проведения:</strong>
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
<?=$this->Phones?> </p>
<p class="l"><a href="">Программа фестиваля</a><br />
<noindex><a rel="nofollow" href="<?=$this->Site?>" target="_blank">
    Посетить сайт</a></noindex></p>
</div>