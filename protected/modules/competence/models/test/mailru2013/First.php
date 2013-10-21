<?php
namespace competence\models\tests\mailru2013;


class First extends \competence\models\base\Single
{

  /**
   * @return string
   */
  public function getQuestionTitle()
  {
    return "Отметьте, пожалуйста, какое из высказываний лучше всего подходит для описания Вашего рода деятельности.";
  }

  /**
   * @return \competence\models\Question
   */
  public function getNext()
  {
    if ($this->value == 3)
    {
      return null;
    }
    return new S2($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return null;
  }

  public function getValues()
  {
    return [
      1 => "Я работаю в интернет-компании",
      2 => "Я не работаю в интернет-компании, но мои профессиональные интересы связаны с интернет-отраслью (работаю в качестве журналиста, PR-специалиста и т.п.)",
      3 => "Я не работаю в интернет-компании и мои профессиональные интересы не связаны с этой отраслью",
    ];
  }

  public function getS3()
  {
    $fullData = $this->getFullData();
    $s1Data = $fullData[get_class($this)];
    if ($s1Data['value'] == 1)
    {
      return new S3($this->test);
    }
    else
    {
      return new S3_1($this->test);
    }
  }
}