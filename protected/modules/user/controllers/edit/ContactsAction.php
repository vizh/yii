<?php
namespace user\controllers\edit;

class ContactsAction extends \CAction
{
  public function run()
  {
    $user = \Yii::app()->user->getCurrentUser();
    $request = \Yii::app()->getRequest();
    $form = new \user\models\forms\edit\Contacts();
    $this->getController()->render('contacts', array('form' => $form, 'user' => $user));
  }
}
