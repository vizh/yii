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
  <h5 class="title">Профессиональные интересы</h5>
  <nav class="b-tags">
    <?foreach($this->event->LinkProfessionalInterests as $linkInterest):?>
      <span class="tag"><?=$linkInterest->ProfessionalInterest->Title?></span>
    <?endforeach?>
  </nav>
</div>