<?php
use event\models\Participant;

class MergeController extends \application\components\controllers\AdminMainController
{
  /** @var  \user\models\User */
  private $user;

  /** @var  \user\models\User */
  private $userSecond;

  public function actionIndex()
  {
    $this->setPageTitle('Объединение пользователей');

    $request = Yii::app()->getRequest();
    if ($request->getIsPostRequest())
    {
      $runetId = $request->getParam('RunetIdMain');
      $runetIdSecond = $request->getParam('RunetIdSecond');

      $this->user = \user\models\User::model()->byRunetId($runetId)->find();
      $this->userSecond = \user\models\User::model()->byRunetId($runetIdSecond)->find();

      if ($this->user == null || $this->userSecond == null)
      {
        $this->render('init', array(
          'error' => ($this->user == null ? 'main' : 'second'),
          'runetId' => $runetId,
          'runetIdSecond' => $runetIdSecond
        ));
        Yii::app()->end();
      }

      $confirm = $request->getParam('confirm', false);
      if (!$confirm)
      {
        $this->render('check', array('user' => $this->user, 'userSecond' => $this->userSecond));
      }
      else
      {
        $this->merge();
        $this->render('result', array('user' => $this->user));
      }
    }
    else
    {
      $this->render('init');
    }
  }

  private function merge()
  {
    if (empty($this->user->FatherName) && !empty($this->userSecond->FatherName))
    {
      $this->user->FatherName = $this->userSecond->FatherName;
    }
    $this->mergeEmail();
    $this->mergeEmployment();
    $this->mergeAddress();
    $this->mergeContacts();
    $this->mergeEvents();
    $this->mergeFinancial();
    $this->mergeProfessional();
    $this->mergeCommissions();

    $this->userSecond->Visible = false;
    $this->userSecond->save();
  }

  private function mergeCommissions()
  {
    /** @var \commission\models\User[] $linksUserComission */
    $linksUserComission = \commission\models\User::model()->byUserId($this->userSecond->Id)->findAll();
    foreach ($linksUserComission as $link)
    {
      $link->UserId = $this->user->Id;
      $link->save();
    }

    /** @var \commission\models\ProjectUser[] $linksUserProjects */
    $linksUserProjects = \commission\models\ProjectUser::model()->byUserId($this->userSecond->Id)->findAll();
    foreach ($linksUserProjects as $link)
    {
      $link->UserId = $this->user->Id;
      $link->save();
    }
  }

  private function mergeProfessional()
  {
    /** @var \event\models\LinkProfessionalInterest[] $linksUser */
    $linksUser = \user\models\LinkProfessionalInterest::model()
        ->byUserId($this->userSecond->Id)->findAll();

    foreach ($linksUser as $link)
    {
      $model = \user\models\LinkProfessionalInterest::model()
          ->byUserId($this->user->Id)->byProfessionalInterestId($link->ProfessionalInterestId);
      if (!$model->exists())
      {
        $link->UserId = $this->user->Id;
        $link->save();
      }
    }
  }

  private function mergeFinancial()
  {
    $orders = \pay\models\Order::model()->byPayerId($this->userSecond->Id)->findAll();
    foreach ($orders as $order)
    {
      $order->PayerId = $this->user->Id;
      $order->save();
    }

    $orderItems = \pay\models\OrderItem::model()->byPayerId($this->userSecond->Id)->findAll();
    foreach ($orderItems as $item)
    {
      $item->PayerId = $this->user->Id;
      $item->save();
    }

    $orderItems = \pay\models\OrderItem::model()->byOwnerId($this->userSecond->Id)->findAll();
    foreach ($orderItems as $item)
    {
      $item->OwnerId = $this->user->Id;
      $item->save();
    }

    $orderItems = \pay\models\OrderItem::model()->byChangedOwnerId($this->userSecond->Id)->findAll();
    foreach ($orderItems as $item)
    {
      $item->ChangedOwnerId = $this->user->Id;
      $item->save();
    }
    /** @var \pay\models\CouponActivation[] $activations */
    $activations = \pay\models\CouponActivation::model()->byUserId($this->userSecond->Id)->findAll();
    foreach ($activations as $activation)
    {
      $activation->UserId = $this->user->Id;
      $activation->save();
    }
  }

