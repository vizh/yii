<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 22.09.11
 * Time: 12:31
 * To change this template use File | Settings | File Templates.
 */
 
class EventProgramUseredit extends AjaxAdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $linkId = intval(Registry::GetRequestVar('LinkId', 0));
    $userLink = EventProgramUserLink::GetById($linkId);
    if (empty($userLink))
    {
      $userLink = new EventProgramUserLink();
      $programId = intval(Registry::GetRequestVar('EventProgramId', 0));
      $program = EventProgram::GetEventProgramById($programId);
      if (empty($program))
      {
        $this->sendError('Не найден пункт программы мероприятия');
      }
      $userLink->EventId = $program->EventId;
      $userLink->EventProgramId = $program->EventProgramId;
    }

    $rocId = intval(Registry::GetRequestVar('RocId', 0));
    $user = User::GetByRocid($rocId);
    if (empty($user))
    {
      $this->sendError('Не определен rocId участника программы');
    }
    $userLink->UserId = $user->UserId;

    $roleId = intval(Registry::GetRequestVar('Role', 0));
    if ($roleId == 0)
    {
      $this->sendError('Не выбрана роль участника мероприятия');
    }
    $userLink->RoleId = $roleId;

    $report = $userLink->Report;
    if (empty($report))
    {
      $report = new EventReports();
    }

    $purifier = new CHtmlPurifier();
    $purifier->options = array();

    $report->Header = $purifier->purify(Registry::GetRequestVar('Header', ''));
    $report->Thesis = $purifier->purify(Registry::GetRequestVar('Thesis', ''));
    $report->LinkPresentation = $purifier->purify(Registry::GetRequestVar('LinkPresentation', ''));
    $report->save();

    $userLink->ReportId = $report->ReportId;

    $userLink->Order = Registry::GetRequestVar('Order', 0);

    $userLink->save();

    $user = User::GetById($userLink->UserId);

    $flag = false;
    foreach ($user->EventUsers as $eUser)
    {
      if ($eUser->EventId == $userLink->EventId)
      {
        if ($userLink->RoleId == 5)
        {
          $eUser->RoleId = 31;
          $eUser->UpdateTime = time();
          $eUser->save();
        }
        else
        {
          if ($eUser->RoleId == 1 || $eUser->RoleId == 11 || $eUser->RoleId == 24)
          {
            $eUser->RoleId = 3;
            $eUser->UpdateTime = time();
            $eUser->save();
          }
        }
        $flag = true;
        break;
      }
    }

    if (! $flag )
    {
      $eventUser = new EventUser();
      $eventUser->UserId = $userLink->UserId;
      $eventUser->EventId = $userLink->EventId;
      $eventUser->RoleId = $userLink->RoleId != 5 ? 3 : 31; //Докладчик или Участник круглого стола
      $eventUser->CreationTime = $eventUser->UpdateTime = time();
      $eventUser->save();
    }


    $result = array('error' => false);
    echo json_encode($result);
  }

  private function sendError($message)
  {
    $result['error'] = true;
    $result['message'] = $message;
    echo json_encode($result);
    exit;
  }
}
