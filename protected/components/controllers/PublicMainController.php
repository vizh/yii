<?php
namespace application\components\controllers;

class PublicMainController extends MainController
{
  public $layout = '//layouts/public';
  public $bodyId = 'index-page';

  public function filters()
  {
    $filters = parent::filters();
    return array_merge(
      $filters,
      array(
        'setLanguage'
      )
    );
  }

  /**
   * @param \CFilterChain $filterChain
   */
  public function filterSetLanguage($filterChain)
  {
    $this->setLanguage();
    $filterChain->run();
  }

  protected function setLanguage()
  {
    $langRequest = \Yii::app()->getRequest()->getParam('lang');
    $langRequest = in_array($langRequest, \Yii::app()->params['Languages']) ? $langRequest : null;
    if ($langRequest !== null)
    {
      $cookie = new \CHttpCookie('lang', $langRequest, array('expire' => time()+180*24*60*60));
      \application\components\Cookie::Set($cookie);
      unset($_GET['lang']);
      $this->redirect($this->createUrl('/'.$this->route, $_GET));
    }
    $langCookie = isset(\Yii::app()->getRequest()->cookies['lang']) ? \Yii::app()->getRequest()->cookies['lang']->value : null;
    if ($langCookie !== null && in_array($langCookie, \Yii::app()->params['Languages']))
    {
      \Yii::app()->setLanguage($langCookie);
    }
  }


  protected function initResources()
  {
    parent::initResources();

    \Yii::app()->getClientScript()->registerPackage('runetid.application');
  }
}
