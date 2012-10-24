<?php
class MainController extends \register\components\Controller
{
  private $event = null;
  private $products = null;
      
  protected function beforeAction($action) 
  {
    $eventId = \Yii::app()->request->getParam('eventId');
    $this->event = \event\models\Event::GetById($eventId);
    if ($this->event == null)
    {
      throw new CHttpException(404);
    }
    
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params['EventId'] = $this->event->EventId;
    $this->products = \pay\models\Product::model()->findAll($criteria);    
    return parent::beforeAction($action);
  }


  public function actionSelect()
  {
    $request = \Yii::app()->getRequest();
    $orderForm = new \register\components\form\OrderForm();
    $orderForm->attributes = $request->getParam(get_class($orderForm));
    if ($request->getIsPostRequest()
      && $orderForm->validate())
    {
      \Yii::app()->session['order_form'] = $orderForm->attributes;
      $this->redirect(
        $this->createUrl('/register/main/owners', array('eventId' => $this->event->EventId))
      );
    }
    
    $this->render('select', array(
      'products'  => $this->products, 
      'event'     => $this->event, 
      'orderForm' => $orderForm
    ));
  }
  
  
  public function actionOwners()
  {
    $request = Yii::app()->getRequest();
    $orderForm = new \register\components\form\OrderForm();
    if (isset(\Yii::app()->session['order_form']))
    {
      $orderForm->attributes = \Yii::app()->session['order_form'];
    }
    
    
    
    
  
    $this->render('owners', 
      array(
        'products' => $this->products, 
        'event' => $this->event, 
        'orderForm' => $orderForm,
        'registerForm' => new \register\components\form\RegisterForm()
      )
    );
  }
  
  public function actionAjaxUserSearch($query)
  {
    
  }


  public function actionAjaxRegister()
  {
    $request = \Yii::app()->getRequest();
    $registerForm = new \register\components\form\RegisterForm();
    $registerForm->attributes = $request->getParam(get_class($registerForm));
    
    $result = new \stdClass();
    if ($request->getIsPostRequest())
    {
      $registerForm->attributes = $request->getParam(get_class($registerForm));
      $registerForm->Password = substr(md5(mt_rand().microtime()), 0, 8);
      if ($registerForm->validate())
      {
        $user = new user\models\User();
        $user->attributes = $registerForm->attributes;
        $user->Register();
        if (!empty($registerForm->Company))
        {
          $user->addEmployment($registerForm->Company, $registerForm->Position);
        }
        $result->Success  = true;
        $result->FullName = $user->GetFullName();
        $result->UserId   = $user->UserId;
        $result->RunetId  = $user->RocId;
      }
      else
      {
        $result->Success  = false;
        $result->ErrorMsg = $registerForm->getErrors(); 
      }
    }    
    echo json_encode($result);
  }
}
