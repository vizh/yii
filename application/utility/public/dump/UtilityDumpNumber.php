<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

class UtilityDumpNumber extends AbstractCommand
{

  private $numbers = array();

  private $usedRocId = array();

  private $output = '';

  private $newLine = "\r\n";

  const CacheId = 'temp_dump_data';

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $data = Yii::app()->cache->get(self::CacheId);
    if ($data === false)
    {
      $data = file_get_contents('http://2012.russianinternetforum.ru/_external/car_numbers.php?KEY=pK4npg7K62KQ');
      $data = json_decode($data);
      Yii::app()->cache->set(self::CacheId, $data, 900);
    }

    foreach ($data as $item)
    {
      $this->numbers[$item->RocId] = $item->NumberAuto;
    }

    $this->fillPremium();
    $this->fillRooms();

    echo $this->output;
  }

  private function fillPremium()
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params = array(':EventId' => 245);
    $criteria->addInCondition('t.RoleId', array(14, 22, 25));
    /** @var $eventUsers EventUser[] */
    $eventUsers = EventUser::model()->with('User', 'EventRole')->findAll($criteria);

    foreach ($eventUsers as $eUser)
    {
      $this->output .= $eUser->User->RocId . ';' . $eUser->User->LastName . ' ' . $eUser->User->FirstName
        . ' ' . $eUser->User->FatherName . ';' . $eUser->EventRole->Name . ';';
      if (isset($this->numbers[$eUser->User->RocId]))
      {
        $this->output .= $this->numbers[$eUser->User->RocId];
        unset($this->numbers[$eUser->User->RocId]);
      }
      $this->output .= ';17,18,19,20' . $this->newLine;
      $this->usedRocId[] = $eUser->User->RocId;
    }
  }

  private function fillRooms()
  {
    $command = Registry::GetDb()->createCommand()->select('u.RocId, u.LastName, u.FirstName, u.FatherName, ep.DatetimeStart')->from('EventProgramUserLink ul')
      ->join('User u', 'ul.UserId = u.UserId')->join('EventProgram ep', 'ep.EventProgramId = ul.EventProgramId')
      ->where('ul.EventId = :EventId AND u.RocId NOT IN (' . implode(',', $this->usedRocId) . ')', array(':EventId' => 245));

    $result = $command->queryAll();

    $resultByRocId = array();
    foreach ($result as $user)
    {
      if (!isset($resultByRocId[$user['RocId']]))
      {
        $resultByRocId[$user['RocId']] = $user;
        $resultByRocId[$user['RocId']]['Days'] = array();
      }
      $day = date('d', strtotime($user['DatetimeStart']));
      if (!in_array($day, $resultByRocId[$user['RocId']]['Days']))
      {
        $resultByRocId[$user['RocId']]['Days'][] = $day;
      }
    }

    $keys = array_keys($this->numbers);
    $criteria = new CDbCriteria();
    $criteria->condition = 't.Paid = :Paid AND Product.EventId = :EventId AND Product.Manager = :Manager';
    $criteria->params = array(
      ':Paid' => '1',
      ':EventId' => 245,
      ':Manager' => 'RoomProductManager',
    );
    $criteria->addInCondition('Owner.RocId', $keys);

    /** @var $orderItems OrderItem[] */
    $orderItems = OrderItem::model()->with(array('Product' => array('together' => true, 'select' => false), 'Owner' => array('together' => true), 'Params'))->findAll($criteria);

    foreach ($orderItems as $item)
    {
      $dayIn = intval(date('d', strtotime($item->GetParam('DateIn')->Value)));
      $dayOut = intval(date('d', strtotime($item->GetParam('DateOut')->Value)));

      if (isset($resultByRocId[$item->Owner->RocId]))
      {
        for ($day = $dayIn; $day<=$dayOut; $day++)
        {
          if (!in_array($day, $resultByRocId[$item->Owner->RocId]['Days']))
          {
            $resultByRocId[$item->Owner->RocId]['Days'][] = $day;
          }
        }
      }
      else
      {
        $this->output .= $item->Owner->RocId . ';' . $item->Owner->LastName . ' ' . $item->Owner->FirstName
                . ' ' . $item->Owner->FatherName . ';Участник;';
        $days = array();
        for ($day = $dayIn; $day<=$dayOut; $day++)
        {
          $days[] = $day;
        }
        if (isset($this->numbers[$item->Owner->RocId]))
        {
          $this->output .= $this->numbers[$item->Owner->RocId];
          unset($this->numbers[$item->Owner->RocId]);
        }
        $this->output .= ';' . implode(',', $days) . $this->newLine;
      }
    }

    foreach ($resultByRocId as $value)
    {
      $this->output .= $value['RocId'] . ';' . $value['LastName'] . ' ' . $value['FirstName']
                      . ' ' . $value['FatherName'] . ';Докладчик;';
      sort($value['Days']);
      if (isset($this->numbers[$value['RocId']]))
      {
        $this->output .= $this->numbers[$value['RocId']];
        unset($this->numbers[$value['RocId']]);
      }
      $this->output .= ';' . implode(',', $value['Days']) . $this->newLine;
    }
  }
}
