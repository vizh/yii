<?php
AutoLoader::Import('library.rocid.event.*');
 
class EventProgramEdit extends AdminCommand
{

  /**
   * Основные действия комманды
   * @param int $id
   * @return void
   */
  protected function doExecute($id = 0)
  {
    $eventProgram = EventProgram::GetEventProgramById($id);
    if (empty($eventProgram ) || empty($eventProgram->Event))
    {
      Lib::Redirect(RouteRegistry::GetAdminUrl('event', '', 'list'));
    }

    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      $data = Registry::GetRequestVar('data');

      $purifier = new CHtmlPurifier();
      $purifier->options = array('HTML.AllowedElements' => '', 'HTML.AllowedAttributes' => '');
      
      $eventProgram->Title = $purifier->purify($data['ProgramTitle']);

      $purifier->options = array();//array('HTML.AllowedElements' => array('a', 'p', 'br', 'strong', 'em', 'ul', 'ol', 'li'));
      $eventProgram->Description = $purifier->purify($data['Description']);
      $eventProgram->Comment = $purifier->purify($data['Comment']);
      $eventProgram->Audience = $purifier->purify($data['Audience']);
      $eventProgram->Rubricator = $purifier->purify($data['Rubricator']);
      $eventProgram->Partners = $purifier->purify($data['Partners']);

      $purifier->options = array('HTML.AllowedElements' => '', 'HTML.AllowedAttributes' => '');
      $eventProgram->LinkPhoto = $purifier->purify($data['LinkPhoto']);
      $eventProgram->LinkVideo = $purifier->purify($data['LinkVideo']);
      $eventProgram->LinkShorthand = $purifier->purify($data['LinkShorthand']);
      $eventProgram->LinkAudio = $purifier->purify($data['LinkAudio']);

      $startHour = min(24, max(0, intval($data['TimeStartHour'])));
      $startMin = min(60, max(0, intval($data['TimeStartMin'])));
      $endHour = min(24, max(0, intval($data['TimeEndtHour'])));
      $endMin = min(60, max(0, intval($data['TimeEndMin'])));
      $eventProgram->DatetimeStart = $data['Date'] . ' ' . $startHour . ':' . $startMin . ':' . '00';
      $eventProgram->DatetimeFinish = $data['Date'] . ' ' . $endHour . ':' . $endMin . ':' . '00';

      $eventProgram->Type = $data['Type'] == EventProgram::ProgramTypeShort ? EventProgram::ProgramTypeShort : EventProgram::ProgramTypeFull;
      $eventProgram->Abbr = $purifier->purify($data['Abbr']);
      $eventProgram->Fill = isset($data['Fill']) ? 1 : 0;
      $eventProgram->Place = $purifier->purify($data['Place']);

      $eventProgram->Access = !empty($data['Access']) ? implode(',', $data['Access']) : '';


      $eventProgram->save();
    }

    $this->view->EventProgramId = $eventProgram->EventProgramId;
    $this->view->EventId = $eventProgram->Event->EventId;

    $this->view->ProgramTitle = $eventProgram->Title;
    $this->view->Description = $eventProgram->Description;
    $this->view->Comment = $eventProgram->Comment;
    $this->view->Audience = $eventProgram->Audience;
    $this->view->Rubricator = $eventProgram->Rubricator;
    $this->view->Partners = $eventProgram->Partners;

    $this->view->LinkPhoto = $eventProgram->LinkPhoto;
    $this->view->LinkVideo = $eventProgram->LinkVideo;
    $this->view->LinkShorthand = $eventProgram->LinkShorthand;
    $this->view->LinkAudio = $eventProgram->LinkAudio;
    
    $this->view->EventDateStart = strtotime($eventProgram->Event->DateStart);
    $this->view->EventDateEnd = strtotime($eventProgram->Event->DateEnd);
    $this->view->Date = date('Y-m-d', strtotime($eventProgram->DatetimeStart));
    $this->view->TimeStart = getdate(strtotime($eventProgram->DatetimeStart));
    $this->view->TimeEnd = getdate(strtotime($eventProgram->DatetimeFinish));

    $this->view->Type = $eventProgram->Type;
    $this->view->Abbr = $eventProgram->Abbr;
    $this->view->Fill = $eventProgram->Fill;
    $this->view->Place = $eventProgram->Place;

    $this->view->Access = preg_split('/\,/', $eventProgram->Access, -1, PREG_SPLIT_NO_EMPTY);
    $this->view->EventUserRoles = EventUser::GetEventRoles($eventProgram->EventId);

    echo $this->view;
  }
}
