<?php

use application\components\controllers\AdminMainController;
use user\models\User;

/**
 * Class OneuseController contains actions that are used very seldom
 */
class OneuseController extends AdminMainController
{
    const PHOTO_PATH_ALIAS = '/images/user-photo-upload';

    /**
     * Updates photos of users. It takes photos from PHOTO_PATH_ALIAS with root webroot
     */
    public function actionUpdatephoto()
    {
        $path = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.self::PHOTO_PATH_ALIAS;
        $pattern = '*.jpg';

        $counter = 0;

        foreach (glob($path.DIRECTORY_SEPARATOR.$pattern) as $fileName) {
            preg_match('/(\d+)\.jpg/', $fileName, $matches);

            if (!isset($matches[1]) || empty($matches[1])) {
                continue;
            }

            $id = $matches[1];

            if (!$user = User::model()->findByPk($id)) {
                continue;
            }

            $photo = $user->getPhoto();
            if ($photo->hasImage()) {
                continue;
            }

            $photo->save($fileName);
            $user->refreshUpdateTime(true);

            $counter++;
        }

        echo "��������� $counter ����������";
    }
}
