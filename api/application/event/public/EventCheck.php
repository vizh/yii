<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.event.*');

class EventCheck extends ApiCommand
{

  /**
   * Основные действия комманды
   * @throws ApiException
   * @return void
   */
  protected function doExecute()
  {
    $rocId = Registry::GetRequestVar('RocId');
    $events = Registry::GetRequestVar('Events');

    $user = User::GetByRocid($rocId);
    if (empty($user))
    {
      throw new ApiException(202, array($rocId));
    }

    $criteria = new CDbCriteria();
    $criteria->addCondition('t.UserId = :UserId');
    $criteria->params = array(':UserId' => $user->UserId);
    $criteria->addInCondition('Event.IdName', $events);
    $criteria->with = array('Event' => array('together' => true));

    $count = EventUser::model()->count($criteria);

    $this->SendJson(array('Check' => ($count > 0)));
  }
}
