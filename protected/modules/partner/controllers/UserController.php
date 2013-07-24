<?php


class UserController extends \partner\components\Controller
{
  const UsersOnPage = 20;

  public function actions()
  {
    return array(
      'index' => '\partner\controllers\user\IndexAction',
      'edit' => '\partner\controllers\user\EditAction',
      'translate' => '\partner\controllers\user\TranslateAction',
      'ajaxget' => '\partner\controllers\user\AjaxGetAction',
      'register' => '\partner\controllers\user\RegisterAction',
      'statistics' => '\partner\controllers\user\StatisticsAction',
      'export' => '\partner\controllers\user\ExportAction',
      'invite' => '\partner\controllers\user\InviteAction',
        
      'import' => '\partner\controllers\user\import\IndexAction',
      'importmap' => '\partner\controllers\user\import\MapAction',
      'importroles' => '\partner\controllers\user\import\RolesAction',
      'importprocess' => '\partner\controllers\user\import\ProcessAction',
      'importerrors' => '\partner\controllers\user\import\ErrorsAction',
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
      ),
      'import' => array(
        'Title' => 'Импорт участников из CSV',
        'Url' => \Yii::app()->createUrl('partner/user/import'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'user', 'import')
      ),
      'invite' => array(
        'Title' => 'Приглашения',
        'Url' => \Yii::app()->createUrl('/partner/user/invite'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'user', 'invite') 
            && \event\models\Widget::model()->byEventId(\Yii::app()->partner->getEvent()->Id)->byName('event\widgets\Invite')->exists()
      ),
    );
  }
}
