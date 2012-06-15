<?php
AutoLoader::Import('library.rocid.user.*');

class UserList extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $rocid = Registry::GetRequestVar('RocId', null);

    $rocidList = preg_split('/,/', $rocid, -1, PREG_SPLIT_NO_EMPTY);// explode(',', $rocid);

    $criteria = new CDbCriteria();
    $criteria->addInCondition('t.RocId', $rocidList);
    $criteria->addCondition('Settings.Visible = \'1\'');
    $criteria->order = 't.LastName DESC, t.FirstName DESC, t.FatherName DESC, t.RocId DESC';
    $criteria->limit = self::MaxResult;

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

    $users = $model->findAll($criteria);

    $result = array();
    foreach ($users as $user)
    {
      $this->Account->DataBuilder()->CreateUser($user);
      $this->Account->DataBuilder()->BuildUserEmail($user);
      $this->Account->DataBuilder()->BuildUserEmployment($user);
      $result[] = $this->Account->DataBuilder()->BuildUserEvent($user);
    }

    $this->SendJson($result);
  }
}
