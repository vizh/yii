<?php
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

class EventSectionUser extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $rocId = Registry::GetRequestVar('RocId');
    $result = array();

    $user = User::GetByRocid($rocId);
    if (empty($user))
    {
      $this->SendJson($result);
    }

    $model = EventProgram::model()->with('UserLinks')->together();

    $criteria = new CDbCriteria();
    $criteria->condition = 't.EventId = :EventId AND UserLinks.UserId = :UserId';
    $criteria->params = array(':EventId' => $this->Account->EventId, ':UserId' => $user->UserId);

    $sections = $model->findAll($criteria);

    foreach ($sections as $section)
    {
      $result[] = $this->Account->DataBuilder()->CreateSection($section);
    }

    $this->SendJson($result);
  }
}
