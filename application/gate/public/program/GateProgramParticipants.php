<?php
AutoLoader::Import('gate.source.*');
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

class GateProgramParticipants extends GateCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    /**
     * На входе:
     * $serializeSelect - сериализованные данные (массив возвращаемых полей)
     * $serializeData - сериализованные данные (массив запрашиваемых полей)
     *
     * на выходе (коды ошибок):
     * 101 - ошибка unserialize
     * 102 - не задан event_id
     * 200 - возвращается в случае, когда указан параметр isExists - польрователь найден
     * 404 - возвращается в случае, когда указан параметр isExists - польрователь НЕ найден
     */
    $selectData = unserialize(Registry::GetRequestVar('serializeSelect'));
    $filterData = unserialize(Registry::GetRequestVar('serializeFilter'));

    $isExists = Registry::GetRequestVar('isExists', false);

    if (empty($filterData)) {
      $this->SendResponse(101);
    }

    $event = Event::GetEventByIdName($this->EventName);
    $criteria = $this->getCriteria($filterData);
    $criteria->condition .= ' AND t.EventId = :EventId';
    $criteria->params[':EventId'] = $event->EventId;

    $userLinksModel = EventProgramUserLink::model()->with('User.Employments.Company', 'User.Emails', 'Report');

    if ($isExists)
    {
      if ($userLinksModel->count($criteria) > 0)
      {
        $this->SendResponse(200);
      }
      else
      {
        $this->SendResponse(404);
      }
    }
    else {
      $DOM = new DOMDocument('1.0', 'CP1251');
      $response = $DOM->appendChild(new DOMElement('response'));
      $this->addDomTextNode($response, 'error-code', '0');

      /**
       * @var EventProgramUserLink[] $userLinks
       */
      $userLinks = $userLinksModel->findAll($criteria);
      foreach ($userLinks as $userlink)
      {
        $user = $response->appendChild(new DOMElement('user'));
        $this->addDomTextNode($user, 'rocid', $userlink->User->RocId);
        $this->addDomTextNode($user, 'lastname', $userlink->User->LastName);
        $this->addDomTextNode($user, 'firstname', $userlink->User->FirstName);
        $email = $userlink->User->GetEmail() != null ? $userlink->User->GetEmail()->Email : $userlink->User->Email;
        $this->addDomTextNode($user, 'email', $email);
        foreach ($userlink->User->Employments as $employment)
        {
          if ($employment->Primary == 1)
          {
            $this->addDomTextNode($user, 'position', $employment->Position);
            $this->addDomTextNode($user, 'company_id', $employment->Company->CompanyId);
            $this->addDomTextNode($user, 'company', $employment->Company->Name);
          }
        }

        $this->addDomTextNode($user, 'event_id', $userlink->EventProgramId);
        $this->addDomTextNode($user, 'role_id', $userlink->RoleId);
        $this->addDomTextNode($user, 'report_id', $userlink->ReportId);
        $this->addDomTextNode($user, 'order', $userlink->Order);

        if (! empty($userlink->Report))
        {
          $this->addDomTextNode($user, 'header', $userlink->Report->Header);
          $this->addDomTextNode($user, 'thesis', $userlink->Report->Thesis);
          $this->addDomTextNode($user, 'link_presentation', $userlink->Report->LinkPresentation);
        }
      }

      header('Content-type: text/xml');
      echo $DOM->saveXML();
    }
  }

  /**
   * @param DOMElement $parentNode
   * @param  $field
   * @param  $text
   * @return
   */
  private function addDomTextNode($parentNode, $field, $text)
  {
    $fieldNode = $parentNode->appendChild(new DOMElement($field));
    $textNode = new DOMText($text);
    return $fieldNode->appendChild($textNode);
  }

  /**
   * @param array $filters
   * @return CDbCriteria
   */
  private function getCriteria($filters)
  {
    $criteria = new CDbCriteria();
    $criteria->condition = '1=1';
    foreach ($filters as $filter => $value)
    {
      $filterName = '';
      switch ($filter)
      {
        case 'rocid':
          $criteria->condition .= ' AND User.RocId = :RocId';
          $filterName = ':RocId';
          break;
        case 'lastname':
          $criteria->condition .= ' AND User.LastName = :LastName';
          $filterName = ':LastName';
          break;
        case 'firstname':
          $criteria->condition .= ' AND User.FirstName = :FirstName';
          $filterName = ':FirstName';
          break;
        case 'email':
          $criteria->condition .= ' AND (User.Email = :Email OR Emails.Email = :Email)';
          $filterName = ':Email';
          break;
        case 'report_id':
          $criteria->condition .= ' AND t.ReportId = :ReportId';
          $filterName = ':ReportId';
          break;
        case 'event_id':
          $criteria->condition .= ' AND t.EventProgramId = :EventProgramId';
          $filterName = ':EventProgramId';
          break;
      }
      if (! empty($filterName))
      {
        $criteria->params[$filterName] = $value;
      }
    }

    if (isset($filters['role_id']))
    {
      $criteria->addInCondition('t.RoleId', $filters['role_id']);
    }

    $criteria->order = 't.Order';

    return $criteria;
  }
}