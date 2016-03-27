<?php
namespace ruvents\controllers\user;

use ruvents\components\Action;
use ruvents\components\Exception;
use user\models\forms\edit\Photo;
use user\models\User;

/**
 * Class PhotoAction Updates the user photo
 *
 * Params
 * - int $RunetId
 * - file $Image
 */
class PhotoAction extends Action
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $id = $request->getParam('RunetId');

        $user = User::model()
            ->byRunetId($id)
            ->find();

        if ($user === null)
            throw new Exception(202, $id);

        $form = new Photo();
        $form->Image = \CUploadedFile::getInstanceByName('Photo');
        
        if (!$form->validate())
            throw new Exception(105, $form->getError('Image'));

        $user->getPhoto()->saveUploaded($form->Image);
        $user->refreshUpdateTime(true);

        $this->renderJson([
            'Success' => true
        ]);
    }
}
