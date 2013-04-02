<?php
class EditController extends \application\components\controllers\PublicMainController
{
  public function actions()
  {
    return array(
      'index' => 'user\controllers\edit\IndexAction',
      'photo' => 'user\controllers\edit\PhotoAction',
      'employment' => 'user\controllers\edit\EmploymentAction',
      'contacts' => '\user\controllers\edit\ContactsAction'
    );
  }
}
