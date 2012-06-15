<?php
AutoLoader::Import('job.source.*');
AutoLoader::Import('job.source.submenu.*');
AutoLoader::Import('library.mail.*');
 
class JobRequest extends JobGeneralCommand
{
  /**
   * @var Vacancy
   */
  private $vacancy = null;
  /**
   * @var JobTest
   */
  private $jobTest = null;
  /**
   * @var JobTestResult
   */
  private $testResult = null;

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($id = 0)
  {
    $this->view->Submenu = new JobSubmenu(null);
    if (empty($this->LoginUser))
    {
      $this->view->SetTemplate('not-auth', 'job', 'request', '');
      echo $this->view;
      exit;
    }
    $id = intval($id);
    $this->vacancy = Vacancy::GetById($id);
    if (empty($this->vacancy) || $this->vacancy->Status != Vacancy::StatusPublish)
    {
      Lib::Redirect(RouteRegistry::GetUrl('job', '', 'top'));
    }
    $this->view->Submenu = new JobSubmenu($this->vacancy->Type);

    $this->view->VacancyId = $this->vacancy->VacancyId;
    $this->view->VacancyTitle = $this->vacancy->Title;
    $this->view->SalaryMax = $this->vacancy->SalaryMax;
    $this->view->SalaryMin = $this->vacancy->SalaryMin;

    $this->jobTest = $this->vacancy->JobTest;
    if (! empty($this->jobTest) && $this->jobTest->Status == JobTest::StatusPublish)
    {
      $this->testResult = JobTestResult::GetByUser($this->LoginUser->UserId, $this->jobTest->TestId);
      $this->testResult = ! empty($this->testResult) ? $this->testResult[0] : null;
      if (! empty($this->testResult) && $this->testResult->ResultDescription == JobTestResult::ResultSuccess)
      {
        $this->executeRequest();
      }
      else
      {
        Lib::Redirect(RouteRegistry::GetUrl('job', 'test', 'show', array('id' => $this->jobTest->TestId)));
      }
    }
    $this->executeRequest();
  }

  private function executeRequest()
  {
    $vacancyRequest = VacancyRequest::GetByUser($this->LoginUser->UserId, $this->vacancy->VacancyId);
    $view = new View();
    if (empty($vacancyRequest))
    {
      $view->SetTemplate('request-form');
      if (Yii::app()->getRequest()->getIsPostRequest())
      {
        $email = Registry::GetRequestVar('email');
        $description = Registry::GetRequestVar('description');
        if (! empty($email) && ! empty($description))
        {
          $vacancyRequest = new VacancyRequest();
          $vacancyRequest->VacancyId = $this->vacancy->VacancyId;
          $vacancyRequest->UserId = $this->LoginUser->UserId;
          $purifier = new CHtmlPurifier();
          $purifier->options = array('HTML.AllowedElements' => '', 'HTML.AllowedAttributes' => '');
          $vacancyRequest->Email = $purifier->purify($email);

          $purifier->options = array('HTML.AllowedElements' => array('p', 'ul', 'ol', 'li', 'strong', 'em'),
                                 'HTML.AllowedAttributes' => '', 'AutoFormat.AutoParagraph' => true);
          $vacancyRequest->Description = $purifier->purify($description);
          $vacancyRequest->CreationDate = date('Y-m-d H:i');
          $vacancyRequest->save();
          $this->sendEmail($vacancyRequest);
          Lib::Redirect(RouteRegistry::GetUrl('job', '', 'request', array('id' => $this->vacancy->VacancyId)));
        }
        else
        {
          $view->Email = $email;
          $view->Description = $description;
          $this->AddErrorNotice('Необходимо заполнить все поля!', 'Отправить отзыв не удалось');
        }
      }
    }
    else
    {
      $view->SetTemplate('request-result');
    }
    $this->view->Request = $view;
    echo $this->view;
  }

  /**
   * @param VacancyRequest $vacancyRequest
   * @return void
   */
  private function sendEmail($vacancyRequest)
  {
    $mail = new PHPMailer(false);
    $mail->AddAddress($this->vacancy->Email);
    $mail->AddAddress('cd@internetmediaholding.com');
    $mail->SetFrom($vacancyRequest->Email, $this->LoginUser->LastName . ' ' . $this->LoginUser->FirstName, false);
    $mail->CharSet = 'utf-8';
    $subject = Registry::GetWord('mail');
    $subject = ((string)$subject['jobrequest']) . $this->vacancy->Title;
    $mail->Subject = '=?UTF-8?B?'. base64_encode($subject) .'?=';
    $mail->AltBody = 'Для просмотра этого сообщения необходимо использовать клиент, поддерживающий HTML';
    $view = new View();
    $view->SetTemplate('request-mail');
    $view->Name = $this->LoginUser->LastName . ' ' . $this->LoginUser->FirstName;
    $view->Email = $vacancyRequest->Email;
    $view->Description = $vacancyRequest->Description;
    $view->VacancyId = $this->vacancy->VacancyId;
    $view->Title = $this->vacancy->Title;
    $mail->MsgHTML((string)$view);
    $mail->Send();
  }

}
