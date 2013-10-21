<?php
namespace competence\models\form;


class Input extends Base
{
  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Введите в строке ответ на вопрос'],
    ];
  }

  protected function getDefinedViewPath()
  {
    return 'competence.views.form.input';
  }
}