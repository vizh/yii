<?php


class AuthController extends ruvents\components\Controller
{

  public function actionLogin()
  {
    $request = \Yii::app()->getRequest();
    $login = $request->getParam('Login', null);
    $password = $request->getParam('Password', null);
    $masterPassword = $request->getParam('MasterPassword', null);

    /** @var $operator \ruvents\models\Operator */
    $operator = \ruvents\models\Operator::model()->byLogin($login)->find();
    if ($operator == null || \ruvents\models\Operator::GeneratePasswordHash($password) !== $operator->Password)
    {
      throw new \ruvents\components\Exception(101);
    }

    $masterPassword = \ruvents\models\Operator::GeneratePasswordHash($masterPassword);
    /** @var $masters \ruvents\models\Operator[] */
    $masters = \ruvents\models\Operator::model()->byPassword($masterPassword)->findAll();

    $hasAccess = false;
    foreach ($masters as $master)
    {
      if ($master->Role == \ruvents\models\Operator::RoleAdmin && $master->EventId == $operator->EventId)
      {
        $hasAccess = true;
        break;
      }
    }

    if ($hasAccess)
    {
      $operator->LastLoginTime = date('Y-m-d H:i:s');
      $operator->save();

      $response = new stdClass();
      $response->OperatorId = $_POST['OperatorId'] = $operator->Id;
      $response->Hash = $_POST['Hash'] = $operator->getAuthHash();
      \ruvents\components\WebUser::Instance()->resetOperator();
      $response->Event = $this->getDataBuilder()->createEvent();

      echo json_encode($response);
    }
    else
    {
      throw new \ruvents\components\Exception(102);
    }
  }
}