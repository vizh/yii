<?php

namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use user\models\forms\edit\Photo;
use user\models\User;

/**
 * Class SetphotoAction
 * @package api\controllers\user
 */
class SetphotoAction extends Action
{
    /**
     * @param int $RunetId
     * @throws Exception
     */
    public function run($RunetId)
    {
        # TODO: права на изменение фотки
        $user = User::model()->byRunetId($RunetId)->find();

        if (!$user) {
            throw new Exception(202, [$RunetId]);
        }

        $form = new Photo();

        $form->Image = \CUploadedFile::getInstanceByName('Image');
        if ($form->validate()) {
            $user->getPhoto()->SavePhoto($form->Image);
            $this->setSuccessResult();
        } else {
            throw new Exception(3008, [$RunetId]);
        }
    }
}
