<?php
class ProgramController extends \partner\components\Controller
{
  public function actionIndex()
  {
    $this->render('index');
  }
  
  public function actions()
  {
    return array(
      'section' => '\partner\controllers\program\SectionAction'
    );
  }
}
