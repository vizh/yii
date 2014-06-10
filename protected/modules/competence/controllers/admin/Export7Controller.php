<?php
class Export7Controller extends \application\components\controllers\PublicMainController
{
  private $test;
  private $questions;

  public function actionIndex()
  {
    $fp = fopen(Yii::getPathOfAlias('competence.data') . '/result7.csv',"w");
    $this->test = \competence\models\Test::model()->findByPk(7);
    $this->questions = $this->getQuestions();

    fputcsv($fp, $this->getRowTitles(), ';');
    $results = \competence\models\Result::model()->byTestId(7)->byFinished(true)->findAll();

    /** @var \competence\models\Result $result */
    foreach ($results as $result)
    {
      $data = $result->getResultByData();
      $row  = [];

      $participant = \event\models\Participant::model()->byUserId($result->UserId)->byEventId(831)->find();
      $row[] = $participant->Role->Title;
      $row[] = $result->User->FirstName;
      $row[] = $result->User->LastName;
      $row[] = $result->User->getEmploymentPrimary() !== null ? $result->User->getEmploymentPrimary()->Company->Name : '';
      $row[] = $result->User->Email;

      /** @var \competence\models\Question $question */
      foreach ($this->questions as $question)
      {
        $name = substr(strrchr(get_class($question->getForm()), "\\"), 1);
        if (isset($data[$name]))
        {
          $qdata = $data[$name];
          if ($name == 'Q10')
          {
            foreach ($question->getForm()->getQuestions() as $key => $value)
            {
              $row[] = $qdata['value'][$key] == 10 ? 'Не знаю' : $qdata['value'][$key];
            }
            $row[] = $qdata['other'];
          }
          elseif ($name == 'Q8' || $name == 'Q9')
          {
            foreach ($question->getForm()->getValues() as $key => $value)
            {
              foreach($question->getForm()->getQuestions() as $qkey => $qvalue)
              {
                $row[] = $qdata['value'][$qkey] == $key ? 1 : '';
              }
            }
          }
          elseif ($name == 'Q2')
          {
            foreach ($question->getForm()->getValues() as $key => $value)
            {
              $row[] = $qdata['value'] == $key ? '1' : '';
              if ($key == 'q2_4')
              {
                $row[] = $qdata['value'] == $key ? $qdata['other'] : '';
              }
            }
            $row[] = !empty($qdata['platform']) ? $question->getForm()->getPlatforms()[$qdata['platform']]->title : '';
            $row[] = !empty($qdata['platform']) && $qdata['platform'] == 'platform_3' ? $qdata['other'] : '';
            $row[] = $qdata['azure'];
          }
          elseif ($name == 'Q19')
          {
            $row[] = $qdata['value'];
          }
          else
          {
            foreach($question->getForm()->Values as $value)
            {
              $checked = in_array($value->key, is_array($qdata['value']) ? $qdata['value'] : [$qdata['value']]);
              $row[] = $checked ? '1' : '';
              if (($name == 'Q11' && ($value->key == 2 || $value->key == 3)) ||
                ($name == 'Q13' && $value->key == 2) ||
                ($name == 'Q14' && ($value->key == 1 || $value->key == 2)) ||
                ($name == 'Q15' && $value->key == 5) ||
                ($name == 'Q16' && $value->key == 2) ||
                ($name == 'Q17' && $value->key == 2) ||
                ($name == 'Q13' && $value->key == 2) ||
                ($name == 'Q18' && ($value->key == 4 || $value->key == 5)))
              {
                $row[] = $checked ? $qdata['other'] : '';
              }
            }

          }
        }
      }
      fputcsv($fp, $row, ';');
    }
    fclose($fp);
    echo 'Done';
  }

  private function getQuestions()
  {
    $questions = [];
    $question = $this->test->getFirstQuestion();
    while(true)
    {
      $questions[] = $question;
      /** @var \competence\models\Question $question */
      $question = $question->getForm()->getNext();
      if ($question == null)
        break;
      $question->setTest($this->test);
    }
    return $questions;
  }

  private function getRowTitles()
  {
    $result = [];
    $result[] = 'Тип бейджей';
    $result[] = 'Имя';
    $result[] = 'Фамилия';
    $result[] = 'Компания';
    $result[] = 'E-mail';

    /** @var \competence\models\Question $question */
    foreach ($this->questions as $question)
    {
      if (get_class($question->getForm()) == 'competence\models\test\devcon14\Q10')
      {
        foreach ($question->getForm()->getQuestions() as $value)
        {
          $result[] = $question->Title.': '.$value;
        }
        $result[] = $question->Title.': Комментарии и пожелания по организационным вопросам конференции';
      }
      elseif (get_class($question->getForm()) == 'competence\models\test\devcon14\Q8' || get_class($question->getForm()) == 'competence\models\test\devcon14\Q9')
      {
        foreach ($question->getForm()->getValues() as $value)
        {
          foreach($question->getForm()->getQuestions() as $q)
          {
            $result[] = $question->Title.': '.$value.': '.$q;
          }
        }
      }
      elseif (get_class($question->getForm()) == 'competence\models\test\devcon14\Q19')
      {
        $result[] = $question->Title;
      }
      elseif (get_class($question->getForm()) == 'competence\models\test\devcon14\Q2')
      {
        foreach ($question->getForm()->getValues() as $key => $value)
        {
          $result[] = $question->Title.': '.$value->title;
          if ($key == 'q2_4')
          {
            $result[] = $question->Title.': '.$value->title;
          }
        }
        $result[] = $question->Title.': Платформа';
        $result[] = $question->Title.': Платформа';
        $result[] = $question->Title.': '.'Ваш Microsoft Azure Subscription ID';
      }
      else
      {
        foreach($question->getForm()->Values as $value)
        {
          if (isset($value->title))
          {
            $result[] = $question->Title.': '.$value->title;


            if ((get_class($question->getForm()) == 'competence\models\test\devcon14\Q11'  && ($value->key == 2 || $value->key == 3)) ||
              (get_class($question->getForm()) == 'competence\models\test\devcon14\Q13'  && $value->key == 2) ||
              (get_class($question->getForm()) == 'competence\models\test\devcon14\Q14'  && ($value->key == 1 || $value->key == 2)) ||
              (get_class($question->getForm()) == 'competence\models\test\devcon14\Q15'  && $value->key == 5) ||
              (get_class($question->getForm()) == 'competence\models\test\devcon14\Q16'  && $value->key == 2) ||
              (get_class($question->getForm()) == 'competence\models\test\devcon14\Q17'  && $value->key == 2) ||
              (get_class($question->getForm()) == 'competence\models\test\devcon14\Q13'  && $value->key == 2) ||
              (get_class($question->getForm()) == 'competence\models\test\devcon14\Q18'  && ($value->key == 4 || $value->key == 5)))
            {
                $result[] = $question->Title.': '.$value->title;
            }
          }
        }
      }
    }
    return $result;
  }
} 