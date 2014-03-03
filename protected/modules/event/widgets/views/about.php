<?php
/**
 * @var $this \event\widgets\About
 */
?>

<div id="<?=$this->getNameId();?>" class="tab" itemprop="description">
  <?if (!$this->event->FullWidth):?>
    <header>
      <h4><?=$this->event->Info;?></h4>
    </header>
    <article>
      <?=$this->event->FullInfo;?>
    </article>
  <?else:?>
    <div class="row">
      <article class="span11 content">
        <header>
          <p><?=$this->event->Info;?></p>
        </header>
        <?=$this->event->FullInfo;?>
      </article>
    </div>
  <?endif;?>
</div>
