<div class="question" data-id="<?=$this->QuestionId;?>">
  <h5>Вопрос <span></span>.</h5>
  <input name="data[question][<?=$this->QuestionId;?>]" type="text" class="bordered" value="<?=$this->Question;?>" autocomplete="off">
  <a class="button negative q-delete">Удалить</a>
  <ol></ol>
  <a class="button positive answer-add">Добавить вариант ответа</a>
</div>
<hr class="space">