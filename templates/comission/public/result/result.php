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

      <h2>Результаты голосования: <?=$vote->Title;?></h2>

      <?=$vote->Description;?>


      <?foreach ($questions as $question):?>
      <div class="cfldset">

        <label><strong><?=$question->Question;?></strong></label>

        <p class="chbxs">
        <table class="vote-results">
        <? $flag = true;
        foreach ($question->Answers as $answer):?>
          <tr>
            <td width="250"><?=$answer->Answer;?></td>
            <td width="50"><strong><?=sizeof($answer->Results);?></strong></td>
            <td>
              <?if ($question->QuestionId != 15):?>
              <?$i=0;
                foreach ($answer->Results as $result):
                $i++;?>
                <a target="_blank" href="/<?=$result->User->RocId;?>/"><?=$result->User->FirstName;?>&nbsp;<?=$result->User->LastName;?></a><?=$i!=sizeof($answer->Results)? ', ': '';?>
              <?endforeach;?>
              <?else:?>
                <?=$flag ? '(скрыто ^_^)' : '';?>
              <?endif;?>
            </td>
          </tr>
    <?$flag = false; endforeach;?>
        </table>

          <label></label><br>

        </p>

        <!-- end cfldset -->
      </div>
      <?endforeach;?>

    </div>

    <div id="sidebar" class="sidebar sidebarcomp">
      <?php echo $this->Banner;?>
    </div>
  </form>

</div>
 
