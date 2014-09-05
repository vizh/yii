<?php
namespace pay\controllers\ajax;

use event\models\UserData;

class UserDataAction extends \pay\components\Action
{
    public function run($eventIdName, $runetId)
    {
        $user = \user\models\User::model()->byRunetId($runetId)->find();
        if ($user === null) {
            throw new \CHttpException(404);
        }

        $definedAttributes = UserData::getDefinedAttributes($this->getEvent(), $user);

        $editArea = $this->getController()->renderPartial(
            '/cabinet/register/templates/row-userdata',
            ['event' => $this->getEvent(), 'definedAttributes' => $definedAttributes],
            true
        );

        $result = new \stdClass();
        $result->showEditArea = !empty($editArea);
        $result->editArea = $editArea;

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
} 