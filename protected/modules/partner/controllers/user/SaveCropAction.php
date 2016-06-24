<?php
namespace partner\controllers\user;

use partner\components\Action;
use user\models\User;

/**
 * Class SaveCropAction
 */
class SaveCropAction extends Action
{
    /**
     * DO something
     * 
     * @param int $id
     * @throws \CHttpException
     */
    public function run($id)
    {
        if (!$user = User::model()->findByPk($id)) {
            throw new \CHttpException(404, 'User is not found');
        }
        
        if (!$user->getPhoto()->hasImage()) {
            throw new \CHttpException(404, 'User\'s image is not found');
        }

        $request = \Yii::app()->getRequest();
        $x = $request->getParam('x');
        $y = $request->getParam('y');
        $width = $request->getParam('width');
        $height = $request->getParam('height');
        
        if (is_null($x) || is_null($y) || is_null($width) || is_null($height)) {
            throw new \CHttpException(400, 'Invalid data');
        }
        
        $x = $x < 0 ? 0 : $x;
        $y = $y < 0 ? 0 : $y;
        
        $user->getPhoto()->resize($x, $y, $width, $height);
        $user->refreshUpdateTime(true);
    }
}
