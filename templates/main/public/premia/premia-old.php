<?
/** @var $test JobTest */
$test = $this->Test;
/** @var $questionsId int[] */
$questionsId = $this->QuestionsId;
$questions = $test->Questions;
?>

<div class="content">

  <form id="add_vote" action="" method="post">
    <div class="vacancies add-vacancy comission-vote">

      <h2>Викторина «Премия Рунета 2011»</h2>

      <p>
        Уважаемые участники! Обращаем Ваше внимание, что принять участие в викторине можно только один раз, повторное прохождение не допускается.
      </p>

      <p>
        Все вопросы оцениваются  одинаково, каждый правильный ответ приносит 1 балл.
      </p>

      <?foreach ($questions as $question):?>
      <?if (in_array($question->QuestionId, $questionsId)):?>
        <div class="cfldset">

          <label><strong><?=$question->Question;?></strong></label>

          <p class="chbxs">
            <?foreach ($question->Answers as $answer):?>
            <label><input type="radio" name="answers[<?=$question->QuestionId;?>]" value="<?=$answer->AnswerId;?>" <?=(isset($this->Answers[$question->QuestionId]) && $this->Answers[$question->QuestionId] == $answer->AnswerId) ? 'checked="checked"' : '';?> ><?=$answer->Answer;?></label><br>
            <?endforeach;?>
          </p>

          <!-- end cfldset -->
        </div>
        <?endif;?>
      <?endforeach;?>


      <div class="response">
        <a href="" onclick="$('#add_vote')[0].submit(); return false;">Отправить</a>
      </div>

    </div>

    <div id="sidebar" class="sidebar sidebarcomp">
      <?php echo $this->Banner;?>
    </div>
  </form>

</div>
 
