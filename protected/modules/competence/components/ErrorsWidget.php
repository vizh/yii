<?php
namespace competence\components;

class ErrorsWidget extends \CWidget
{

  /** @var \competence\models\Question */
  public $question;

  public function run()
  {
    $this->render('errors');
  }
}
