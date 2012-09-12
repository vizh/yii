<?php


class UserEditController extends \partner\components\Controller
{
  public function actionEvent()
  {
    $request = \Yii::app()->request;
    $rocId = $request->getParam('rocId');
    $roleId = $request->getParam('roleId');
    $dayId = $request->getParam('dayId');

    $user = \user\models\User::GetByRocid($rocId);
    $role = \event\models\Role::GetById($roleId);
    $event = \event\models\Event::GetById(\Yii::app()->partner->getAccount()->EventId);
    $day = \event\models\Day::model()->findByPk($dayId);
    if (empty($user) || empty($event) || (!empty($event->Days) && empty($day)))
    {
      echo json_encode(array('error' => true));
      return;
    }

    if (empty($role))
    {
      $model = \event\models\Participant::model()->byUserId($user->UserId)->byEventId($event->EventId);
      if (!empty($event->Days))
      {
        $model = $model->byDayId($day->DayId);
      }
      $participant = $model->find();
      if (!empty($participant))
      {
        $participant->delete();
        echo json_encode(array('error' => false));
        return;
      }
      echo json_encode(array('error' => true));
      return;
    }

    if (empty($event->Days))
    {
      $participant = $event->RegisterUser($user, $role);
      if ($participant == null)
      {
        $participant = \event\models\Participant::model()->byUserId($user->UserId)->byEventId($event->EventId)->find();
        $participant->UpdateRole($role);
      }
    }
    else
    {
      $participant = $event->RegisterUserOnDay($day, $user, $role);
      if ($participant == null)
      {
        $participant = \event\models\Participant::model()->byUserId($user->UserId)->byEventId($event->EventId)->byDayId($day->DayId)->find();
        $participant->UpdateRole($role);
      }
    }


    echo json_encode(array('error' => false));
  }

  public function actionCoupon()
  {
    $request = \Yii::app()->request;
    $rocId = $request->getParam('rocId');
    $code = $request->getParam('code');


    $user = \user\models\User::GetByRocid($rocId);
    $event = \event\models\Event::GetById(\Yii::app()->partner->getAccount()->EventId);
    if (empty($user) || empty($event) || (!empty($event->Days) && empty($day)))
    {
      echo json_encode(array('error' => true, 'message' => 'Ошибка при сохранении!'));
      return;
    }

    $coupon = \pay\models\Coupon::GetByCode($code);
    if (empty($coupon))
    {
      echo json_encode(array('error' => true, 'message' => 'Промо код не найден!'));
      return;
    }

    try
    {
      $coupon->Activate($user, $user);
    }
    catch (\pay\models\PayException $e)
    {
      echo json_encode(array('error' => true, 'message' => $e->getMessage()));
      return;
    }

    echo json_encode(array('error' => false));
  }
}
