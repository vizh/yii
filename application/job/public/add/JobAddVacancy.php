<?php
AutoLoader::Import('job.source.*');
AutoLoader::Import('job.source.submenu.*');
AutoLoader::Import('library.mail.*');

class JobAddVacancy extends JobGeneralCommand
{
  private static $emails = array('milena@pruffi.ru', 'ariadna@pruffi.ru');

  /**
   * Основные действия комманды
   * @param string $success
   * @return void
   */
  protected function doExecute($success = '')
  {
    $this->view->Submenu = new JobSubmenu(null);
    
    if (empty($this->LoginUser))
    {
      $this->view->SetTemplate('not-auth');
      echo $this->view;
      return;
    }

    if ($success == 'success')
    {
      $this->view->SetTemplate('success');
      echo $this->view;
      return;
    }

    $data = array('title' => '', 'company' => '', 'email' => '' ,'salary_min' => '',
                  'salary_max' => '', 'responsibility' => '', 'requirements' => '');
    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      $data = Registry::GetRequestVar('data');

      $purifier = new CHtmlPurifier();
      $purifier->options = array('HTML.AllowedElements' => '', 'HTML.AllowedAttributes' => '');

      $data['title'] = trim($purifier->purify($data['title']));
      $data['company'] = trim($purifier->purify($data['company']));
      $data['email'] = trim($purifier->purify($data['email']));
      $data['salary_min'] = intval($data['salary_min']);
      $data['salary_max'] = intval($data['salary_max']);
      $purifier->options = array('HTML.AllowedElements' => array('p'), 'HTML.AllowedAttributes' => '',
                               'AutoFormat.AutoParagraph' => true);
      $data['responsibility'] = trim($purifier->purify($data['responsibility']));
      $data['requirements'] = trim($purifier->purify($data['requirements']));

      $validator = new CEmailValidator();
      if (empty($data['title']))
      {
        $this->AddErrorNotice('Не задан заголовок вакансии', 'Ошибка отправки вакансии');
      }
      elseif (empty($data['company']))
      {
        $this->AddErrorNotice('Не задана компания для которой размещается вакансия', 'Ошибка отправки вакансии');
      }
      elseif (empty($data['email']) || !$validator->validateValue($data['email']))
      {
        $this->AddErrorNotice('Не задан контактный email или задан некорретно.', 'Ошибка отправки вакансии');
      }
      elseif (empty($data['responsibility']) || empty($data['requirements']))
      {
        $this->AddErrorNotice('Не заданы обязанности или требования к кандидату.', 'Ошибка отправки вакансии');
      }
      else
      {
        $this->sendEmail($data);
        Lib::Redirect(RouteRegistry::GetUrl('job', 'add', 'vacancy', array('success' => 'success')));
      }
    }

    $this->view->Data = $data;
    echo $this->view;
  }

  private function sendEmail($data)
  {
    $view = new View();
    $view->SetTemplate('email', 'job', 'vacancy', 'add', 'public');



    $view->Title = $data['title'];
    $view->Company = $data['company'];
    $view->Email = $data['email'];
    $view->SalaryMin = $data['salary_min'];
    $view->SalaryMax = $data['salary_max'];
    $view->Responsibility = $data['responsibility'];
    $view->Requirements = $data['requirements'];

    $view->RocId = $this->LoginUser->RocId;
    $view->LastName = $this->LoginUser->LastName;
    $view->FirstName = $this->LoginUser->FirstName;
    $view->Host = $_SERVER['HTTP_HOST'];

    $mail = new PHPMailer(false);

    foreach (self::$emails as $email)
    {
      $mail->AddAddress($email);
    }
    //$mail->AddAddress('nikitin@internetmediaholding.com');
    //$mail->AddAddress('borzov@raec.ru');
    $mail->AddAddress('cd@internetmediaholding.com');
    $mail->SetFrom('job@rocid.ru', 'rocID', false);
    $mail->CharSet = 'utf-8';
    $subject = Registry::GetWord('mail');
    $subject = (string)$subject['vacancysend'] . $view->Title;
    $mail->Subject = '=?UTF-8?B?'. base64_encode($subject) .'?=';
    $mail->AltBody = 'Для просмотра этого сообщения необходимо использовать клиент, поддерживающий HTML';
    $mail->MsgHTML($view);
    $mail->Send();
  }
}
