<?php

class MergeController extends \application\components\controllers\AdminMainController
{
  /** @var \company\models\Company */
  private $company;

  /** @var  \company\models\Company[] */
  private $companies;

  public function actionIndex()
  {
    $this->setPageTitle('Объединение компаний');

    $request = Yii::app()->getRequest();
    if ($request->getIsPostRequest())
    {
      $companyId = $request->getParam('CompanyIdMain');
      $companyIdSecond = $request->getParam('CompanyIdSecond');
      $idList = preg_split('/[ ,]/', $companyIdSecond, -1, PREG_SPLIT_NO_EMPTY);

      $this->company = \company\models\Company::model()->findByPk($companyId);

      $criteria = new CDbCriteria();
      $criteria->addInCondition('"t"."Id"', $idList);
      $this->companies = \company\models\Company::model()->findAll($criteria);

      if ($this->company == null || sizeof($this->companies) == 0)
      {
        $this->render('init', array(
          'error' => ($this->company == null ? 'main' : 'second'),
          'companyId' => $companyId,
          'companyIdSecond' => $companyIdSecond
        ));
        Yii::app()->end();
      }

      $confirm = $request->getParam('confirm', false);
      if (!$confirm)
      {
        $this->render('check', [
          'company' => $this->company,
          'companies' => $this->companies,
          'companyId' => $companyId,
          'companyIdSecond' => $companyIdSecond
        ]);
      }
      else
      {
        foreach ($this->companies as $company)
        {
          $this->merge($this->company, $company);
        }
        $this->render('done', array('company' => $this->company));
      }
    }
    else
    {
      $this->render('init');
    }
  }

  private function merge(\company\models\Company $to, \company\models\Company $from)
  {
    foreach ($from->EmploymentsAllWithInvisible as $employment)
    {
      $employment->CompanyId = $to->Id;
      $employment->save();
    }
    $this->mergeEmails($to, $from);
    $this->mergeAddress($to, $from);
    $this->mergePhones($to, $from);
    $this->mergeSite($to, $from);

    foreach ($from->LinkModerators as $link)
    {
      $link->delete();
    }

    /** @var $catalogItems \catalog\models\company\Company[] */
    $catalogItems = \catalog\models\company\Company::model()->byCompanyId($from->Id)->findAll();
    foreach ($catalogItems as $item)
    {
      $item->CompanyId = $to->Id;
      $item->save();
    }

    $from->delete();
    $to->refresh();
  }

  private function mergeEmails(\company\models\Company $to, \company\models\Company $from)
  {
    $emails = [];
    foreach ($to->LinkEmails as $link)
    {
      $emails[] = trim(mb_strtolower($link->Email->Email, 'utf8'));
    }
    foreach ($from->LinkEmails as $link)
    {
      $email = trim(mb_strtolower($link->Email->Email, 'utf8'));
      if (!in_array($email, $emails))
      {
        $link->CompanyId = $to->Id;
        $link->save();
      }
      else
      {
        $oldEmail = $link->Email;
        $link->delete();
        $oldEmail->delete();
      }
    }
  }

  private function mergePhones(\company\models\Company $to, \company\models\Company $from)
  {
    $phones = [];
    foreach ($to->LinkPhones as $link)
    {
      $phones[] = $link->Phone->__toString();
    }
    foreach ($from->LinkPhones as $link)
    {
      $phone = $link->Phone->__toString();
      if (!in_array($phone, $phones))
      {
        $link->CompanyId = $to->Id;
        $link->save();
      }
      else
      {
        $oldPhone = $link->Phone;
        $link->delete();
        $oldPhone->delete();
      }
    }
  }

  private function mergeAddress(\company\models\Company $to, \company\models\Company $from)
  {
    if (!empty($from->LinkAddress))
    {
      if (empty($to->LinkAddress))
      {
        $from->LinkAddress->CompanyId = $to->Id;
        $from->LinkAddress->save();
      }
      else
      {
        $oldAddress = $from->LinkAddress->Address;
        $from->LinkAddress->delete();
        $oldAddress->delete();
      }
    }
  }

  private function mergeSite(\company\models\Company $to, \company\models\Company $from)
  {
    if (!empty($from->LinkSite))
    {
      if (empty($to->LinkSite))
      {
        $from->LinkSite->CompanyId = $to->Id;
        $from->LinkSite->save();
      }
      else
      {
        $oldSite = $from->LinkSite->Site;
        $from->LinkSite->delete();
        $oldSite->delete();
      }
    }
  }
}