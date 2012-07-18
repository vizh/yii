<?php
namespace partner\components;


class Controller extends \application\components\controllers\BaseController
{
  public $layout = '/layouts/public';

  public function filters()
  {
    $filters = parent::filters();
    return array_merge(
      $filters,
      array(
        'checkAccess',
        'checkEventId'
      )
    );
  }

  public function initResources()
  {
    parent::initResources();

    $cs = \Yii::app()->clientScript;
    $manager = \Yii::app()->getAssetManager();

    $cs->registerCssFile($manager->publish(\Yii::PublicPath() . '/css/bootstrap/css/bootstrap.css'));
    $cs->registerCssFile($manager->publish(\Yii::PublicPath() . '/css/partner.css'));

    $cs->registerScriptFile($manager->publish(\Yii::PublicPath() . '/css/bootstrap/js/bootstrap.js', \CClientScript::POS_HEAD));
  }

  /**
   * @param \CFilterChain $filterChain
   */
  public function filterCheckAccess($filterChain)
  {
    if (\Yii::app()->partner->Account() == null
      && $this->getId() != 'auth')
    {
      $this->redirect(\Yii::app()->createUrl('/partner/auth/index'));
    }
    $filterChain->run();
  }

  /**
   * @param \CFilterChain $filterChain
   */
  public function filterCheckEventId($filterChain)
  {
    if (\Yii::app()->partner->Account() != null && \Yii::app()->partner->Account()->Global == 1)
    {
      //todo: если не установлен закрепленный аккаунт - редирект на страницу установки
    }
    $filterChain->run();
  }
}