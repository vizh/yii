<?php

namespace api\controllers\user;

use api\components\Action;
use user\models\User;

/**
 * Class SetphotoAction
 * @package api\controllers\user
 */
class SetphotoAction extends Action
{
    /**
     * @var array
     */
    private $mimeToType = [
        'image/gif' => IMAGETYPE_GIF,
        'image/png' => IMAGETYPE_PNG,
        'image/jpeg' => IMAGETYPE_JPEG,
    ];

    /**
     * @param int $RunetId
     */
    public function run($RunetId)
    {
        $RunetId = (int)$RunetId;
        $request = \Yii::app()->getRequest();

        $tmpHandle = tmpfile();
        fwrite($tmpHandle, $request->getRawBody());
        $tmpPath = stream_get_meta_data($tmpHandle)['uri'];
        $tmpMime = mime_content_type($tmpPath);
        $tmpExtension = image_type_to_extension($this->mimeToType[$tmpMime]);

        $uploadedFile = new \CUploadedFile(
            "avatar.$tmpExtension",
            $tmpPath,
            $tmpMime,
            fstat($tmpHandle)['size'],
            UPLOAD_ERR_OK
        );

        $user = User::model()->byRunetId($RunetId)->find();
        $user->getPhoto()->saveUploaded($uploadedFile);

        $this->setResult(['Success' => true]);
    }
}
