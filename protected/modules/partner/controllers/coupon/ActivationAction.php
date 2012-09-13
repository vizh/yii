<?php
namespace partner\controllers\coupon;

class ActivationAction extends \partner\components\Action
{
  public $error;
  public $success;

  public function run()
  {
    $this->getController()->setPageTitle('Активация промо-кода');
    $this->getController()->initBottomMenu('activation');

    $cs = \Yii::app()->clientScript;
    $cs->registerScriptFile(\Yii::app()->getAssetManager()->publish(\Yii::PublicPath() . '/js/libs/jquery-ui-1.8.16.custom.min.js'), \CClientScript::POS_HEAD);

    $blitzerPath = \Yii::app()->getAssetManager()->publish(\Yii::PublicPath() . '/css/blitzer');
    $cs->registerCssFile($blitzerPath . '/jquery-ui-1.8.16.custom.css');
    $cs->registerScriptFile(\Yii::app()->getAssetManager()->publish(\Yii::PublicPath() . '/js/partner/user.edit.js'), \CClientScript::POS_HEAD);

    $request = \Yii::app()->request;
    $activation = $request->getParam('Activation');
    if ( isset ($activation))
    {
      $coupon = \pay\models\Coupon::GetByCode($activation['Coupon']);

      if ($coupon != null && $coupon->EventId == \Yii::app()->partner->getAccount()->EventId)
      {
        $user = \user\models\User::GetByRocid($activation['RocId']);
        if ($user != null)
        {
          try {
            $coupon->Activate($user, $user);
          }
          catch (\Exception $e)
          {
            $this->error = $e->getMessage();
          }
          $this->success = 'Купон '. $coupon->Code .' успешно активирован на пользователя: '. $user->GetFullName();
        }
        else
        {
          $this->error = 'Не удалось найти пользователя с rocID: '. intval($activation['RocId']) .'. Убедитесь, что все данные указаны правильно. ';
        }
      }
      else
      {
        $this->error = 'Не удалось найти промо-код "'. $activation['Coupon'] .'". Убедитесь что код введен верно.';
      }
    }

    $this->getController()->render('activation',
      array(
        'activation' => $activation
      )
    );
  }
}