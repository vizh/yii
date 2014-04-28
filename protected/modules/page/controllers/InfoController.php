<?php
class InfoController extends \application\components\controllers\PublicMainController
{
  public $navbar = null;

  public function actionAbout()
  {
    $this->setPageTitle(\Yii::t('app', 'О проекте'));
    $this->bodyId = 'about-page';
    $this->render('about');
  }
  public function actionAdv()
  {
    $this->bodyId = 'about-page';
    $this->render('adv');
  }
  public function actionAgreement()
  {
    $this->bodyId = 'about-page';
    $this->render('agreement');
  }
  public function actionContacts()
  {
    $this->bodyId = 'about-page';
    $this->render('contacts');
  }
  public function actionDelivery()
  {
    $this->bodyId = 'about-page';
    $this->render('delivery');
  }
  public function actionPay()
  {
    $this->bodyId = 'about-page';
    $this->render('pay');
  }
  public function actionPayback()
  {
    $this->bodyId = 'about-page';
    $this->render('payback');
  }
  public function actionFeatures()
  {
    Yii::app()->getClientScript()->registerCssFile('/stylesheets/features.css');

    Yii::app()->disableOutputLoggers();
    $this->bodyId = 'features-page';
    $this->navbar = $this->renderPartial('features-navbar', [], true);
    $this->setPageTitle(\Yii::t('app', 'Услуги и преимущества'));
    $this->render('features');
  }
}
