<?php


class UserController extends \partner\components\Controller
{
  const UsersOnPage = 20;

  public function actions()
  {
    return array(
      'index' => '\partner\controllers\user\IndexAction',
      'edit' => '\partner\controllers\user\EditAction',
      'ajaxget' => '\partner\controllers\user\AjaxGetAction',
      'register' => '\partner\controllers\user\RegisterAction',
      'statistics' => '\partner\controllers\user\StatisticsAction',
      'export' => '\partner\controllers\user\ExportAction'
    );
  }

  public function initBottomMenu()
  {
    $this->bottomMenu = array(
      'index' => array(
        'Title' => 'Участники',
        'Url' => \Yii::app()->createUrl('/partner/user/index'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'user', 'index')
      ),
      'edit' => array(
        'Title' => 'Редактирование',
        'Url' => \Yii::app()->createUrl('/partner/user/edit'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'user', 'edit')
      ),
      'register' => array(
        'Title' => 'Регистрация',
        'Url' => \Yii::app()->createUrl('partner/user/register'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'user', 'register')
      ),
      'statistics' => array(
        'Title' => 'Статистика регистраций',
        'Url' => \Yii::app()->createUrl('partner/user/statistics'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'user', 'statistics')
      ),
      'export' => array(
        'Title' => 'Экспорт участников в CSV',
        'Url' => \Yii::app()->createUrl('partner/user/export'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'user', 'export')
      )
    );
  }
}
