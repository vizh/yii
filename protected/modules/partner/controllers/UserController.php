<?php
use application\modules\partner\models\search\Competence as CompetenceSearch;
use competence\models\Test;
use event\models\InviteRequest;

class UserController extends \partner\components\Controller
{
    const UsersOnPage = 20;

    public function actions()
    {
        return [
            'index' => '\partner\controllers\user\IndexAction',
            'edit' => '\partner\controllers\user\EditAction',
            'viewdatafile' => '\partner\controllers\user\ViewDataFileAction',
            'translate' => '\partner\controllers\user\TranslateAction',
            'ajaxget' => '\partner\controllers\user\AjaxGetAction',
            'register' => '\partner\controllers\user\RegisterAction',
            'statistics' => '\partner\controllers\user\StatisticsAction',
            'export' => '\partner\controllers\user\ExportAction',
            'invite' => '\partner\controllers\user\InviteAction',
            'import' => '\partner\controllers\user\import\IndexAction',
            'importmap' => '\partner\controllers\user\import\MapAction',
            'importroles' => '\partner\controllers\user\import\RolesAction',
            'importproducts' => '\partner\controllers\user\import\ProductsAction',
            'importprocess' => '\partner\controllers\user\import\ProcessAction',
            'importerrors' => '\partner\controllers\user\import\ErrorsAction',
            'competence' => '\partner\controllers\user\CompetenceAction'
        ];
    }

    public function initBottomMenu()
    {
        $event = \Yii::app()->partner->getEvent();
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
                'Title' => 'Импорт участников',
                'Url' => \Yii::app()->createUrl('partner/user/import'),
                'Access' => $this->getAccessFilter()->checkAccess('partner', 'user', 'import')
            ),
            'invite' => array(
                'Title' => 'Приглашения',
                'Url' => \Yii::app()->createUrl('/partner/user/invite'),
                'Access' => $this->getAccessFilter()->checkAccess('partner', 'user', 'invite') && InviteRequest::model()->byEventId($event->Id)->exists()
            ),
            'competence' => [
                'Title' => 'Опрос участников',
                'Url' => \Yii::app()->createUrl('/partner/user/competence'),
                'Access' => $this->getAccessFilter()->checkAccess('partner', 'user', 'competence') && Test::model()->byEventId($event->Id)->exists()
            ]
        );
    }
}
