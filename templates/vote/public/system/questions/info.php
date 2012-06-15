<?php
/**
 * @var $question VoteQuestion
 */
$question = $this->Question;
$dependIdList = $question->GetDependIdList();
?>
<div class="question <?=!empty($dependIdList) ? 'depend' : '';?>" data-id="<?=$question->QuestionId;?>" data-depends="<?=CHtml::encode(json_encode($dependIdList));?>">

  <div class="question-title">
    <h3><?=$question->Question;?><?if($question->Required):?><span>*</span><?endif;?></h3>
  </div>

  <?if (!empty($question->Description)):?>
  <div class="help">
    <span><?=$question->Description;?></span>
  </div>
  <?endif;?>
</div>