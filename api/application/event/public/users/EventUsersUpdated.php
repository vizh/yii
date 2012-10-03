<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.event.*');

class EventUsersUpdated extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $updateTime = Registry::GetRequestVar('FromUpdateTime', 0);
    $query = Registry::GetRequestVar('Query', null);
    $roleId = Registry::GetRequestVar('RoleId', null);
    $maxResults = Registry::GetRequestVar('MaxResults', self::MaxResult);
    $pageToken = Registry::GetRequestVar('PageToken', null);

    $maxResults = min($maxResults, self::MaxResult);

    if (strlen($query) != 0)
    {
      $criteria = User::GetSearchCriteria($query);
    }
    else
    {
      $criteria = new CDbCriteria();
    }

    $criteria->addCondition('EventUsers.EventId = :EventId AND EventUsers.UpdateTime > :UpdateTime');
    $criteria->params[':EventId'] = $this->Account->EventId;
    $criteria->params[':UpdateTime'] = $updateTime;
    $criteria->order = 'EventUsers.UpdateTime';

    if ($roleId !== null)
    {
      $criteria->addCondition('EventUsers.RoleId = :RoleId');
      $criteria->params[':RoleId'] = $roleId;
    }

    $offset = 0;
    if ($pageToken !== null)
    {
      $offset = $this->ParsePageToken($pageToken);
    }
    $criteria->limit = $maxResults;
    $criteria->offset = $offset;

    $userModel = User::model()->with(array(
      'EventUsers' => array('together' => true),
      'Settings',
    ));

    $criteria->group = 't.UserId';

    /** @var $users User[] */
    $users = $userModel->findAll($criteria);
    $idList = array();
    foreach ($users as $user)
    {
      $idList[] = $user->UserId;
    }

    $criteria = new CDbCriteria();
    $criteria->addInCondition('t.UserId', $idList);


    $userModel = User::model()->with(array(
      'Employments.Company' => array('on' => 'Employments.Primary = :Primary', 'params' => array(':Primary' => 1)),
      'EventUsers' => array('on' => 'EventUsers.EventId = :EventId', 'params' => array(':EventId' => $this->Account->EventId)),
      'EventUsers.EventRole',
      'Emails'
    ));

    /** @var $users User[] */
    $users = $userModel->findAll($criteria);

    $result = array();
    foreach ($users as $user)
    {
      $this->Account->DataBuilder()->CreateUser($user);
      $this->Account->DataBuilder()->BuildUserEmail($user);
      $this->Account->DataBuilder()->BuildUserEmployment($user);
      $result['Users'][] = $this->Account->DataBuilder()->BuildUserEvent($user);
    }

    if (sizeof($users) == $maxResults)
    {
      $result['NextPageToken'] = $this->GetPageToken($offset + $maxResults);
    }

    $this->SendJson($result);
  }
}
