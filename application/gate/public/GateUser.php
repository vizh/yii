<?php
AutoLoader::Import('gate.source.*');
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

class GateUser extends GateCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {

    ini_set("memory_limit", "256M");
    /**
     * Принимаемые данные
     */
    $field = Registry::GetRequestVar('field');
    $value = Registry::GetRequestVar('value');
    $logic = strtoupper(Registry::GetRequestVar('logic', 'AND'));
    $limit = intval(Registry::GetRequestVar('limit', 0));

    if ($limit < 0) {
      $limit = 0;
    }
    if ($logic != 'AND' && $logic != 'OR') {
      $logic = 'AND';
    }
    //    if (is_array($value)) {
    //      foreach ($value as $k => $str) {
    //        $value[$k] = urldecode($str);
    //      }
    //    } else {
    //      $value = urldecode($value);
    //    }

    // {{{ проверка входящей инфы на валидность
    // (либо и field, и value должны быть массивами, либо строками,
    // пустых строк нигде быть не должно, в т.ч. в эл-тах массивов)
    $allowedFields = array(
      'uname',
      'email',
      'rocid',
      'lastname',
      'firstname',
      'fathername',
      'name',
      'role_id',
      'company_name',
      'company_id',
    );
    if (is_array($field) && is_array($value)) {
      if (count($field) != count($value)) {
        $this->sendResponse(203);
      }
      foreach ($field as $str) {
        if (!in_array($str, $allowedFields)) {
          $this->sendResponse(204);
        }
      }
      foreach ($value as $str) {
        if (empty($str)) {
          $this->sendResponse(205);
        }
      }
    } elseif (is_array($field) && !is_array($value) || !is_array($field) && is_array($value)) {
      $this->sendResponse(202);
    } elseif (empty($field) || empty($value)) {
      $this->sendResponse(202);
    }
    // }}}

