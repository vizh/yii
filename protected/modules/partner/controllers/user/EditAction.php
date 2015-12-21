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

        if ($id === null) {
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

            $this->processAjaxAction();

            $this->getController()->render('edit/user', [
                'user'  => $this->user,
                'event' => $this->getEvent(),
                'participants' => $this->prepareParticipants()
            ]);
        }
    }

    private function processAjaxAction()
    {
        $action = \Yii::app()->getRequest()->getParam('do');
        if (!empty($action)) {
            $method = 'processAjaxAction'.ucfirst($action);
            if (method_exists($this,$method)) {
                $result = $this->$method();
                echo json_encode($result);
                \Yii::app()->end();
            } else
                throw new \CHttpException(404);
        }
    }

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
                        $this->getEvent()->unregisterUserOnPart($this->user, $part, $message);
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

        $manager= $data->getManager();
        $manager->setAttributes($request->getParam(get_class($manager)));
        if ($manager->validate()) {
            $data->save();
            $result['values'] = [];
            foreach ($manager->getDefinitions() as $definition) {
                $result['values'][$definition->name] = $definition->getPrintValue($data->getManager());
            }
        } else {
            $result['errors'] = $manager->getErrors();
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