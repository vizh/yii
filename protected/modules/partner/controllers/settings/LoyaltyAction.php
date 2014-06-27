<?php
namespace partner\controllers\settings;

class LoyaltyAction extends \partner\components\Action
{
  private $form;

  public function run()
  {
    $request = \Yii::app()->getRequest();
    $this->form = new \pay\models\forms\LoyaltyProgramDiscount($this->getEvent());
    $this->form->attributes = $request->getParam(get_class($this->form));
    if ($request->getIsPostRequest() && $this->form->validate())
    {
      $this->processForm();
    }

    $action = $request->getParam('action');
    if ($action !== null)
    {
      $method = 'processAction'.ucfirst($action);
      if (method_exists($this, $method))
      {
        $this->$method();
        $this->getController()->redirect(['/partner/settings/loyalty/']);
      }
    }


    $this->getController()->setPageTitle(\Yii::t('app', \Yii::t('app', 'Программа лояльности')));
    $this->getController()->initActiveBottomMenu('loyalty');
    $this->getController()->render('loyalty', ['form' => $this->form, 'discounts' => $this->getDiscounts()]);
  }

  private function getDiscounts()
  {
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."StartTime" ASC, "t"."EndTime" ASC';
    $criteria->with = ['Product'];
    return \pay\models\LoyaltyProgramDiscount::model()->byEventId($this->getEvent()->Id)->findAll($criteria);
  }

  private function processForm()
  {
    $discount = new \pay\models\LoyaltyProgramDiscount();
    $discount->Discount = $this->form->Discount / 100;
    $discount->StartTime = !empty($this->form->StartDate) ? \Yii::app()->getDateFormatter()->format('yyyy-MM-dd 00:00:00', $this->form->StartDate) : null;
    $discount->EndTime = !empty($this->form->EndDate) ? \Yii::app()->getDateFormatter()->format('yyyy-MM-dd 23:59:59', $this->form->EndDate) : null;;
    $discount->ProductId = !empty($this->form->ProductId) ? $this->form->ProductId : null;
    $discount->EventId = $this->getEvent()->Id;
    $discount->save();
    \Yii::app()->getController()->refresh();
  }

  private function processActionDelete()
  {
    $request = \Yii::app()->getRequest();
    $discount = \pay\models\LoyaltyProgramDiscount::model()->byEventId($this->getEvent()->Id)->findByPk($request->getParam('discountId'));
    if ($discount == null)
      throw new \CHttpException(404);

    if ($discount->getStatus() == $discount::StatusActive)
    {
      $discount->EndTime = date('Y-m-d H:i:s');
      $discount->save();
    }
    elseif ($discount->getStatus() == $discount::StatusSoon) {
      $discount->delete();
    }
  }

}
