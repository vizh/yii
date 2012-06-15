<?php
AutoLoader::Import('library.rocid.user.*');

class UserSearch extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $query = Registry::GetRequestVar('Query', null);
    $maxResults = Registry::GetRequestVar('MaxResults', self::MaxResult);
    $pageToken = Registry::GetRequestVar('PageToken', null);

    if (strlen($query) === 0)
    {
      throw new ApiException(203);
    }

    $criteria = User::GetSearchCriteria($query);
    if ($pageToken === null)
    {
      $criteria->limit = min($maxResults, self::MaxResult);
      $criteria->offset = 0;
    }
    else
    {
      $criteria->limit = self::MaxResult;
      $criteria->offset = $this->ParsePageToken($pageToken);
    }

    $with = array(
      'Settings',
      'Employments.Company' => array('on' => 'Employments.Primary = :Primary', 'params' => array(':Primary' => 1)),
      'Emails'
    );
    if ($this->Account->EventId != null)
    {
      $with['EventUsers'] = array('on' => 'EventUsers.EventId = :EventId', 'params' => array(':EventId' => $this->Account->EventId));
    }
    else
    {
      $with[] = 'EventUsers';
    }
    $with[] = 'EventUsers.EventRole';
    $with[] = 'EventUsers.Event';
    $model = User::model()->with($with);

    /** @var $users User[] */
    $users = $model->findAll($criteria);

    $result = array();
    foreach ($users as $user)
    {
      $this->Account->DataBuilder()->CreateUser($user);
      $this->Account->DataBuilder()->BuildUserEmail($user);
      $this->Account->DataBuilder()->BuildUserEmployment($user);
      $result['Users'][] = $this->Account->DataBuilder()->BuildUserEvent($user);
    }

    if (sizeof($users) == self::MaxResult)
    {
      $result['NextPageToken'] = $this->GetPageToken($criteria->offset + self::MaxResult);
    }

    $this->SendJson($result);
  }
}
