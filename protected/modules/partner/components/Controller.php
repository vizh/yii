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
        'checkEventId'
      )
    );
  }

  /** @var AccessControlFilter */
  private $accessFilter;
  public function getAccessFilter()
  {
    if (empty($this->accessFilter))
    {
      $this->accessFilter = new AccessControlFilter();
      $this->accessFilter->setRules($this->accessRules());
    }
    return $this->accessFilter;
  }

  public function filterAccessControl($filterChain)
  {
    $this->getAccessFilter()->filter($filterChain);
  }

  public function accessRules()
  {
    $rules = \Yii::getPathOfAlias('partner.rules').'.php';
    return require($rules);
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
  public function filterCheckEventId($filterChain)
  {
    //todo: Проверить на админство, если не установлен закрепленный аккаунт - редирект на страницу установки
    $filterChain->run();
  }

  protected $bottomMenu = array();

  public function initBottomMenu($active)
  {

  }

  public function getBottomMenu()
  {
    return $this->bottomMenu;
  }
}