  private function mergeEvents()
  {
    foreach ($this->userSecond->Participants as $participantSecond)
    {
      $flag = false;
      foreach ($this->user->Participants as $participant)
      {
        $flag = $this->mergeParticipants($participant, $participantSecond);
        if ($flag)
        {
          break;
        }
      }

      if (!$flag)
      {
        $participantSecond->UserId = $this->user->Id;
        $participantSecond->save();
      }
    }
    $this->mergeProgram();
  }

  private function mergeProgram()
  {
    /** @var \event\models\section\LinkUser[] $linksUser */
    $linksUser = \event\models\section\LinkUser::model()->byUserId($this->userSecond->Id)->findAll();

    foreach ($linksUser as $link)
    {
      $link->UserId = $this->user->Id;
      $link->save();
    }
  }

  /**
   * @param Participant $primary
   * @param Participant $second
   *
   * @return bool
   */
  private function mergeParticipants(Participant $primary, Participant $second)
  {
    if ($primary->EventId != $second->EventId)
    {
      return false;
    }
    if ($primary->PartId != null && $primary->PartId != $second->PartId)
    {
      return false;
    }

    if ($primary->Role->Priority < $second->Role->Priority)
    {
      $primary->RoleId = $second->RoleId;
      $primary->save();
    }
    return true;
  }

  private function mergeContacts()
  {
    foreach ($this->userSecond->LinkPhones as $link)
    {
      $link->UserId = $this->user->Id;
      $link->save();
    }

    foreach ($this->userSecond->LinkServiceAccounts as $link)
    {
      $link->UserId = $this->user->Id;
      $link->save();
    }

    if ($this->user->getContactSite() === null && $this->userSecond->getContactSite() !== null)
    {
      $this->userSecond->LinkSite->UserId = $this->user->Id;
      $this->userSecond->LinkSite->save();
    }
  }

  private function mergeAddress()
  {
    $address = $this->user->getContactAddress();
    $addressSecond = $this->userSecond->getContactAddress();

    $addressId = (int)Yii::app()->getRequest()->getParam('Address');

    if ($address !== null && ($addressSecond === null || $address->Id == $addressId))
    {
      return;
    }

    if ($address !== null)
    {
      $this->user->LinkAddress->delete();
      $address->delete();
    }

    if ($this->userSecond->LinkAddress !== null)
    {
      $this->userSecond->LinkAddress->UserId = $this->user->Id;
      $this->userSecond->LinkAddress->save();
    }
  }

  private function mergeEmployment()
  {
    $primary = (int)Yii::app()->getRequest()->getParam('EmploymentPrimary');
    $employments = Yii::app()->getRequest()->getParam('Employment');

    foreach ($this->user->Employments as $employment)
    {
      if (in_array($employment->Id, $employments))
      {
        $employment->Primary = $employment->Id == $primary;
        $employment->save();
      }
      else
      {
        $employment->delete();
      }
    }

    foreach ($this->userSecond->Employments as $employment)
    {
      if (in_array($employment->Id, $employments))
      {
        $employment->UserId = $this->user->Id;
        $employment->Primary = $employment->Id == $primary;
        $employment->save();
      }
      else
      {
        $employment->delete();
      }
    }

    \Yii::app()->getDb()->createCommand('SELECT "UpdateEmploymentPrimary"(:UserId)')->execute(array(
      'UserId' => $this->user->Id
    ));
  }

  private function mergeEmail()
  {
    $emailUserId = Yii::app()->getRequest()->getParam('Email');
    if ($this->user->Id == $emailUserId)
    {
      return;
    }

    $email = $this->user->Email;
    $this->user->Email = $this->userSecond->Email;
    $this->userSecond->Email = $email;
    $this->user->save();
    $this->userSecond->save();
  }


}