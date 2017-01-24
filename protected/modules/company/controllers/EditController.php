<?php
class EditController extends \application\components\controllers\PublicMainController
{
  private $company;

  public function actionIndex($companyId)
  {
    $this->company = \company\models\Company::model()->findByPk($companyId);
    if ($this->company == null)
      throw new \CHttpException(404);

    $giveAccess = \company\models\LinkModerator::model()
      ->byUserId(\Yii::app()->getUser()->getId())->byCompanyId($companyId)->exists();
    if (!$giveAccess)
      throw new \CHttpException(404);


    $form = new \company\models\form\Edit();
    $request = \Yii::app()->getRequest();
    if ($request->getIsPostRequest())
    {
      $form->attributes = $request->getParam(get_class($form));
      $form->Logo = \CUploadedFile::getInstance($form, 'Logo');
      if ($form->validate())
      {
        $this->company->Name = $form->Name;
        $this->company->FullName = $form->FullName;
        $this->company->FullInfo = $form->FullInfo;
        $this->company->OGRN = $form->OGRN;
        $this->company->save();
        if ($form->Logo !== null)
        {
          $this->company->getLogo()->upload($form->Logo);
        }

        if (!empty($form->Site))
        {
          $this->company->setContactSite($form->Site);
        }

        $this->savePhones($form);
        $this->saveEmails($form);
        $this->saveAddress($form);
        \Yii::app()->user->setFlash('success', 'Информация о компании успешно сохранена');
        $this->refresh();
      }
    }
    else
    {
      $form->Name = $this->company->Name;
      $form->FullName = $this->company->FullName;
      $form->FullInfo = $this->company->FullInfo;

      if ($this->company->getContactSite() !== null)
      {
        $form->Site = (string) $this->company->getContactSite();
      }

      foreach ($this->company->LinkPhones as $linkPhone)
      {
        $phone = new \contact\models\forms\Phone(\contact\models\forms\Phone::ScenarioOneFieldRequired);
        $phone->attributes = array(
          'Id' => $linkPhone->PhoneId,
          'OriginalPhone' => $linkPhone->Phone->getWithoutFormatting(),
        );
        $form->Phones[] = $phone;
      }

      foreach ($this->company->LinkEmails as $linkEmail)
      {
        $email = new \contact\models\forms\Email();
        $email->attributes = array(
          'Id'    => $linkEmail->EmailId,
          'Email' => $linkEmail->Email->Email,
          'Title' => $linkEmail->Email->Title,
        );
        $form->Emails[] = $email;
      }

      if ($this->company->getContactAddress() !== null)
      {
        $form->Address->attributes = $this->company->getContactAddress()->attributes;
      }
    }
    \Yii::app()->getClientScript()->registerPackage('runetid.ckeditor');
    \Yii::app()->getClientScript()->registerPackage('runetid.jquery.inputmask-multi');
    $this->setPageTitle(\Yii::t('app', 'Редактирование компании'));
    $this->render('index', array('form' => $form, 'company' => $this->company));
  }


  private function savePhones(\company\models\form\Edit $form)
  {
    foreach ($form->Phones as $formPhone)
    {
      if (!empty($formPhone->Id))
      {
        $linkPhone = \company\models\LinkPhone::model()->byCompanyId($this->company->Id)->byPhoneId($formPhone->Id)->find();
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
        $linkPhone = new \company\models\LinkPhone();
        $linkPhone->CompanyId = $this->company->Id;
        $phone = new \contact\models\Phone();
      }
      $phone->CountryCode = $formPhone->CountryCode;
      $phone->CityCode = $formPhone->CityCode;
      $phone->Phone = $formPhone->Phone;
      $phone->Type = \contact\models\PhoneType::WORK;
      $phone->save();
      $linkPhone->PhoneId = $phone->Id;
      $linkPhone->save();
    }
  }


  private function saveEmails(\company\models\form\Edit $form)
  {
    foreach ($form->Emails as $formEmail)
    {
      if (!empty($formEmail->Id))
      {
        $linkEmail = \company\models\LinkEmail::model()->byCompanyId($this->company->Id)->byEmailId($formEmail->Id)->find();
        if ($linkEmail == null)
          throw new \CHttpException(500);
        $email = $linkEmail->Email;
        if ($formEmail->Delete == 1)
        {
          $linkEmail->delete();
          $email->delete();
          continue;
        }
      }
      else
      {
        $linkEmail = new \company\models\LinkEmail();
        $linkEmail->CompanyId = $this->company->Id;
        $email = new \contact\models\Email();
      }
      $email->Email = $formEmail->Email;
      $email->Title = $formEmail->Title;
      $email->save();
      $linkEmail->EmailId = $email->Id;
      $linkEmail->save();
    }
  }


  private function saveAddress(\company\models\form\Edit $form)
  {
    $address = $this->company->getContactAddress();
    if (!$form->Address->getIsEmpty() || $address !== null)
    {
      if ($address == null)
      {
        $address = new \contact\models\Address();
      }
      $address->RegionId = $form->Address->RegionId;
      $address->CountryId = $form->Address->CountryId;
      $address->CityId = $form->Address->CityId;
      $address->Street = $form->Address->Street;
      $address->House = $form->Address->House;
      $address->Building = $form->Address->Building;
      $address->Wing = $form->Address->Wing;
      $address->save();
      $this->company->setContactAddress($address);
    }
  }
}
