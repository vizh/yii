<?php

abstract class BaseQuestionType
{
  /**
   * @var VoteQuestion
   */
  protected $question;

  /**
   * @param VoteQuestion $question
   */
  public function __construct($question)
  {
    $this->question = $question;
  }

  /**
   * @abstract
   * @param mixed $data
   * @param mixed $error
   * @return View
   */
  abstract public function RenderQuestion($data, $error = false);

  /**
   * @abstract
   * @param mixed $data
   * @return bool
   */
  abstract public function Validate($data);

  /**
   * @abstract
   * @param $data
   * @return array
   */
  abstract public function BuildData($data);

  /**
   * @return array
   */
  protected function GetParams()
  {
    if ($this->question->TypeParams != null)
    {
      return unserialize(base64_decode($this->question->TypeParams));
    }
    else
    {
      return array();
    }
  }

  public function SetParams($params)
  {
    if (!empty($params))
    {
      $this->question->TypeParams = base64_encode(serialize($params));
    }
    else
    {
      $this->question->TypeParams = null;
    }
    $this->question->save();
  }

  /**
   * @param VoteAnswer $answer
   * @return string|null
   */
  protected function getCustomValue($answer)
  {
    if ($answer->Custom == 0)
    {
      return null;
    }

    $custom = Registry::GetRequestVar('Custom');
    if (isset($custom[$answer->QuestionId][$answer->AnswerId]))
    {
      return $custom[$answer->QuestionId][$answer->AnswerId];
    }
    else
    {
      return null;
    }
  }

  abstract public function ResultCsv($file, $resultIdList);

  protected function forCsv($text)
  {
    return iconv('utf-8', 'Windows-1251', $text);
  }
}