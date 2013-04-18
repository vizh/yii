<?php
class SettingController extends \application\components\controllers\PublicMainController
{
  public function actions()
  {
    return array(
      'password' => '\user\controllers\setting\PasswordAction',
      'indexing' => '\user\controllers\setting\IndexingAction',
      'subscription' => '\user\controllers\setting\SubscriptionAction'
    );
  }
}
