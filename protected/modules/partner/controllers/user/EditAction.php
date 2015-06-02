<?php
namespace partner\controllers\user;

use event\models\Part;
use event\models\Participant;
use event\models\Role;
use event\models\UserData;
use partner\models\forms\user\Edit;
use user\models\User;

class EditAction extends \partner\components\Action
{
    /** @var \user\models\User */
    public $user = null;

    public function run($id = null)
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();

        if ($this->id === null) {
            $form = new Edit();
            if ($request->getIsPostRequest()) {
                $form->attributes = $request->getParam(get_class($form));
                if ($form->validate()) {
                    $this->getController()->redirect(['edit', 'id' => $form->Label]);
                }
            }
            $this->getController()->render('edit', [
                'form' => $form
            ]);
        } else {
            $this->user = User::model()->byRunetId($id)->find();
            if ($this->user === null) {
                throw new \CHttpException(404);
            }

            $this->getController()->render('edit-tabs', [
                'user'  => $this->user,
                'event' => $this->getEvent(),
                'participants' => $this->prepareParticipants()
            ]);
        }






        /*
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
        */
    }

    /**
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
     * /

    /**
     * @return \event\models\Participant[]
     */
    private function prepareParticipants()
    {
        $participants = Participant::model()
            ->byEventId($this->getEvent()->Id)->byUserId($this->user->Id)->orderBy(['"t"."PartId"'])->findAll();

        if (sizeof($this->getEvent()->Parts) > 0) {
            $result = [];
            foreach ($participants as $participant) {
                $result[$participant->PartId] = $participant;
            }
        } else {
            $result = $participants;
        }
        return $result;
    }

    /**
     * @return array
     * @throws \application\components\Exception
     */
    private function processAjaxActionChangeParticipant()
    {
        $result  = [];
        $request = \Yii::app()->getRequest();

        $roleId  = $request->getParam('roleId');
        $partId  = $request->getParam('partId');
        $message = $request->getParam('message');

        /** @var $role \event\models\Role */
        $role = Role::model()->findByPk($roleId);
        if ($role !== null) {
            if (sizeof($this->getEvent()->Parts) == 0) {
                $this->getEvent()->registerUser($this->user, $role, false, $message);
            } else {
                $part = Part::model()->findByPk($partId);
                if ($part !== null) {
                    $this->getEvent()->registerUserOnPart($part, $this->user, $role, false, $message);
                } else {
                    $result['error'] = true;
                }
            }
        } else {
            if ((int)$roleId == 0) {
                if (sizeof($this->getEvent()->Parts) == 0) {
                    $this->getEvent()->unregisterUser($this->user, $message);
                } else {
                    $part = Part::model()->findByPk($partId);
                    if ($part !== null) {
                        $this->getEvent()->unregisterUserOnPart($part, $this->user, $message);
                    } else {
                        $result['error'] = true;
                    }
                }
            } else {
                $result['error'] = true;
            }
        }
        return $result;
    }

    /**
     * @return array
     * @throws \CHttpException
     */
    private function processAjaxActionEditData()
    {
        $result = [];
        $request = \Yii::app()->getRequest();
        /** @var UserData $data */
        $data = UserData::model()->byEventId($this->getEvent()->Id)->byUserId($this->user->Id)->findByPk($request->getParam('dataId'));
        if ($data === null) {
            throw new \CHttpException(404);
        }

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

    /**
     * @return array
     * @throws \CHttpException
     */
    private function processAjaxActionDeleteData()
    {
        $request = \Yii::app()->getRequest();
        $data = UserData::model()->byEventId($this->getEvent()->Id)->byUserId($this->user->Id)->findByPk($request->getParam('dataId'));
        if ($data == null) {
            throw new \CHttpException(404);
        }
        $data->Deleted = true;
        $data->save();
        return ['success' => true];
    }
}