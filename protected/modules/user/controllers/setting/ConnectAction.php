<?php
namespace user\controllers\setting;

class ConnectAction extends \CAction
{
  public function run()
  {
    $user = \Yii::app()->user->getCurrentUser(); 
    $connects = array(
      \oauth\components\social\ISocial::Facebook  => false,
      \oauth\components\social\ISocial::Vkontakte => false,
      \oauth\components\social\ISocial::Twitter   => false
    );
    
    $oauthSocialConnects = \oauth\models\Social::model()->byUserId($user->Id)->findAll();
    foreach ($oauthSocialConnects as $oauthSocialConnect)
    {
      $connects[$oauthSocialConnect->SocialId] = true;
    }
    $this->getController()->render('connect', array('connects' => $connects));
  }
}
