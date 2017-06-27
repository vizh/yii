<?php

namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use CUploadedFile;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\ApiAction;
use user\models\forms\edit\Photo;

class SetphotoAction extends Action
{
    /**
     * @ApiAction(
     *     controller="User",
     *     title="Установка фотографии",
     *     description="Устанавливает фотографию посетителя из файла изображения или ссылки на него.",
     *     request=@Request(
     *          method="GET",
     *          url="/user/setphoto",
     *          body="",
     *          params={
     *              @Param(title="Photo", type="Файл", defaultValue="", description="Файл с фотографией посетителя."),
     *              @Param(title="PhotoUrl", type="Строка", defaultValue="", description="URL адрес фотографии посетителя.")
     *          }
     *     )
     * )
     */
    public function run()
    {
        $user = $this->getRequestedUser();

        if ($this->hasRequestParam('Photo')) {
            $form = new Photo();
            $form->Image = CUploadedFile::getInstanceByName('Photo');

            if ($form->validate() === false) {
                throw new Exception(3008, [$this->getRequestedUser()->RunetId]);
            }

            $user->getPhoto()->SavePhoto($form->Image);
        }

        if ($this->hasRequestParam('PhotoUrl')) {
            $user->getPhoto()->save($this->getRequestParam('PhotoUrl'));
            $user->save();
        }

        $this->setSuccessResult();
    }
}
