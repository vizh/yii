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
    <span class="question-info">Введите ответ</span>

    <?if ($this->Error != false):?>
    <br><span class="question-error">Ответ на этот вопрос введен некорректно или является обязательным.</span>
    <?endif;?>
  </div>

  <ul>
    <? foreach ($question->Answers as $answer):?>
    <li>
      <textarea style="width: 95%;" name="Questions[<?=$question->QuestionId;?>][<?=$answer->AnswerId?>]"><?=isset($this->Values[$answer->AnswerId]) ? CHtml::encode($this->Values[$answer->AnswerId]) : '';?></textarea>
    </li>
    <?endforeach;?>
  </ul>

  <?if (!empty($question->Description)):?>
  <div class="help">
    <span><?=$question->Description;?></span>
  </div>
  <?endif;?>
</div>