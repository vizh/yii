<?php

class EventProgramUserinfo extends AjaxAdminCommand
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
      echo json_encode(array('error' => true, 'message' => 'Пользователь не найден.'));
    }

    $result['LinkId'] = $userLink->LinkId;
    $result['RocId'] = $userLink->User->RocId;
    $result['FullName'] = $userLink->User->LastName . ' ' . $userLink->User->FirstName;
    $result['Order'] = $userLink->Order;
    $result['Role'] = $userLink->RoleId;
    if (!empty($userLink->Report))
    {
      $result['Header'] = $userLink->Report->Header;
      $result['Thesis'] = $userLink->Report->Thesis;
      $result['LinkPresentation'] = $userLink->Report->LinkPresentation;
    }
    $result['error'] = false;

    echo json_encode($result);
  }
}