    $this->sendUserInfo($field, $value, $logic, $limit);
  }

  private function sendUserInfo($field, $value, $logic, $limit = false)
  {
    $event = Event::GetEventByIdName($this->EventName);

    if (!is_array($field)) {
      $field = array($field);
      $value = array($value);
    }
    $fields = $field;
    $values = $value;

    $userModel = User::model()->with(array('Employments' => array('together' => true), 'Employments.Company' => array('together' => true), 'Emails', 'EventUsers', 'EventUsers.EventRole', 'Settings'));

    $criteria = new CDbCriteria();
    $j=0;
    if ($logic == 'AND')
    {
      $criteria->condition = '1=1';
    }
    else
    {
      $criteria->condition = '0=1';
    }

    $rocids = array();
    foreach ($fields as $i => $field)
    {
      $value = $values[$i];
      switch ($field)
      {
        case 'rocid':
          $rocids[] = $value;
          break;
        case 'email':
          $criteria->condition .= ' ' . $logic . ' t.Email = :Email';
          $criteria->params[':Email'] = $value;
          break;
        case 'name':
        case 'uname':
          $value = iconv('cp1251', 'utf-8', $value);
          if (strpos($value, ' ') !== false)
          {
            $exploded = explode(' ', $value);
            $criteria->condition .= ' ' . $logic . ' ((t.LastName = :UnamePart1 AND t.FirstName = :UnamePart2) OR (t.LastName = :UnamePart2 AND t.FirstName = :UnamePart1))';
            $criteria->params[':UnamePart1'] = $exploded[0];
            $criteria->params[':UnamePart2'] = $exploded[1];
          }
          else
          {
            $criteria->condition .= ' ' . $logic . ' (t.LastName = :Uname OR t.FirstName = :Uname)';
            $criteria->params[':Uname'] = $value;
          }
          break;
        case 'lastname':
          $value = iconv('cp1251', 'utf-8', $value);
          $criteria->condition .= ' ' . $logic . ' t.LastName = :LastName';
          $criteria->params[':LastName'] = $value;
          break;
        case 'firstname':
          $value = iconv('cp1251', 'utf-8', $value);
          $criteria->condition .= ' ' . $logic . ' t.FirstName = :FirstName';
          $criteria->params[':FirstName'] = $value;
          break;
        case 'role_id':
          $criteria->condition .= ' ' . $logic . ' EventUsers.RoleId = :RoleId';
          $criteria->params[':RoleId'] = $value;
          break;
        case 'company_id':
          $criteria->condition .= ' ' . $logic . ' (Company.CompanyId = :CompanyId AND Employments.FinishWorking > :DateNow)';
          $criteria->params[':CompanyId'] = $value;
          $criteria->params[':DateNow'] = date('Y-m-d');
          break;
        case 'company_name':
          $value = iconv('cp1251', 'utf-8', $value);
          $criteria->condition .= ' ' . $logic . ' (Company.Name = :CompanyName AND Employments.FinishWorking > :DateNow)';
          $criteria->params[':CompanyName'] = $value;
          $criteria->params[':DateNow'] = date('Y-m-d');
          break;
      }
      $j++;
      if ($j > 20)
      {
        //break;
      }
    }

    if (! empty($rocids))
    {
      $criteria->addInCondition('t.RocId', $rocids, $logic);
    }

    $criteria->order = 't.LastName';
    if ($limit != 0)
    {
      $criteria->limit = $limit;
    }

    $criteria->condition = 'Settings.Visible = \'1\' AND (' . $criteria->condition . ')';


    /**
     * @var User[] $users
     */
    $users = $userModel->findAll($criteria);


    //throw new Exception('Test!!!');

    if (empty($users))
    {
      $this->sendResponse(201);
    }

    $result = array();
    foreach ($users as $user)
    {
      $email = $user->GetEmail() != null ? $user->GetEmail()->Email : $user->Email;
      $result[$user->UserId] = array('user_id' => $user->UserId, 'rocid' => $user->RocId,
                                     'lastname' => iconv('utf-8', 'cp1251', $user->LastName),
                                     'firstname' => iconv('utf-8', 'cp1251', $user->FirstName),
                                     'password' => $user->Password, 'email' => $email);

      foreach ($user->Employments as $employment)
      {
        if ($employment->Primary == 1)
        {
          if (isset($employment->Company))
          {
            $result[$user->UserId]['company'] = htmlspecialchars(iconv('utf-8', 'cp1251', $employment->Company->Name));
            $result[$user->UserId]['position'] = htmlspecialchars(iconv('utf-8', 'cp1251', $employment->Position));
          }
          break;
        }
      }

      foreach ($user->EventUsers as $eventUser)
      {
        if ($eventUser->EventId == $event->EventId)
        {
          $result[$user->UserId]['role_id'] = $eventUser->RoleId;
          $result[$user->UserId]['role_name'] = iconv('utf-8', 'cp1251', $eventUser->EventRole->Name);
        }
      }
    }

    if ($this->EventName == 'ok10')
    {
      //echo sizeof($users);
      //throw new Exception('Error!!!!');
    }

    //$this->SendLog($result);

    $this->sendResponse(0, $result);
  }

  private function SendLog($result)
  {
    $logger = Yii::getLogger();
    $stats = Yii::app()->db->getStats();
    $logs = $logger->getProfilingResults();

    ob_start();
    echo '<br/> SQL queries: ' . $stats[0] .
         '<br/> SQL Execution Time: ' . $stats[1] .
         '<br/> Full Execution Time: ' . $logger->getExecutionTime();

    echo '<pre>';
    print_r($_REQUEST);
    echo '</pre>';


    echo '<pre>';
    print_r($logs);
    echo '</pre>';

    echo '<pre>';
    print_r($result);
    echo '</pre>';

    $log = ob_get_clean();


    AutoLoader::Import('library.mail.*');

    $mail = new PHPMailer(false);
    $mail->AddAddress('nikitin@internetmediaholding.com');
    $mail->SetFrom('error@rocid.ru', 'rocID', false);
    $mail->CharSet = 'utf-8';
    $subject = 'Error! ' . $_SERVER['REQUEST_URI'] . time();
    $mail->Subject = '=?UTF-8?B?'. base64_encode($subject) .'?=';
    $mail->AltBody = 'Для просмотра этого сообщения необходимо использовать клиент, поддерживающий HTML';
    $mail->MsgHTML($log);
    $mail->Send();
  }
}