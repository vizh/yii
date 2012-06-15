<?php
AutoLoader::Import('main.source.*');
AutoLoader::Import('job.source.*');

class MainPremia extends GeneralCommand
{
  const TestId = 7;
  private static $secret = 'djhskjghoiweeib';
  const QuestionsCount = 10;

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    echo $this->view;
    return;

    /**
     * Викторина окончена. Весь текст ниже больше не нужен.
     */

    if ($this->checkByIp())
    {
      if (Yii::app()->getRequest()->getIsPostRequest())
      {
        $test = JobTest::GetById(self::TestId, JobTest::LoadFullTest);
        $this->view->Test = $test;
        $email = Registry::GetRequestVar('email');
        $emailValidator = new CEmailValidator();
        if (!empty($email))
        {
          if (!$emailValidator->validateValue($email))
          {
            $this->AddErrorNotice('Указан некорректный адрес электронно почты.');
            $this->view->SetTemplate('prepare');
          }
          elseif (!$this->checkByEmail($email))
          {
            $this->AddErrorNotice('Пользователь с таким адресом электронной почты уже участвовал в голосовании.');
            $this->view->SetTemplate('prepare');
          }
          else
          {
            $keys = array_rand($test->Questions, self::QuestionsCount);
            $questionsId = array();
            foreach ($keys as $key)
            {
              $questionsId[] = $test->Questions[$key]->QuestionId;
            }
            $this->view->QuestionsId = $questionsId;
            $questionsId = base64_encode(serialize($questionsId));
            Cookie::Set(new CHttpCookie('email', $email));
            Cookie::Set(new CHttpCookie('questions', $questionsId));
            Cookie::Set(new CHttpCookie('questions_hash', md5(self::$secret.$questionsId)));
          }
        }
        else
        {
          $email = Cookie::Get('email');
          if (empty($email) || !$emailValidator->validateValue($email))
          {
            $this->view->SetTemplate('prepare');
          }
          else
          {
            $questionsId = Cookie::Get('questions');
            $questions_hash = Cookie::Get('questions_hash');
            if ($questions_hash !== md5(self::$secret.$questionsId))
            {
              Lib::Redirect(RouteRegistry::GetUrl('main', '', 'premia'));
            }
            $questionsId = unserialize(base64_decode($questionsId));
            $this->view->QuestionsId = $questionsId;
            $answers = Registry::GetRequestVar('answers');

            if (sizeof($answers) !== self::QuestionsCount)
            {
              $this->view->Answers = $answers;
              $this->AddErrorNotice('Необходимо ответить на все вопросы викторины.');
            }
            else
            {
              $result = 0;
              foreach ($test->Questions as $question)
              {
                if (isset($answers[$question->QuestionId]) && in_array($question->QuestionId, $questionsId))
                {
                  foreach ($question->Answers as $answer)
                  {
                    if ($answers[$question->QuestionId] == $answer->AnswerId)
                    {
                      $result += $answer->Result;
                    }
                  }
                }
              }
              $tmpResult = new TmpPremiaResult();
              $tmpResult->Ip = $_SERVER['REMOTE_ADDR'];
              $tmpResult->Email = $email;
              $tmpResult->Result = $result;
              $tmpResult->save();
              $this->view->Result = $result;
              $this->view->SetTemplate('thank-you');
            }
          }

        }
      }
      else
      {
        $this->view->SetTemplate('prepare');
      }
    }
    else
    {
      $this->view->SetTemplate('error-ip');
    }
    
    


    echo $this->view;
  }

  /**
   * @return bool
   */
  private function checkByIp()
  {
    $ip = $_SERVER['REMOTE_ADDR'];
    $result = TmpPremiaResult::GetByIp($ip);
    return empty($result);
  }

  /**
   * @param string $email
   * @return bool
   */
  private function checkByEmail($email)
  {
    $result = TmpPremiaResult::GetByEmail($email);
    return empty($result);
  }
}