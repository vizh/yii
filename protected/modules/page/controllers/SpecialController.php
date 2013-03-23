<?php
class SpecialController extends \application\components\controllers\PublicMainController
{
  public function actionChildsafety2013()
  {
    $this->bodyId = 'about-page';
    $this->render('childsafety2013');
  }
}
