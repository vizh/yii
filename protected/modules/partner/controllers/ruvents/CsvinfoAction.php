<?php
namespace partner\controllers\ruvents;

class CsvinfoAction extends \partner\components\Action
{

  //const Step = 1000;

  public function run()
  {
    $this->getController()->setPageTitle('Генерация итоговых данных мероприятия');
    $this->getController()->initActiveBottomMenu('csvinfo');

    $event = \event\models\Event::GetById(\Yii::app()->partner->getAccount()->EventId);
    if (!empty($event->Days))
    {
      throw new \Exception('Не реализован для мероприятий с несколькими логическими днями!');
    }

    $criteria = new \CDbCriteria();
    $criteria->order = 't.CreationTime ASC';

    /** @var $badges \ruvents\models\Badge[] */
    $badges = \ruvents\models\Badge::model()->byEventId(\Yii::app()->partner->getAccount()->EventId)->findAll($criteria);


    $result = array();
    foreach ($badges as $badge)
    {
      if (!isset($result[$badge->UserId]))
      {
        $info = new \stdClass();
        $info->Badge = $badge;
        $info->Count = 1;
        $result[$badge->UserId] = $info;
        continue;
      }

      if (strtotime($badge->CreationTime) - strtotime($result[$badge->UserId]->Badge->CreationTime) > 300)
      {
        $result[$badge->UserId]->Count++;
      }
    }

    foreach ($result as $info)
    {
      $this->addLine($info);
    }

    fclose($this->getFile());
    $this->getController()->render('csvinfo');
  }

  private function addLine($info)
  {
    /** @var $badge \ruvents\models\Badge */
    $badge = $info->Badge;

    $position = $company = '';
    if ($badge->User->EmploymentPrimary() != null)
    {
      $position = $badge->User->EmploymentPrimary()->Position;
      $company = $badge->User->EmploymentPrimary()->Company->Name;
    }

    $role = $badge->Role->Name;

    $status = '';


    fputcsv($this->getFile(), array($badge->User->GetFullName(), $company, $position, $role, $status, $badge->CreationTime, $info->Count));
  }

  private $file = null;
  private function getFile()
  {
    if ($this->file == null)
    {
      $this->file = fopen($this->getDataPath() . 'info_' . date('Y-m-d H:i:s') . '.csv', 'w');
    }
    return $this->file;
  }


  private $dataPath = null;
  private function getDataPath()
  {
    if (empty($this->dataPath))
    {
      $path = \Yii::getPathOfAlias('partner.data');
      $this->dataPath = $path . '/' . \Yii::app()->partner->getAccount()->EventId . '/csvinfo/';
      if (!file_exists($this->dataPath))
      {
        mkdir($this->dataPath, 0755, true);
      }
    }
    return $this->dataPath;
  }
}
