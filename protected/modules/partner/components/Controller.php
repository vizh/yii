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
        'accessControl',
        'checkAccess',
        'checkEventId'
      )
    );
  }

  public function filterAccessControl($filterChain)
  {
    $filter = new AccessControlFilter();
    $filter->setRules($this->accessRules());
    $filter->filter($filterChain);
  }

  public function accessRules()
  {
    return array(
      array(
        'deny',
        'users' => array('*')
      ),
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
    if (\Yii::app()->partner->getAccount() == null
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
    if (\Yii::app()->partner->getAccount() != null && \Yii::app()->partner->getAccount()->Global == 1)
    {
      //todo: если не установлен закрепленный аккаунт - редирект на страницу установки
    }
    $filterChain->run();
  }
}