<?
/**
 * @var $vote ComissionVote
 */
$vote = $this->Vote;
?>
<section class="main edit testedit">
  <h2>Редактировать тест</h2>

  <form id="form_editvote" enctype="multipart/form-data" action="" method="post" class="form-stackeds">
    <input type="hidden" value="<?=$vote->VoteId;?>" name="vote_id">

    <aside class="col-l">
      <input type="text" data-empty="<?=$this->words['news']['entertitle'];?>"
             class="title bordered" maxlength="250" name="data[title]"
             value="<?=htmlspecialchars($vote->Title);?>" autocomplete="off">
      <div class="aftertitle">
      </div>

      <div class="main-block bordered text">
        <h4>Описание теста</h4>
        <div class="textarea-container">
          <textarea name="data[description]" class="applyTinyMce"><?=$vote->Description;?></textarea>
        </div>
      </div>

      <div class="main-block bordered">
        <h4>Список вопросов</h4>
        <div class="general-container">

          <? $i = 1;
          foreach ($vote->Questions as $question): ?>
            <div class="question" data-id="<?=$question->QuestionId;?>">
              <h5>Вопрос <span class="q-number"><?=$i;?></span>.</h5>
              <input name="data[question][<?=$question->QuestionId;?>]" type="text" class="bordered" value="<?=$question->Question;?>" autocomplete="off">
              <a class="button negative q-delete">Удалить</a>
              <ol>
                <?foreach ($question->Answers as $answer): ?>
                <li data-id="<?=$answer->AnswerId;?>">
                  <input name="data[answer][<?=$answer->AnswerId;?>]" type="text" class="bordered" value="<?=$answer->Answer;?>" autocomplete="off">
                  <a class="button negative answer-delete"><span class="icon trash"></span></a>
                </li>
                <?endforeach;?>
              </ol>
              <a class="button positive answer-add">Добавить вариант ответа</a>
            </div>
            <hr class="space">
          <? $i++;
          endforeach;?>

          <div id="base_question" class="question">
            <h5>Вопрос <span><?=$i;?></span>.</h5>
            <input type="text" class="bordered" value="" autocomplete="off">
            <a class="button positive">Добавить</a>
          </div>
        </div>
      </div>
    </aside>

    <aside class="col-r">
      <div class="pub bordered sidebar">
        <h4>Опубликовать</h4>
        <a id="button_save" class="button positive save big"><span class="icon check"></span>Сохранить</a>
        <div class="cl"></div>
        <div class="pub-status sub-element">
          <h5>Статус</h5>
          <select name="data[status]" class="bordered">
            <?foreach(ComissionVote::$Statuses as $key):?>
            <option value="<?=$key?>" <?=$key == $vote->Status ? 'selected="selected"' : '';?> ><?=$this->words['status'][$key]?></option>
            <?endforeach;?>
          </select>
        </div>
        <div class="cl"></div>
      </div>

      <div class="sidebar bordered selectcompany">
        <h4>Настройки опроса</h4>
        <div class="sub-element">
          <h5>Опрос для</h5>
          <select name="data[comission]">
            <option value="-1">не определена</option>
            <?foreach($this->Comissions as $comission):?>
              <option value="<?=$comission->ComissionId;?>" <?=$vote->ComissionId == $comission->ComissionId ? 'selected="selected"' : '';?>><?=$comission->Title;?></option>
            <?endforeach;?>
          </select>

          <h5>Закрыть опрос после этой даты</h5>
          <div class="numbered">
            не реализовано х_Х
          </div>
        </div>
      </div>


    </aside>
  </form>
</section>
 
