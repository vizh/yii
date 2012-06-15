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
    <span class="question-info">Выберите один из следующих ответов</span>

    <?if ($this->Error != false):?>
    <br><span class="question-error">Ответ на этот вопрос введен некорректно или является обязательным.</span>
    <?endif;?>
  </div>

  <ul>
    <? foreach ($question->Answers as $answer):?>
    <li>
    <label>
      <input type="radio" value="<?=$answer->AnswerId;?>" <?=$this->Checked == $answer->AnswerId ? 'checked="checked"' : '';?>  name="Questions[<?=$question->QuestionId;?>]">
      <?=$answer->Answer;?>
    </label><?if ($answer->Custom == 1):?><input class="custom-input" name="Custom[<?=$question->QuestionId;?>][<?=$answer->AnswerId;?>]" type="text" value="<?=$this->Custom;?>" autocomplete="off"><?endif;?>
    </li>
    <?endforeach;?>
  </ul>

  <?if (!empty($question->Description)):?>
  <div class="help">
    <span><?=$question->Description;?></span>
  </div>
  <?endif;?>
</div>