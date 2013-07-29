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
}