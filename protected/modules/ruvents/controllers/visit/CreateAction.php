<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 23.05.14
 * Time: 17:27
 */

namespace ruvents\controllers\visit;


class CreateAction extends \ruvents\components\Action
{
  public function run($hallId, $runetId, $visitTime)
  {
    $hall = \event\models\section\Hall::model()->byEventId($this->getEvent()->Id)->findByPk($hallId);
    if ($hall == null)
      throw new \ruvents\components\Exception(701,[$hallId]);

    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user == null)
      throw new \ruvents\components\Exception(202,[$runetId]);

    $visitDatetime = \DateTime::createFromFormat('Y-m-d H:i:s', $visitTime);
    if ($visitDatetime === false)
      throw new \ruvents\components\Exception(702);

    $visit = new \event\models\section\UserVisit();
    $visit->UserId = $user->Id;
    $visit->HallId = $hall->Id;
    $visit->VisitTime = $visitDatetime->format('Y-m-d H:i:s');
    $visit->save();

    $this->renderJson(['Success' => true]);
  }
} 