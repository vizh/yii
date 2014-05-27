<?php
namespace ruvents\controllers\visit;

class CreateGroupAction extends \ruvents\components\Action
{
  public function run($hallId, $data)
  {
    $hall = \event\models\section\Hall::model()->byEventId($this->getEvent()->Id)->findByPk($hallId);
    if ($hall == null)
      throw new \ruvents\components\Exception(701, [$hallId]);

    $dataJson = json_encode($data);
    if (is_array($dataJson))
    {
      foreach ($dataJson as $item)
      {
        $valid = true;
        $visitDatetime = \DateTime::createFromFormat('Y-m-d H:i:s', $item->VisitTime);
        if ($visitDatetime === false)
          $valid = false;

        $user = \user\models\User::model()->byRunetId($item->RunetId)->find();
        if ($user === null)
          $valid = false;

        if ($valid)
        {
          $visit = new \event\models\section\UserVisit();
          $visit->UserId = $user->Id;
          $visit->HallId = $hall->Id;
          $visit->VisitTime = $visitDatetime->format('Y-m-d H:i:s');
          $visit->save();
        }
      }
    }
    $this->renderJson(['Success' => true]);
  }
} 