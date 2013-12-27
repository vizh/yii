<?php
/**
 * @var $this \event\widgets\About
 */
?>

<div id="<?=$this->getNameId();?>" class="tab">
  <div class="row">
    <article class="<?=!$this->event->FullWidth ? 'span8' : 'span11';?> content">
      <header>
        <p><?=$this->event->Info;?></p>
      </header>
      <?=$this->event->FullInfo;?>
    </article>
  </div>
</div>
