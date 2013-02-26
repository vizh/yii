<?php
/**
 * @var $this \event\widgets\ProfessionalInterests
 */

if (empty($this->event->LinkProfessionalInterests))
{
  return;
}
?>
<div class="tags">
  <h5 class="title">Теги мероприятия</h5>
  <nav class="b-tags">
    <?foreach ($this->event->LinkProfessionalInterests as $linkInterest):?>
      <a href="#" class="tag"><?=$linkInterest->ProfessionalInterest->Title;?></a>
    <?endforeach;?>
  </nav>
</div>