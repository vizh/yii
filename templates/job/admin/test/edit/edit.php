<section class="main edit testedit">
  <h2>Редактировать тест</h2>

  <form id="form_edittest" enctype="multipart/form-data" action="" method="post" class="form-stackeds">
    <input type="hidden" value="<?=$this->TestId;?>" name="test_id">

    <aside class="col-l">
      <input type="text" data-empty="<?=$this->words['news']['entertitle'];?>"
             class="title bordered" maxlength="250" name="data[title]"
             value="<?=htmlspecialchars($this->TestTitle);?>" autocomplete="off">
      <div class="aftertitle">
      </div>

      <div class="main-block bordered text">
        <h4>Описание теста</h4>
        <div class="textarea-container">
          <textarea name="data[description]" class="applyTinyMce"><?=$this->Description;?></textarea>
        </div>
      </div>

      <div class="main-block bordered">
        <h4>Список вопросов</h4>
        <div class="general-container">

          <? $i = 1;
          foreach ($this->Questions as $question): ?>
            <div class="question" data-id="<?=$question->QuestionId;?>">
              <h5>Вопрос <span class="q-number"><?=$i;?></span>.</h5>
              <input name="data[question][<?=$question->QuestionId;?>]" type="text" class="bordered" value="<?=$question->Question;?>" autocomplete="off">
              <a class="button negative q-delete">Удалить</a>
              <ol>
                <?foreach ($question->Answers as $answer): ?>
                <li data-id="<?=$answer->AnswerId;?>">
                  <input name="data[answer][<?=$answer->AnswerId;?>]" type="text" class="bordered" value="<?=$answer->Answer;?>">
                  За этот ответ <input name="data[answer_result][<?=$answer->AnswerId;?>]" type="text" class="point bordered" value="<?=$answer->Result;?>" maxlength="2"> баллов.
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
            <?foreach(JobTest::$Statuses as $key):?>
            <option value="<?=$key?>" <?=$key == $this->Status ? 'selected="selected"' : '';?> ><?=$this->words['status'][$key]?></option>
            <?endforeach;?>
          </select>
        </div>
        <div class="cl"></div>
      </div>

      <div class="sidebar bordered selectcompany">
        <h4>Настройки теста</h4>
        <div class="sub-element">
          <h5>Время на прохождение теста</h5>
          <div class="numbered">
            <input class="bordered" type="text" name="data[pass_time_hour]" value="<?=!empty($this->PassTimeHour) ? $this->PassTimeHour : '';?>" autocomplete="off" maxlength="3"> ч.
            <input class="bordered" type="text" name="data[pass_time_minute]" value="<?=!empty($this->PassTimeMinute) ? $this->PassTimeMinute : '';?>" autocomplete="off" maxlength="3"> мин.
          </div>
          <h5>Повторное прохождение возможно через</h5>
          <select name="data[retest_time]">
            <?foreach($this->words['RetestTime'] as $key => $value):?>
              <option value="<?=$key;?>" <?=$this->RetestTime == $key ? 'selected="selected"' : '';?>><?=$value;?></option>
            <?endforeach;?>
          </select>
          <h5>Количество вопросов в ротации</h5>
          <div class="numbered">
            <input class="bordered" type="text" name="data[question_number]" value="<?=!empty($this->QuestionNumber) ? $this->QuestionNumber : '';?>" autocomplete="off" maxlength="3"> из <span id="question_max"></span>
          </div>
          <?if ($this->VacancyTest):?>
          <h5>Проходной балл</h5>
          <div class="numbered">
            <input class="bordered" type="text" name="data[pass_result]" value="<?=$this->PassResult;?>" autocomplete="off" maxlength="3"> из <span id="result_max"></span>
          </div>
          <?else:?>
            <?foreach ($this->PassArray as $key => $result):?>
            <h5>Результаты (максимум: <span id="result_max"></span>)</h5>
            <div class="numbered result" data-id="<?=$key;?>">
              от <input name="data[result_start][<?=$key;?>]" class="bordered" type="text" value="<?=$result['start'];?>">
              до <input name="data[result_end][<?=$key;?>]" class="bordered result-end" type="text" value="<?=$result['end'];?>">
              <a class="button negative result-delete">Удалить</a><br>
              Описание:
              <textarea name="data[result_description][<?=$key;?>]" class="bordered"><?=$result['description'];?></textarea>
            </div>
            <?endforeach;?>
            <?if (empty($this->PassArray)):?>
            <h5>Результаты (максимум: <span id="result_max"></span>)</h5>
            <div class="numbered result" data-id="1">
              от <input name="data[result_start][1]" class="bordered" type="text" value="">
              до <input name="data[result_end][1]" class="bordered result-end" type="text" value="">
              <a class="button negative result-delete">Удалить</a><br>
              Описание:
              <textarea name="data[result_description][1]" class="bordered"></textarea>
            </div>
            <?endif;?>
            <a class="button result-add">Добавить результат</a>
          <?endif;?>
        </div>
      </div>


    </aside>
  </form>
</section>
 
