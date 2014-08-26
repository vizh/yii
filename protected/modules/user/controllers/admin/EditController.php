<?php
use user\models\User;

/**
 * Class EditController
 * @property \user\models\forms\admin\Edit $form
 * @property \user\models\User $user
 */
class EditController extends \application\components\controllers\AdminMainController
{
  private $form;
  private $user;

  public function actionIndex($runetId, $backUrl = '')
  {
    $this->user = User::model()->byRunetId($runetId)->find();
    if ($this->user == null)
      throw new \CHttpException(404);

    $this->form = new \user\models\forms\admin\Edit($this->user);
    $request = \Yii::app()->getRequest();
    if ($request->getIsPostRequest())
    {
      $this->form->attributes = $request->getParam(get_class($this->form));
      $this->form->Photo = \CUploadedFile::getInstance($this->form, 'Photo');
        $this->form->validate();

        $updateRunetId = false;
        $newRunetId = (int)$request->getParam('NewRunetId');
        if (!empty($runetId) && $this->user->RunetId != $newRunetId) {
            if (User::model()->byRunetId($newRunetId)->exists()) {
                $this->form->addError('', sprintf('Пользователь с RUNET-ID %s уже существует.', $newRunetId));
            } elseif ($newRunetId > User::model()->find('', ['order' => 't."RunetId" DESC'])->RunetId) {
                $this->form->addError('', sprintf('RUNET-ID %s больше, чем самый большой RUNET-ID в системе.', $newRunetId));
            } else {
                $this->user->RunetId = $newRunetId;
                $updateRunetId = true;
            }
        }
      if (!$this->form->hasErrors())
      {
        $this->processForm();
          if ($updateRunetId) {
              $this->redirect(Yii::app()->createUrl('/user/admin/edit/index', ['runetId' => $newRunetId, 'backUrl' => $backUrl]));
          } else {
              $this->refresh();
          }
      }
    }
    else
    {
      $this->initForm();
    }

    \Yii::app()->getClientScript()->registerPackage('runetid.backbone');
    \Yii::app()->getClientScript()->registerPackage('runetid.jquery.inputmask-multi');
    $this->setPageTitle(\Yii::t('app', 'Редатирование данных пользователя'));
    $this->render('index', ['form' => $this->form, 'user' => $this->user, 'backUrl' => $backUrl]);
  }

  /**
   *
   */
  private function initForm()
  {
    foreach ($this->form->getLocaleList() as $locale)
    {
      $this->user->setLocale($locale);
      $this->form->FirstName[$locale] = $this->user->FirstName;
      $this->form->LastName[$locale] = $this->user->LastName;
      $this->form->FatherName[$locale] = $this->user->FatherName;
    }
    $this->user->resetLocale();

    if ($this->user->getContactAddress() !== null)
    {
      $this->form->Address->setAttributes(
        $this->user->getContactAddress()->getAttributes($this->form->Address->getSafeAttributeNames())
      );
    }

    foreach ($this->user->LinkPhones as $linkPhone)
    {
      $formPhone = new \contact\models\forms\Phone(\contact\models\forms\Phone::ScenarioOneFieldRequired);
      $formPhone->attributes = array(
        'Id' => $linkPhone->PhoneId,
        'OriginalPhone' => $linkPhone->Phone->getWithoutFormatting(),
        'Type'  => $linkPhone->Phone->Type
      );
      $this->form->Phones[] = $formPhone;
    }

    foreach ($this->user->Employments as $employment)
    {
      $formEmployment = new \user\models\forms\Employment();
      $formEmployment->attributes = array(
        'Id' => $employment->Id,
        'Company' => (!empty($employment->Company->FullName) ? $employment->Company->FullName : $employment->Company->Name),
        'Position' => $employment->Position,
        'StartMonth' => $employment->StartMonth,
        'StartYear' => $employment->StartYear,
        'EndMonth' => $employment->EndMonth,
        'EndYear' => $employment->EndYear,
        'Primary' => $employment->Primary ? 1 : 0
      );
      $this->form->Employments[] = $formEmployment;
    }

    $this->form->Visible = $this->user->Visible;
    $this->form->Subscribe = !$this->user->Settings->UnsubscribeAll;
    $this->form->Email = $this->user->Email;
  }


