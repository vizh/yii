<?php
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.mail.*');
 
class EventAdd extends GeneralCommand
{
  protected function preExecute()
  {
    parent::preExecute();

    $this->view->HeadScript(array('src'=>'/js/libs/jquery-ui-1.8.16.custom.min.js'));
    $this->view->HeadScript(array('src'=>'/js/libs/jquery.ui.datepicker-ru.js'));
    $this->view->HeadLink(array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '/css/blitzer/jquery-ui-1.8.16.custom.css'));
  }

  /**
   * Основные действия комманды
   * @param string $success
   * @return void
   */
  protected function doExecute($success = '')
  {
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

    $data = array('fio' => '' ,'phone' => '', 'email' => '' ,'title' => '', 'place' => '', 'date_start' => '',
                  'date_end' => '', 'one_day' => false, 'site' => '', 'no_site'=>false ,'info' => '',
                  'full_info' => '', 'options' => array());
    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      $data = Registry::GetRequestVar('data');

      $purifier = new CHtmlPurifier();
      $purifier->options = array('HTML.AllowedElements' => '', 'HTML.AllowedAttributes' => '');

      $data['fio'] = trim($purifier->purify($data['fio']));
      $data['phone'] = trim($purifier->purify($data['phone']));
      $data['email'] = trim($purifier->purify($data['email']));
      $data['title'] = trim($purifier->purify($data['title']));
      $data['place'] = trim($purifier->purify($data['place']));
      $data['date_start'] = strtotime($data['date_start']);
      $data['date_end'] = strtotime(isset($data['date_end']) ? $data['date_end'] : '');
      $data['one_day'] = isset($data['one_day']);
      $data['site'] = isset($data['site']) ? trim($purifier->purify($data['site'])) : '';
      $data['no_site'] = isset($data['no_site']);
      $purifier->options = array('HTML.AllowedElements' => array('p'), 'HTML.AllowedAttributes' => '',
                               'AutoFormat.AutoParagraph' => true);
      $data['info'] = trim($purifier->purify($data['info']));
      $data['full_info'] = trim($purifier->purify($data['full_info']));


      if (isset($data['options']))
      {
        $purifier->options = array('HTML.AllowedElements' => '', 'HTML.AllowedAttributes' => '');
        foreach($data['options'] as $key => $value)
        {
          $data['options'][$key] = $purifier->purify($value);
        }
      }
      else
      {
        $data['options'] = array();
      }

      $validator = new CEmailValidator();
      if (empty($data['fio']))
      {
        $this->AddErrorNotice('Ошибка отправки мероприятия','Не задано контактное лицо.');
      }
      elseif (empty($data['phone']))
      {
        $this->AddErrorNotice('Ошибка отправки мероприятия','Не задан контактный телефон.');
      }
      elseif (empty($data['email']) || !$validator->validateValue($data['email']))
      {
        $this->AddErrorNotice('Ошибка отправки мероприятия','Не задан контактный email или задан некорретно.');
      }
      elseif (empty($data['title']))
      {
        $this->AddErrorNotice('Ошибка отправки мероприятия','Не задано название мероприятия');
      }
      elseif (empty($data['place']))
      {
        $this->AddErrorNotice('Ошибка отправки мероприятия','Не задано место проведения мероприятия');
      }
      elseif (empty($data['date_start']) || (!$data['one_day'] && empty($data['date_end'])))
      {
        $this->AddErrorNotice('Ошибка отправки мероприятия','Не указаны даты проведения мероприятия.');
      }
      elseif (empty($data['site']) && !$data['no_site'])
      {
        $this->AddErrorNotice('Ошибка отправки мероприятия','Не задан сайт мероприятия');
      }
      elseif (empty($data['info']) || empty($data['full_info']))
      {
        $this->AddErrorNotice('Ошибка отправки мероприятия', 'Не заданы описания мероприятия.');
      }
      else
      {
        $this->sendEmail($data);
        Lib::Redirect(RouteRegistry::GetUrl('event', '', 'add', array('success' => 'success')));
      }
    }

    $data['date_start'] = $data['date_start'] ? date('d.m.Y', $data['date_start']) : $data['date_start'];
    $data['date_end'] = $data['date_end'] ? date('d.m.Y', $data['date_end']) : $data['date_end'];

    $this->view->Data = $data;
    echo $this->view;
  }

  private function sendEmail($data)
  {
    $view = new View();
    $view->SetTemplate('email');

    $view->Fio = $data['fio'];
    $view->Phone = $data['phone'];
    $view->Email = $data['email'];
    $view->Title = $data['title'];
    $view->Place = $data['place'];
    if (!$data['one_day'])
    {
      $view->DateStart = date('d.m.Y', min($data['date_start'], $data['date_end']));
      $view->DateEnd = date('d.m.Y', max($data['date_start'], $data['date_end']));
    }
    else
    {
      $view->DateStart = date('d.m.Y', $data['date_start']);
      $view->DateEnd = false;
    }
    $view->Site = $data['site'];
    $view->NoSite = $data['no_site'];
    $view->Info = $data['info'];
    $view->FullInfo = $data['full_info'];
    $view->Options = isset($data['options']) ? implode(', ', $data['options']) : 'не заданы';

    $view->RocId = $this->LoginUser->RocId;
    $view->LastName = $this->LoginUser->LastName;
    $view->FirstName = $this->LoginUser->FirstName;
    $view->Host = $_SERVER['HTTP_HOST'];

    $mail = new PHPMailer(false);

    //$mail->AddAddress(self::$email);
    $mail->AddAddress('calendar@internetmediaholding.com');
    $mail->AddAddress('nikitin@internetmediaholding.com');
    $mail->SetFrom('event@rocid.ru', 'rocID', false);
    $mail->CharSet = 'utf-8';
    $subject = Registry::GetWord('mail');
    $subject = (string)$subject['eventsend'] . $view->Title;
    $mail->Subject = '=?UTF-8?B?'. base64_encode($subject) .'?=';
    $mail->AltBody = 'Для просмотра этого сообщения необходимо использовать клиент, поддерживающий HTML';
    $mail->MsgHTML($view);
    $mail->Send();
  }
}
