<div class="additional_info">
  <h3>Правила теста</h3>
  <p class="company"><strong>Количество вопросов:</strong> <?=$this->QuestionNumber;?></p>
  <p class="company"><strong>Время на прохождение теста:</strong>
    <?if (! empty($this->PassTimeHour) || ! empty($this->PassTimeMinute)):?>
        <?if (! empty($this->PassTimeHour)):?><?=$this->PassTimeHour;?> ч. <?endif;?><?=$this->PassTimeMinute;?> мин.
    <?else:?>
        неограничено.
    <?endif;?>
  </p>
  <?if (! empty($this->PassResult)):?>
  <p class="company"><strong>Максимальный балл:</strong> <?=$this->MaxResult;?></p>
  <p class="company"><strong>Проходной балл:</strong> <?=$this->PassResult;?></p>
  <?endif;?>
</div>
