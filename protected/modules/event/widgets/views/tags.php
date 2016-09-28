<?php
/**
 * @var $this \event\widgets\Tags
 */

if (empty($this->event->LinkTags))
{
  return;
}
?>
<div class="tags">
  <h5 class="title">Теги мероприятия</h5>
  <nav class="b-tags">
    <?foreach($this->event->LinkTags as $linkTag):?>
      <a href="#" class="tag"><?=$linkTag->Tag->Title?></a>
    <?endforeach?>
  </nav>
</div>