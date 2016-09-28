<?php
/**
 * @var \application\widgets\GroupBtnSelect $this
 */
?>
<div class="widget-btn-group" data-model="<?=$inputName?>">
  <div class="btn-group" data-toggle="buttons-checkbox">
    <?foreach($this->values as $k => $v):?>
      <a class="btn <?=in_array($k, $activeValues)  ? 'active' : ''?>" data-value="<?=$k?>"><?=$v?></a>
    <?endforeach?>
  </div>
  <div class="hidden">
    <?foreach($activeValues as $activeValue):?>
      <?=$activeValue !== null ? \CHtml::hiddenField($inputName, $activeValue) : ''?>
    <?endforeach?>
  </div>
</div>