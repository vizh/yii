<?php
/**
 * @var $this \event\widgets\About
 */
?>

<div id="<?=$this->getNameId();?>" class="tab">
  <header>
    <h4><?=$this->event->Info;?></h4>
  </header>
  <article>
    <?=$this->event->FullInfo;?>
  </article>
</div>
