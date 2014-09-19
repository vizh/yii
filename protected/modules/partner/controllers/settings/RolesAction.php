<?php
namespace partner\controllers\settings;

use event\models\LinkRole;
use event\models\Role;

class RolesAction extends \partner\components\Action
{
    private $roles;

    public function run()
    {
        if (\Yii::app()->getRequest()->getIsAjaxRequest())
        {
            $this->processAjaxAction();
        }
        $this->roles = $this->getEvent()->getRoles();
        $this->getController()->initActiveBottomMenu('roles');
        $this->getController()->setPageTitle(\Yii::t('app', 'Статусы мероприятия'));
        \Yii::app()->getClientScript()->registerPackage('runetid.jquery.colpick');
        $this->getController()->render('roles', []);
    }

    private $_canDeleteRoleIdList = null;
    /**
     * @return int[]
     */
    private function getCanDeleteRoleIdList()
    {
        if ($this->_canDeleteRoleIdList == null)
        {
            $this->_canDeleteRoleIdList = [];
            $links = LinkRole::model()->byEventId($this->getEvent()->Id)->findAll();
            foreach ($links as $link)
            {
                $exists = \event\models\Participant::model()->byRoleId($link->RoleId)->byEventId($this->getEvent()->Id)->exists();
                if (!$exists && !$link->Role->Base)
                {
                    $this->_canDeleteRoleIdList[] = $link->RoleId;
                }
            }
        }
        return $this->_canDeleteRoleIdList;
    }


    private function processAjaxAction()
    {
        $request = \Yii::app()->getRequest();
        $action = $request->getParam('Action');
        $handlers = [
            'link'     => 'processAjaxLinkAction',
            'create'   => 'processAjaxCreateAction',
            'delete'   => 'processAjaxDeleteAction',
            'list'     => 'processAjaxListAction',
            'search'   => 'processAjaxSearchAction',
            'setcolor' => 'processAjaxSetColorAction'
        ];
        if ($action !== null && isset($handlers[$action]))
        {
            $this->$handlers[$action]();
            \Yii::app()->end();
        }
        else
            throw new \CHttpException(404);
    }

    /**
     * @throws \CHttpException
     */
    private function processAjaxLinkAction()
    {
        $request = \Yii::app()->getRequest();
        $role = \event\models\Role::model()->findByPk($request->getParam('RoleId'));
        if ($role == null)
            throw new \CHttpException(404);

        $link = new \event\models\LinkRole();
        $link->EventId = $this->getEvent()->Id;
        $link->RoleId = $role->Id;
        $link->save();
        echo json_encode(['success' => true]);
    }

    /**
     * @throws \CHttpException
     */
    private function processAjaxCreateAction()
    {
        $request = \Yii::app()->getRequest();
        $title = $request->getParam('RoleTitle', '');
        $title = trim($title);
        if (strlen($title) == 0)
            throw new \CHttpException(404);

        $translite = new \ext\translator\Translite();
        $role = new \event\models\Role();
        $role->Title = $title;
        $role->Code = $translite->translit($title);
        $role->save();

        $link = new \event\models\LinkRole();
        $link->EventId = $this->getEvent()->Id;
        $link->RoleId = $role->Id;
        $link->save();
        echo json_encode(['success' => true]);
    }

    /**
     * @throws \CHttpException
     */
    private function processAjaxDeleteAction()
    {
        $request = \Yii::app()->getRequest();
        $link = \event\models\LinkRole::model()->byRoleId($request->getParam('RoleId'))->byEventId($this->getEvent()->Id)->find();
        if ($link == null || !in_array($link->RoleId, $this->getCanDeleteRoleIdList()))
            throw new \CHttpException(404);

        $link->delete();
        echo json_encode(['success' => true]);
    }

    /**
     *
     */
    private function processAjaxListAction()
    {
        $result = [];
        foreach ($this->getEvent()->getRoles() as $role)
        {
            $item = new \stdClass();
            $item->Id = $role->Id;
            $item->Title = $role->Title;
            $item->CanDelete = in_array($role->Id, $this->getCanDeleteRoleIdList());
            $item->Color = !empty($role->Color) ? $role->Color : '';
            $result[] = $item;
        }
        echo json_encode($result);
    }

    private function processAjaxSetColorAction()
    {
        $request = \Yii::app()->getRequest();

        $color = $request->getParam('Color', null);
        $role  = Role::model()->findByPk($request->getParam('RoleId'));
        if ($role == null)
            throw new \CHttpException(404);

        $link = LinkRole::model()->byRoleId($role->Id)->byEventId($this->getEvent()->Id)->find();
        if ($link == null) {
            $link = new LinkRole();
            $link->RoleId = $role->Id;
            $link->EventId = $this->getEvent()->Id;
        }
        $link->Color = $color;
        $link->save();
        echo json_encode(['success' => true]);
    }

    /**
     *
     */
    private function processAjaxSearchAction()
    {
        $result = [];

        $request = \Yii::app()->getRequest();
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."Title" ASC';
        $criteria->addNotInCondition('"t"."Id"', \CHtml::listData($this->getEvent()->getRoles(), 'Id', 'Id'));
        $criteria->addSearchCondition('"t"."Title"', $request->getParam('term'), true, 'AND', 'ILIKE');
        $criteria->limit = 10;

        $roles = \event\models\Role::model()->findAll($criteria);
        foreach ($roles as $role)
        {
            $item = new \stdClass();
            $item->label = $role->Title;
            $item->value = $role->Id;
            $result[] = $item;
        }
        echo json_encode($result);
    }
} 