<?php
AutoLoader::Import('gate.source.*');
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

class GateProgram extends GateCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {


    $DOM = new DOMDocument('1.0', 'CP1251');
    $response = $DOM->appendChild(new DOMElement('response'));
    $errorCode = $response->appendChild(new DOMElement('error-code'));
    try
    {
      $event = Event::GetEventByIdName($this->EventName);

      $with = array('UserLinks.Role', 'UserLinks.Report', 'UserLinks.User.Employments.Company');
      if (isset($_REQUEST['subevent']))
      {
        $programId = intval($_REQUEST['subevent']);
        if ($programId <= 0)
        {
          throw new Exception('Invalid subevent id', 301);
        }
        /**
         * @var EventProgram[] $programs
         */
        $programs = $event->Program(array('condition' => 'EventProgramId = :ProgramId', 'params' => array(':ProgramId' => $programId), 'with' => $with));
        if (sizeof($programs) == 0)
        {
          throw new Exception('Subevent not found', 302);
        }
      }
      else
      {
        $programs = $event->Program(array('with' => $with));
      }

      foreach ($programs as $program)
      {
        $dnSubevent = $response->appendChild(new DOMElement('subevent'));
        $dnSubevent->setAttribute('id', $program->EventProgramId);

        $this->addDomTextNode($dnSubevent, 'event_type' , $program->Type);
        $this->addDomTextNode($dnSubevent, 'abbr' , $program->Abbr);
        $this->addDomTextNode($dnSubevent, 'title' , $program->Title);
        $this->addDomTextNode($dnSubevent, 'comment' , $program->Comment);
        $this->addDomTextNode($dnSubevent, 'audience' , $program->Audience);
        $this->addDomTextNode($dnSubevent, 'rubricator' , $program->Rubricator);
        $this->addDomTextNode($dnSubevent, 'link_photo' , $program->LinkPhoto);
        $this->addDomTextNode($dnSubevent, 'link_video' , $program->LinkVideo);
        $this->addDomTextNode($dnSubevent, 'link_shorthand' , $program->LinkShorthand);
        $this->addDomTextNode($dnSubevent, 'link_audio' , $program->LinkAudio);
        $this->addDomTextNode($dnSubevent, 'datetime_start' , $program->DatetimeStart);
        $this->addDomTextNode($dnSubevent, 'datetime_finish' , $program->DatetimeFinish);
        $this->addDomTextNode($dnSubevent, 'place' , $program->Place);
        $this->addDomTextNode($dnSubevent, 'description' , $program->Description);
        $this->addDomTextNode($dnSubevent, 'partners' , $program->Partners);
        $this->addDomTextNode($dnSubevent, 'fill' , $program->Fill);
        $this->addDomTextNode($dnSubevent, 'access' , $program->Access);


        /**
         * @var EventProgramUserLink[] $userlinks
         */
        $userlinks = $program->UserLinks;
        foreach ($userlinks as $userLink)
        {
          /**
           * @var DOMElement $dnPerson
           */
          $dnPerson = $dnSubevent->appendChild(new DOMElement('person'));

          $dnPerson->setAttribute('role_id', $userLink->RoleId);
          $dnPerson->setAttribute('role_name', $userLink->Role->Name);
          $dnPerson->setAttribute('order', $userLink->Order);

          if (! empty($userLink->User))
          {
            $dnPerson->setAttribute('name', $userLink->User->LastName . ' ' . $userLink->User->FirstName);
            $dnPerson->setAttribute('rocid', $userLink->User->RocId);
            foreach ($userLink->User->Employments as $employment)
            {
              if ($employment->Primary == 1)
              {
                $dnPerson->setAttribute('position', $employment->Position);
                if (isset($employment->Company))
                {
                  $dnPerson->setAttribute('company', $employment->Company->Name);
                }
                break;
              }
            }
          }

          if (! empty($userLink->Report))
          {
            $dnReport = $dnPerson->appendChild(new DOMElement('report'));
            $dnReport->setAttribute('id', $userLink->Report->ReportId);
            $this->addDomTextNode($dnReport, 'header', $userLink->Report->Header);
            $this->addDomTextNode($dnReport, 'thesis', $userLink->Report->Thesis);
            $this->addDomTextNode($dnReport, 'link_presentation', $userLink->Report->LinkPresentation);
          }
        }
      }
      $errorCode->nodeValue = '0';
    }
    catch (Exception $e)
    {
      $errorDescription = $response->appendChild(new DOMElement('error-description'));
      $errorDescription->nodeValue = $e->getMessage();
      $errorCode->nodeValue = $e->getCode();
    }

    header('Content-type: text/xml');
    echo $DOM->saveXML();
  }

  /**
   * @param DOMElement $parent
   * @param string $nodeName
   * @param string $nodeValue
   * @return DOMElement
   */
  private function addDomTextNode($parent, $nodeName, $nodeValue)
  {
    $fieldNode = $parent->appendChild(new DOMElement($nodeName));
    $textNode = new DOMText($nodeValue);
    return $fieldNode->appendChild($textNode);
  }

  private function addDomTextNodeArray($parent, $children, $skipEmpty = true)
  {
    foreach ($children as $nodeName => $nodeValue) {
      if (!empty($nodeValue) || !$skipEmpty) {
        $this->addDomTextNode($parent, $nodeName, $nodeValue);
      }
    }
  }

  /**
   * @param DOMElement $node
   * @param array $attributes
   * @param bool $skipEmpty
   * @return void
   */
  private function setAttributeArray($node, $attributes, $skipEmpty = true)
  {
    foreach ($attributes as $name => $value) {
      if (!empty($value) || !$skipEmpty)
      {
        $node->setAttribute($name, $value);
      }
    }
  }
}