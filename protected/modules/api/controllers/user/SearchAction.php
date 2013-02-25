<?php
namespace api\controllers\user;

class SearchAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $query = $request->getParam('Query', null);
    $maxResults = $request->getParam('MaxResults', $this->getMaxResults());
    $maxResults = min($maxResults, $this->getMaxResults());
    $pageToken = $request->getParam('PageToken', null);

    if (strlen($query) === 0)
    {
      throw new \api\components\Exception(203);
    }

    $criteria = new \CDbCriteria();
    if ($pageToken === null)
    {
      $criteria->limit = $maxResults;
      $criteria->offset = 0;
    }
    else
    {
      $criteria->limit = $maxResults;
      $criteria->offset = $this->getController()->parsePageToken($pageToken);
    }

    $with = array(
      'Settings',
      'Employments.Company' => array('on' => '"Employments"."Primary"'),
      'LinkEmail.Email'
    );
    if ($this->Account->EventId != null)
    {
      $with['EventUsers'] = array('on' => '"EventUsers"."EventId" = :EventId', 'params' => array(':EventId' => $this->Account->EventId));
    }
    else
    {
      $with[] = 'EventUsers';
    }
    $with[] = 'EventUsers.EventRole';
    $with[] = 'EventUsers.Event';
    $model = \user\models\User::model()->bySearch($query)->with($with);

    /** @var $users \user\models\User[] */
    $users = $model->findAll($criteria);

    $result = array();
    foreach ($users as $user)
    {
      $this->getAccount()->DataBuilder()->CreateUser($user);
      $this->getAccount()->DataBuilder()->BuildUserEmail($user);
      $this->getAccount()->DataBuilder()->BuildUserEmployment($user);
      $result['Users'][] = $this->getAccount()->DataBuilder()->BuildUserEvent($user);
    }

    if (sizeof($users) === $maxResults)
    {
      $result['NextPageToken'] = $this->getController()->getPageToken($criteria->offset + $maxResults);
    }

    $this->getController()->setResult($result);
  }

  /**
   * @return int
   */
  protected function getMaxResults()
  {
    return \Yii::app()->params['ApiMaxResults'];
  }
}
