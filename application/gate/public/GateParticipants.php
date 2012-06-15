<?php
AutoLoader::Import('gate.source.*');
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

class GateParticipants extends GateCommand
{

  const Step = 1000;

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    ini_set("memory_limit", "512M");
    set_time_limit(90);
    $rocid = intval(Registry::GetRequestVar('rocid'));
    $idRole = Registry::GetRequestVar('role', false);
    $order = Registry::GetRequestVar('order');
//    ob_start();
//    var_dump($_POST);
//    var_dump($_REQUEST);
//    var_dump($idRole);
//    $msg = ob_get_clean();
    //Lib::SendErrorEmail('gate2', $msg);


    $order = preg_split('/[^a-z]+/', $order, null, PREG_SPLIT_NO_EMPTY);
    if (empty($order[0]))
    {
      $order[0] = 'uname';
    }
    if (empty($order[1]))
    {
      $order[1] = '';
    }
    $order[0] = strtolower($order[0]);
    $order[1] = strtoupper($order[1]);
    if (!in_array($order[0], array('uname', 'rocid', 'company')))
    {
      $order[0] = 'uname';
    }
    if ($order[1] != 'ASC' && $order[1] != 'DESC')
    {
      $order[1] = 'ASC';
    }

    $event = Event::GetEventByIdName($this->EventName);
    if (empty($event))
    {
      $this->SendResponse(102);
    }
    $usersModel = User::model()->with(array(
      'Employments.Company' => array('on' => 'Employments.Primary = :Primary', 'params' => array(':Primary' => 1)),
      'EventUsers',
      'Emails'
    ))->together();

    $criteria = new CDbCriteria();

    switch ($order[0]) {
      case 'uname':
        $criteria->order = sprintf('t.LastName %s, t.FirstName %s', $order[1], $order[1]);
        break;
      case 'rocid':
        $criteria->order = sprintf('t.Rocid %s', $order[1]);
        break;
      case 'company':
        $criteria->order = sprintf('Company.Name %s', $order[1]);
        break;
    }

    $criteria->condition = 'EventUsers.EventId = :EventId';// AND (Employments.Primary IS NULL OR Employments.Primary = 1)';
    $criteria->params[':EventId'] = $event->EventId;
    if (!empty($rocid))
    {
      $criteria->condition .= ' AND t.RocId = :RocId';
      $criteria->params[':RocId'] = $rocid;
    }
    if ($idRole !== false)
    {
      $criteria->condition .= ' AND EventUsers.RoleId = :RoleId';
      $criteria->params[':RoleId'] = intval($idRole);
    }

    if ($this->EventName == 'riw10')
    {
      //$criteria->limit = 11100;
    }




    /**
     * @var $users User[]
     */
    $users = $usersModel->findAll($criteria);

    $DOM = new DOMDocument('1.0', 'CP1251');
    $response = $DOM->appendChild(new DOMElement('response'));
    $errorCode = $response->appendChild(new DOMElement('error-code'));
    $this->addDomTextNode($errorCode, '0');
//    $query = "
//	SELECT	`u`.`rocid`,
//		`u`.`firstname`,
//		`u`.`lastname`,
//		`c`.`name` AS `company`,
//		`ue`.`position`,
//		`pu`.`role_id` AS `role`
//	FROM	`user` `u`
//		LEFT JOIN `proj_user` `pu` USING (`user_id`)
//		LEFT JOIN `user_employment` `ue` ON (`ue`.`user_id` = `u`.`user_id` AND `ue`.`primary` = 1)
//		LEFT JOIN `company` `c` USING (`company_id`)
//	WHERE	`pu`.`proj_id` = '$event'
//			".($rocid ? "AND `u`.`rocid` = $rocid" : '')."
//			".($idRole ? "AND `pu`.`role_id` = $idRole" : '')."
//	ORDER BY $order;
//";

    // {{{ debug
    // $debug = $response->appendChild(new DOMElement('debug'));
    // $_ = $query;
    // addDomTextNode($debug, $_);
    // }}}
//    $DB->Query($query);

    foreach ($users as $user)
    {
      $userNode = $response->appendChild(new DOMElement('user'));

      $this->addDomTextNode($userNode->appendChild(new DOMElement('rocid')), $user->RocId);
      $this->addDomTextNode($userNode->appendChild(new DOMElement('firstname')), $user->FirstName);
      $this->addDomTextNode($userNode->appendChild(new DOMElement('lastname')), $user->LastName);
      if (! empty($user->Employments))
      {
        foreach ($user->Employments as $employment)
        {
          if ($employment->Primary == 1)
          {
            if (isset($employment->Company))
            {
              $this->addDomTextNode($userNode->appendChild(new DOMElement('company')), $employment->Company->Name);
            }
            $this->addDomTextNode($userNode->appendChild(new DOMElement('position')), $employment->Position);
          }
        }
      }
      if (! empty($user->EventUsers[0]))
      {
        $this->addDomTextNode($userNode->appendChild(new DOMElement('role')), $user->EventUsers[0]->RoleId);
      }

      $email = ! empty($user->Emails) ? $user->Emails[0]->Email : $user->Email;
      $this->addDomTextNode($userNode->appendChild(new DOMElement('email')), $email);
    }

    header('Content-type: text/xml');
    echo $DOM->saveXML();
  }

  /**
   * @param DOMNode $parent
   * @param string $text
   * @return
   */
  private function addDomTextNode($parent, $text)
  {
    $textNode = new DOMText($text);
    return $parent->appendChild($textNode);
  }
}