<?php
/**
 * @var $question VoteQuestion
 */
$question = $this->Question;
$dependIdList = $question->GetDependIdList();
$values = $this->Values;
asort($values, SORT_NUMERIC);
$keys = array_keys($values);
foreach ($question->Answers as $answer)
{
  if (isset($this->Values[$answer->AnswerId]))
  {
    $values[$answer->AnswerId] = array('answer' => $answer, 'position' => $this->Values[$answer->AnswerId]);
  }
}
?>
<div class="question <?=!empty($dependIdList) ? 'depend' : '';?>" data-id="<?=$question->QuestionId;?>" data-depends="<?=CHtml::encode(json_encode($dependIdList));?>">

  <div class="question-title">
    <h3><?=$question->Question;?><?if($question->Required):?><span>*</span><?endif;?></h3>
    <span class="question-info">Выбирайте элементы в списке слева, начиная с наиболее предпочитаемого и перемещаясь к наименее предпочитаемому.</span>

    <?if ($this->Error != false):?>
    <br><span class="question-error">Ответ на этот вопрос введен некорректно или является обязательным.</span>
    <?endif;?>
  </div>

  <ul class="rank">
    <?foreach ($question->Answers as $answer):?>
    <?if (!in_array($answer->AnswerId, $keys)):?>
      <li data-id="<?=$answer->AnswerId;?>">
        <!-- <input type="hidden" name="Questions[<?=$question->QuestionId;?>][<?=$answer->AnswerId?>]" value="<?=isset($this->Values[$answer->AnswerId]) ? $this->Values[$answer->AnswerId] : '';?>"> -->
        <?=$answer->Answer;?>
      </li>
      <?endif;?>
    <?endforeach;?>
  </ul>

  <ol class="rank">
    <?$i=0;foreach ($values as $key => $value):$i++;?>
    <li data-id="<?=$value['answer']->AnswerId;?>">
      <?if ($i == sizeof($this->Values)):?><span></span><?endif;?>
      <input type="hidden" name="Questions[<?=$question->QuestionId;?>][<?=$value['answer']->AnswerId;?>]" value="<?=$value['position']?>">
      <?=$value['answer']->Answer;?>
    </li>
    <?endforeach;?>
    <?for (;$i < sizeof($question->Answers); $i++):?>
    <li data-id="empty"></li>
    <?endfor;?>
  </ol>

  <div class="clear"></div>

  <?if (!empty($question->Description)):?>
  <div class="help">
    <span><?=$question->Description;?></span>
  </div>
  <?endif;?>

</div>