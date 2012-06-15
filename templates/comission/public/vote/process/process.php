<?
/** @var $vote ComissionVote */
$vote = $this->Vote;
/** @var $questions ComissionVoteQuestion[] */
$questions = $this->Questions;
?>

<div class="content">

  <form id="add_vote" action="" method="post">
    <div class="vacancies add-vacancy comission-vote">
      <!-- <div class="field_filter">
       <h3>Фильтр вакансий</h3>
     </div> -->

      <h2>Голосование: <?=$vote->Title;?></h2>

      <?=$vote->Description;?>


      <div class="cfldset">
        <h3>Список вопросов</h3>
      </div>

      <?foreach ($questions as $question):?>
      <div class="cfldset">

        <label><strong><?=$question->Question;?></strong></label>

        <p class="chbxs">
        <?foreach ($question->Answers as $answer):?>
          <label><input type="radio" name="answers[<?=$question->QuestionId;?>]" value="<?=$answer->AnswerId;?>" <?=(isset($this->Answers[$question->QuestionId]) && $this->Answers[$question->QuestionId] == $answer->AnswerId) ? 'checked="checked"' : '';?> ><?=$answer->Answer;?></label><br>
        <?endforeach;?>
        </p>

        <!-- end cfldset -->
      </div>
      <?endforeach;?>


      <div class="response">
        <a href="" onclick="$('#add_vote')[0].submit(); return false;">Проголосовать</a>
      </div>

    </div>

    <div id="sidebar" class="sidebar sidebarcomp">
      <?php echo $this->Banner;?>
    </div>
  </form>

</div>