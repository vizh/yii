<?php
AutoLoader::Import('gate.source.*');
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

class GateProgramSection extends GateCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    /**
     * На входе:
     * $serializeFilter - сериализованные данные (массив запрашиваемых полей)
     *
     * на выходе (коды ошибок):
     * 101 - ошибка unserialize
     */
    $filterData = unserialize(Registry::GetRequestVar('serializeFilter'));

    $event = Event::GetEventByIdName($this->EventName);
    $criteria = new CDbCriteria();
    $criteria->condition = 'EventId = :EventId';
    $criteria->params[':EventId'] = $event->EventId;
    if (! empty($filterData) && is_array($filterData))
    {
      $criteria->addInCondition('EventProgramId', $filterData);
    }
    elseif (! empty($filterData))
    {
      $criteria->condition .= ' AND EventProgramId = :EventProgramId';
      $criteria->params[':EventProgramId'] = $filterData;
    }
    /**
     * @var EventProgram[] $programs
     */
    $programs = EventProgram::model()->findAll($criteria);

    $DOM = new DOMDocument('1.0', 'CP1251');
    $response = $DOM->appendChild(new DOMElement('response'));
    $this->addDomTextNode($response, 'error-code', '0');

    foreach ($programs as $program)
    {
      $section = $response->appendChild(new DOMElement('section'));

      $this->addDomTextNode($section, 'event_id' , $program->EventProgramId);
      $this->addDomTextNode($section, 'event_type' , $program->Type);
      $this->addDomTextNode($section, 'abbr' , $program->Abbr);
      $this->addDomTextNode($section, 'title' , $program->Title);
      $this->addDomTextNode($section, 'comment' , $program->Comment);
      $this->addDomTextNode($section, 'audience' , $program->Audience);
      $this->addDomTextNode($section, 'rubricator' , $program->Rubricator);
      $this->addDomTextNode($section, 'link_photo' , $program->LinkPhoto);
      $this->addDomTextNode($section, 'link_video' , $program->LinkVideo);
      $this->addDomTextNode($section, 'link_shorthand' , $program->LinkShorthand);
      $this->addDomTextNode($section, 'link_audio' , $program->LinkAudio);
      $this->addDomTextNode($section, 'datetime_start' , $program->DatetimeStart);
      $this->addDomTextNode($section, 'datetime_finish' , $program->DatetimeFinish);
      $this->addDomTextNode($section, 'place' , $program->Place);
      $this->addDomTextNode($section, 'description' , $program->Description);
      $this->addDomTextNode($section, 'partners' , $program->Partners);
      $this->addDomTextNode($section, 'fill' , $program->Fill);
      $this->addDomTextNode($section, 'access' , $program->Access);
    }

    header('Content-type: text/xml');
    echo $DOM->saveXML();
  }

  /**
   * @param DOMElement $parentNode
   * @param  $parent
   * @param  $text
   * @return
   */
  private function addDomTextNode($parentNode, $field, $text)
  {
    $fieldNode = $parentNode->appendChild(new DOMElement($field));
    $textNode = new DOMText($text);
    return $fieldNode->appendChild($textNode);
  }
}