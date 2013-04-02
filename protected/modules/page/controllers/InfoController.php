<?php
class InfoController extends \application\components\controllers\PublicMainController
{
  public function actionAbout()
  {
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
}
