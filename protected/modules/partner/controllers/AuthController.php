<?php
class AuthController extends partner\components\Controller
{
  public function actionIndex ()
  {
    $this->setPageTitle('Страница авторизации');

    $this->render('index');
  }
}