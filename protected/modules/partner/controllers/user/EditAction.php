<?php
namespace partner\controllers\user;

use event\models\UserData;

class EditAction extends \partner\components\Action
{
    /** @var \user\models\User */
    public $user = null;

    public $error;

    /** @var \event\models\Role[] */
    public $roles;

    private $viewParams = [];

    public function run()
    {
        $this->getController()->initActiveBottomMenu('edit');

        $request = \Yii::app()->request;
        $runetId = $request->getParam('runetId');
        $name = $request->getParam('name');
        if ((int)$runetId === 0)
        {
            $runetId = (int)$name;
        }
        $this->user = \user\models\User::model()->byRunetId($runetId)->find();
        $this->setTitle();

        if ($this->user === null)
        {
            if ($request->getIsPostRequest())
            {
                $this->error = 'Не удалось найти пользователя. Убедитесь, что все данные указаны правильно.';
            }
            $this->getController()->render('edit', array(
                'runetId' => $runetId,
                'name' => $name
            ));
        }
        else
        {
            if ($request->getQuery('runetId', null) == null)
            {
                $this->getController()->redirect(
                    \Yii::app()->createUrl('/partner/user/edit',
                        array('runetId' => $this->user->RunetId)
                    )
                );
            }

            $this->roles = $this->getEvent()->getRoles();
            $doAction = $request->getParam('do');
            if (!empty($doAction))
            {
                $method = 'processAjaxAction'.ucfirst($doAction);
                if (method_exists($this,$method)) {
                    $result = $this->$method();
                    echo json_encode($result);
                    \Yii::app()->end();
                } else
                    throw new \CHttpException(404);
            }

            $participants = $this->prepareParticipants();
            $this->viewParams = [
                'user' => $this->user,
                'event' => $this->getEvent(),
                'roles' => $this->roles,
                'participants' => $participants,
            ];

            // TODO: это от devcon14, нужно не забыть убрать
            if ($this->getEvent()->Id == 831)
            {
                $this->processEvent831Product();
            }

            $this->getController()->render('edit-tabs', $this->viewParams);
        }
    }

    private function setTitle()
    {
        if (!empty($this->user))
        {
            $this->getController()->setPageTitle('Добавление/редактирование участника мероприятия: ' . $this->user->GetFullName());
        }
        else
        {
            $this->getController()->setPageTitle('Добавление/редактирование участника мероприятия');
        }
    }

    /**
     * @return \event\models\Participant[]
     */
    private function prepareParticipants()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."PartId"';
        $participants = \event\models\Participant::model()->byEventId($this->getEvent()->Id)->byUserId($this->user->Id)->findAll($criteria);

        if (sizeof($this->getEvent()->Parts) > 0)
        {
            $result = array();
            foreach ($participants as $participant)
            {
                $result[$participant->PartId] = $participant;
            }
        }
        else
        {
            $result = $participants;
        }

        return $result;
    }

    private function processAjaxActionChangeParticipant()
    {
        $result = array();
        $request = \Yii::app()->getRequest();

        $roleId  = $request->getParam('roleId');
        $partId  = $request->getParam('partId');
        $message = $request->getParam('message');

        /** @var $role \event\models\Role */
        $role = \event\models\Role::model()->findByPk($roleId);
        if ($role !== null)
        {
            if (sizeof($this->getEvent()->Parts) == 0)
            {
                $this->getEvent()->registerUser($this->user, $role, false, $message);
            }
            else
            {
                $part = \event\models\Part::model()->findByPk($partId);
                if ($part !== null)
                {
                    $this->getEvent()->registerUserOnPart($part, $this->user, $role, false, $message);
                }
                else
                {
                    $result['error'] = true;
                }
            }
        }
        else
        {
            if ((int)$roleId == 0)
            {
                if (sizeof($this->getEvent()->Parts) == 0)
                {
                    $this->getEvent()->unregisterUser($this->user, $message);
                }
                else
                {
                    $part = \event\models\Part::model()->findByPk($partId);
                    if ($part !== null)
                    {
                        $this->getEvent()->unregisterUserOnPart($part, $this->user, $message);
                    }
                    else
                    {
                        $result['error'] = true;
                    }
                }
            }
            else
            {
                $result['error'] = true;
            }
        }
        return $result;
    }

    private function processAjaxActionEditData()
    {
        $result = [];

        $request = \Yii::app()->getRequest();
        /** @var UserData $data */
        $data = UserData::model()->byEventId($this->getEvent()->Id)->byUserId($this->user->Id)->findByPk($request->getParam('dataId'));
        if ($data == null)
            throw new \CHttpException(404);

        $data->getManager()->setAttributes($request->getParam('attributes'));
        if ($data->getManager()->validate()) {
            $data->save();
            $result['values'] = [];
            foreach ($data->getManager()->getDefinitions() as $definition) {
                $result['values'][$definition->name] = $definition->getPrintValue($data->getManager());
            }
        } else {
            $result['errors'] = $data->getManager()->getErrors();
        }
        return $result;
    }

    private function processAjaxActionDeleteData()
    {
        $request = \Yii::app()->getRequest();
        $data = UserData::model()->byEventId($this->getEvent()->Id)->byUserId($this->user->Id)->findByPk($request->getParam('dataId'));
        if ($data == null)
            throw new \CHttpException(404);

        $data->Deleted = true;
        $data->save();
        return ['success' => true];
    }

    private function processEvent831Product()
    {
        $request = \Yii::app()->getRequest();
        $event831productIdList = [2759,2760,2761,2762,2763,2764,2765];
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."Id"', $event831productIdList);
        $this->viewParams['event831Products'] = \pay\models\Product::model()->findAll($criteria);

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."ProductId"', $event831productIdList);
        $this->viewParams['event831OrderItem'] = \pay\models\OrderItem::model()->byOwnerId($this->user->Id)->byDeleted(false)->find($criteria);

        $event831Product = $request->getParam('event831Product');
        if ($event831Product !== null)
        {
            if ($event831Product != '')
            {
                $orderItem = new \pay\models\OrderItem();
                $orderItem->ProductId = $event831Product;
                $orderItem->OwnerId = $orderItem->PayerId = $this->user->Id;
                $orderItem->save();
                $orderItem->activate();

                if ($this->viewParams['event831OrderItem'] !== null)
                {
                    $this->viewParams['event831OrderItem']->Paid = false;
                    $this->viewParams['event831OrderItem']->PaidTime = null;
                    $this->viewParams['event831OrderItem']->save();
                    $this->viewParams['event831OrderItem']->delete();
                }
            }
            else
            {
                $this->viewParams['event831OrderItem']->Paid = false;
                $this->viewParams['event831OrderItem']->PaidTime = null;
                $this->viewParams['event831OrderItem']->save();
                $this->viewParams['event831OrderItem']->delete();
            }
            $this->getController()->refresh();
        }
    }
}