  /**
   *
   */
  private function processForm()
  {
    foreach ($this->form->getLocaleList() as $locale)
    {
      $this->user->setLocale($locale);
      $this->user->FirstName = $this->form->FirstName[$locale];
      $this->user->LastName = $this->form->LastName[$locale];
      if (!empty($this->form->FatherName[$locale]))
      {
        $this->user->FatherName = $this->form->FatherName[$locale];
      }
    }
    $this->user->resetLocale();

    $this->user->Email = $this->form->Email;
    $this->user->Visible = $this->form->Visible == 1 ? true : false;
    $this->user->save();
    $this->user->Settings->UnsubscribeAll = $this->form->Subscribe == 0 ? true : false;
    $this->user->Settings->save();
    if (!empty($this->form->NewPassword))
    {
      $this->user->changePassword($this->form->NewPassword);
    }

    if ($this->form->DeletePhoto == 1)
    {
      $this->user->getPhoto()->delete();
    }

    if ($this->form->Photo !== null)
    {
      $this->user->getPhoto()->SavePhoto($this->form->Photo);
    }

    $address = $this->user->getContactAddress();
    if ($address == null)
    {
      $address = new \contact\models\Address();
    }
    $address->setAttributes($this->form->Address->getAttributes(), false);
    $address->save();
    $this->user->setContactAddress($address);

    $this->processFormPhone();
    $this->processFormEmployment();
    \Yii::app()->getUser()->setFlash('success', \Yii::t('app', 'Данные пользователя успешно сохранены!'));
  }

  /**
   * @throws CHttpException
   */
  private function processFormPhone()
  {
    foreach ($this->form->Phones as $formPhone)
    {
      if (!empty($formPhone->Id))
      {
        $linkPhone = \user\models\LinkPhone::model()->byUserId($this->user->Id)->byPhoneId($formPhone->Id)->find();
        if ($linkPhone == null)
          throw new \CHttpException(500);
        $phone = $linkPhone->Phone;
        if ($formPhone->Delete == 1)
        {
          $linkPhone->delete();
          $phone->delete();
          continue;
        }
      }
      else
      {
        $linkPhone = new \user\models\LinkPhone();
        $linkPhone->UserId = $this->user->Id;
        $phone = new \contact\models\Phone();
      }

      $phone->CountryCode = $formPhone->CountryCode;
      $phone->CityCode = $formPhone->CityCode;
      $phone->Phone = $formPhone->Phone;
      $phone->Type = $formPhone->Type;
      $phone->save();
      $linkPhone->PhoneId = $phone->Id;
      $linkPhone->save();
    }
  }

  /**
   * @throws CHttpException
   */
  private function processFormEmployment()
  {
    foreach ($this->form->Employments as $formEmployment)
    {
      if (!empty($formEmployment->Id))
      {
        $employment = \user\models\Employment::model()->byUserId($this->user->Id)->findByPk($formEmployment->Id);
        if ($employment == null)
          throw new \CHttpException(500);
        if ($formEmployment->Company !== $employment->Company->Name)
        {
          $employment->chageCompany($formEmployment->Company);
        }
      }
      else
      {
        $employment = $this->user->setEmployment($formEmployment->Company, $formEmployment->Position);
      }

      if ($formEmployment->Delete == 1)
      {
        $employment->delete();
      }
      else
      {
        $employment->Position = $formEmployment->Position;
        $employment->StartMonth = !empty($formEmployment->StartMonth) ? $formEmployment->StartMonth : null;
        $employment->EndMonth = !empty($formEmployment->EndMonth) ? $formEmployment->EndMonth : null;
        $employment->StartYear = !empty($formEmployment->StartYear) ? $formEmployment->StartYear : null;
        $employment->EndYear = !empty($formEmployment->EndYear) ? $formEmployment->EndYear : null;
        $employment->Primary = $formEmployment->Primary == 1 && empty($formEmployment->EndYear) ? true : false;
        $employment->save();
      }
    }

    \Yii::app()->getDb()->createCommand('SELECT "UpdateEmploymentPrimary"(:UserId)')->execute(array(
      'UserId' => $this->user->Id
    ));
  }
} 