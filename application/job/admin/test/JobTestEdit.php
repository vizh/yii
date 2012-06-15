<?php
AutoLoader::Import('job.source.*');
 
class JobTestEdit extends AdminCommand
{
  protected function preExecute()
  {
    parent::preExecute();

    $this->view->HeadScript(array('src'=>'/js/libs/tiny_mce/tiny_mce.js'));
    $this->view->HeadScript(array('src'=>'/js/admin/test.edit.js'));
  }

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($id = '')
  {
    $id = intval($id);
    $jobTest = JobTest::GetById($id, JobTest::LoadFullTest);
    if (empty($jobTest))
    {
      $url = ! empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : RouteRegistry::GetAdminUrl('job', 'test', 'list');
      Lib::Redirect($url);
    }

    $test_id = Registry::GetRequestVar('test_id');
    if (! empty($test_id))
    {
      $data = Registry::GetRequestVar('data');

      $words = Registry::GetWord('news');
      $data['title'] = $data['title'] !== $words['entertitle'] ? $data['title'] : '';
      // Параметры теста
      $jobTest->Title = $data['title'];
      $description = $data['description'];
      $purifier = new CHtmlPurifier();
      $purifier->options = array('HTML.AllowedElements' => array('p', 'ul', 'ol', 'li', 'strong', 'em'),
                                 'HTML.AllowedAttributes' => '');
      $description = $purifier->purify($description);
      $jobTest->Description = $description;
      $jobTest->DescriptionShort = $this->getDescriptionShort($jobTest->Description);
      $jobTest->Status = $data['status'];
      $jobTest->PassTime = intval($data['pass_time_hour'])*60*60 + intval($data['pass_time_minute'])*60;
      $jobTest->RetestTime = $data['retest_time'];
      $jobTest->QuestionNumber = $data['question_number'];
      if (empty($jobTest->VacancyId))
      {
        $jobTest->PassResult = null;
        $result = array();
        foreach ($data['result_start'] as $key => $value)
        {
          $result[] = array('start' => $value, 'end' => $data['result_end'][$key],
                            'description' => $data['result_description'][$key]);
        }
        $result = serialize($result);
        $jobTest->PassArray = base64_encode($result);
      }
      else
      {
        $jobTest->PassResult = intval($data['pass_result']);
        $jobTest->PassArray = null;
      }
      $jobTest->save();
      //Вопросы и ответы
      foreach ($jobTest->Questions as $question)
      {
        if ($question->Question !== $data['question'][$question->QuestionId])
        {
          $question->Question = $data['question'][$question->QuestionId];
          $question->save();
        }

        foreach ($question->Answers as $answer)
        {
          if ($answer->Answer != $data['answer'][$answer->AnswerId] ||
              $answer->Result != $data['answer_result'][$answer->AnswerId])
          {
            $answer->Answer = $data['answer'][$answer->AnswerId];
            $answer->Result = $data['answer_result'][$answer->AnswerId];
            $answer->save();
          }
        }
      }
    }


    $this->view->TestId = $jobTest->TestId;
    $this->view->TestTitle = $jobTest->Title;
    $this->view->Description = $jobTest->Description;
    $this->view->Status = $jobTest->Status;
    $this->view->PassTimeHour = floor($jobTest->PassTime / (60*60));
    $this->view->PassTimeMinute = floor(($jobTest->PassTime % (60*60))/60);
    $this->view->RetestTime = $jobTest->RetestTime;
    $this->view->QuestionNumber = $jobTest->QuestionNumber;
    $this->view->MaxQuestionNumber = $jobTest->QuestionsCount;
    $this->view->VacancyTest = ! empty($jobTest->VacancyId);
    $this->view->PassResult = $jobTest->PassResult;
    $this->view->PassArray = ! empty($jobTest->PassArray) ?
        unserialize(base64_decode($jobTest->PassArray)) : array();
    $this->view->Questions = $jobTest->Questions;

    echo $this->view;
  }

  /**
   * @param string $description
   * @return string
   */
  private function getDescriptionShort($description)
  {
    $descriptionParts = preg_split('/\<[^>]*\>/', trim($description), -1, PREG_SPLIT_NO_EMPTY );
    $parts = array();
    foreach ($descriptionParts as $value)
    {
      $value = trim($value);
      if (!empty($value))
      {
        $parts[] = $value;
      }
    }
    $maxSize = 100;
    $string = '';
    $result = array();
    foreach ($parts as $part)
    {
      if (mb_strlen($string, 'utf-8') < $maxSize)
      {
        $string .= $part;
        $result[] = $part;
      }
      else
      {
        $result[] = trim($part, '.') . '...';
        break;
      }
    }
    $view = new View();
    $view->SetTemplate('description-short', 'job', '', 'edit', 'admin');
    $view->Parts = $result;
    return (string) $view;
  }
}
