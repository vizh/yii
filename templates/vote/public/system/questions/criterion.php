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

    <?if ($this->Error != false):?>
    <br><span class="question-error">Ответ на этот вопрос введен некорректно или является обязательным.</span>
    <?endif;?>
  </div>

  <div class="criterion">
    <table>
      <tr>
        <th>&nbsp;</th>
        <?foreach ($this->Criterions as $value):?>
        <th><?=$value;?></th>
        <?endforeach;?>
      </tr>

      <?foreach ($question->Answers as $answer):?>
      <tr class="answer">
        <td class="first"><?=$answer->Answer;?></td>
        <?foreach ($this->Criterions as $key => $value):?>
        <td>
          <select name="Questions[<?=$question->QuestionId;?>][<?=$answer->AnswerId?>][<?=$key?>]">
            <option value="">...</option>
            <?for ($i=$this->MinRate; $i<=$this->MaxRate; $i++):?>
            <option value="<?=$i;?>" <?= isset($this->Values[$answer->AnswerId][$key]) && $i == $this->Values[$answer->AnswerId][$key] ? 'selected="selected"' : '';?>><?=$i;?></option>
            <?endfor;?>
          </select>
        </td>
        <?endforeach;?>
      </tr>
      <?endforeach;?>
    </table>
  </div>

  <?if (!empty($question->Description)):?>
  <div class="help">
    <span><?=$question->Description;?></span>
  </div>
  <?endif;?>
</div>