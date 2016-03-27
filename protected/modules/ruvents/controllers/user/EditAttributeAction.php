<?php
namespace ruvents\controllers\user;

use event\models\Part;
use event\models\Participant;
use event\models\Role;
use event\models\UserData;
use ruvents\components\Exception;
use ruvents\models\ChangeMessage;
use ruvents\models\Setting;
use user\models\User;
use ruvents\components\Action;
use Yii;

class EditAttributeAction extends Action
{

    public function run()
    {
        $request = Yii::app()->getRequest();

        $id = $request->getParam('RunetId');
        $attrName = $request->getParam('AttributeName');
        $attrValue = $request->getParam('AttributeValue');

        if (empty($id))
            throw new Exception(900, 'RunetId');

        if (empty($attrName))
            throw new Exception(900, 'AttributeName');

        if (empty($attrValue))
            throw new Exception(900, 'AttributeValue');

        $user = User::model()
            ->byRunetId($id)
            ->find();

        if ($user === null)
            throw new Exception(202, $id);

        $setting = Setting::model()
            ->byEventId($this->getEvent()->Id)
            ->find();

        if (!in_array($attrName, $setting->EditableUserData))
            throw new Exception(901, $attrName);

        $userData = UserData::model()
            ->byEventId($this->getEvent()->Id)
            ->byUserId($user->Id)
            ->find();

        if ($userData === null)
            $userData = UserData::createEmpty($this->getEvent(), $user);

        $manager = $userData->getManager();

        $attrValueOld = $manager->$attrName;
        $manager->$attrName = $attrValue;

        if (!$manager->validate() && ($error = $manager->getError($attrName)) !== null)
             throw new Exception(252, [$attrName, $error]);

        $userData->save();

        $this->getDetailLog()->addChangeMessage(
            new ChangeMessage('Data', [$attrName => $attrValueOld], [$attrName => $attrValueOld])
        );

        $this->renderJson(['Success' => true]);
    }
}
