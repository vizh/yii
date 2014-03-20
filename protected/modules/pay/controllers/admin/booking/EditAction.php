<?php
namespace pay\controllers\admin\booking;

class EditAction extends \CAction
{
  /** @var  \pay\models\Product */
  private $product;

  public function run($productId)
  {
    $this->product = \pay\models\Product::model()->findByPk($productId);
    if ($this->product == null || $this->product->ManagerName != 'RoomProductManager')
      throw new \CHttpException(404);

    $formNewPartner = $this->parseNewPartner();
    $partnerErrorForms = $this->parseSavePartners();

    $formNewUser = $this->parseNewUser();
    $userErrorForms = $this->parseSaveUsers();


    $partnerBooking = \pay\models\RoomPartnerBooking::model()
      ->byProductId($this->product->Id)->byDeleted(false)->findAll(['order' => 't."Paid" DESC']);

    $orderItems = \pay\models\OrderItem::model()
      ->byProductId($this->product->Id)->byDeleted(false)
      ->findAll(['order' => 't."Paid" DESC, t."Id"']);



    $this->getController()->render('edit', [
      'product' => $this->product,
      'partnerBooking' => $partnerBooking,
      'formNewPartner' => $formNewPartner,
      'partnerNames' => $this->getPartnerNames(),
      'partnerErrorForms' => $partnerErrorForms,
      'formNewUser' => $formNewUser,
      'userErrorForms' => $userErrorForms,
      'orderItems' => $orderItems,
    ]);
  }



  private function parseNewPartner()
  {
    $request = \Yii::app()->getRequest();
    $formNewPartner = new \pay\models\forms\admin\PartnerBooking($this->product);
    if ($request->getParam('createPartner') != null)
    {
      $formNewPartner->setAttributes($request->getParam('partnerNewData'));
      if ($formNewPartner->validate())
      {
        $newPartnerBooking = new \pay\models\RoomPartnerBooking();
        $newPartnerBooking->ProductId = $this->product->Id;
        $newPartnerBooking->Owner = $formNewPartner->Owner;
        $newPartnerBooking->DateIn = $formNewPartner->DateIn;
        $newPartnerBooking->DateOut = $formNewPartner->DateOut;
        $newPartnerBooking->AdditionalCount = (int)$formNewPartner->AdditionalCount;
        $newPartnerBooking->save();

        $this->getController()->refresh();
      }
    }
    return $formNewPartner;
  }

  private function parseSavePartners()
  {
    $partnerErrorForms = [];
    $request = \Yii::app()->getRequest();
    if ($request->getParam('savePartners') != null)
    {
      $partnerData = $request->getParam('partnerData');
      foreach ($partnerData as $key => $data)
      {
        /** @var \pay\models\RoomPartnerBooking $partnerBooking */
        $partnerBooking = \pay\models\RoomPartnerBooking::model()->findByPk($key);
        if ($partnerBooking != null && !$partnerBooking->Paid)
        {
          $form = new \pay\models\forms\admin\PartnerBooking($this->product);
          $form->setAttributes($data);
          $form->Owner = $partnerBooking->Owner;
          if ($form->validate())
          {
            $partnerBooking->DateIn = $form->DateIn;
            $partnerBooking->DateOut = $form->DateOut;
            $partnerBooking->Paid = $form->Paid == 1;
            $partnerBooking->AdditionalCount = (int)$form->AdditionalCount;
            $partnerBooking->save();
          }
          else
          {
            $partnerErrorForms[] = $form;
          }
        }
      }
    }
    return $partnerErrorForms;
  }

  private function parseNewUser()
  {
    $request = \Yii::app()->getRequest();
    $formNewUser = new \pay\models\forms\admin\UserBooking();
    if ($request->getParam('createUser') != null)
    {
      $formNewUser->setAttributes($request->getParam('userNewData'));
      if ($formNewUser->validate())
      {
        $orderItem = new \pay\models\OrderItem();
        $orderItem->PayerId = $formNewUser->getUser()->Id;
        $orderItem->OwnerId = $formNewUser->getUser()->Id;
        $orderItem->ProductId = $this->product->Id;
        $orderItem->Booked = $formNewUser->Booked . ' 22:59:59';
        $orderItem->save();

        $orderItem->setItemAttribute('DateIn', $formNewUser->DateIn);
        $orderItem->setItemAttribute('DateOut', $formNewUser->DateOut);
        $this->getController()->refresh();
      }
    }
    return $formNewUser;
  }

  private function parseSaveUsers()
  {
    $userErrorForms = [];
    $request = \Yii::app()->getRequest();
    if ($request->getParam('saveUsers') != null)
    {
      $userData = $request->getParam('userData');
      foreach ($userData as $key => $data)
      {
        $orderItem = \pay\models\OrderItem::model()->findByPk($key);
        if ($orderItem != null && !$orderItem->Paid)
        {
          $form = new \pay\models\forms\admin\UserBooking();
          $form->setAttributes($data);
          $form->RunetId = $orderItem->Payer->RunetId;
          if ($form->validate())
          {
            $orderItem->setItemAttribute('DateIn', $form->DateIn);
            $orderItem->setItemAttribute('DateOut', $form->DateOut);

            $orderItem->Booked = $form->Booked . ' 22:59:59';
            $orderItem->save();
          }
          else
          {
            $userErrorForms[] = $form;
          }
        }
      }
    }
    return $userErrorForms;
  }

  private function getPartnerNames()
  {
    $result = \Yii::app()->getDb()->createCommand()
      ->select('Owner')->from('PayRoomPartnerBooking')
      ->group('Owner')->order('Owner')->queryAll();

    $partnerNames = [];
    foreach ($result as $row)
    {
      $partnerNames[] = $row['Owner'];
    }
    return $partnerNames;
  }

} 