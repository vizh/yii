<?php

namespace api\controllers\user;

use api\components\Action;
use api\components\builders\Builder;
use api\components\Exception;
use CUploadedFile;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\ApiAction;
use user\models\forms\edit\Photo;
use user\models\Settings;
use user\models\UnsubscribeEventMail;

class SettingsAction extends Action
{
    /**
     * @ApiAction(
     *     controller="User",
     *     title="Настройки",
     *     description="Позволяет отписать и подписать пользователя на следующие события: EMail рассылки, Push уведомления, индексацию профиля в поисковых системах. Важное замечание: изменяется состояние только тех полей, которые были переданы.",
     *     request=@Request(
     *          method="POST",
     *          url="/user/settings",
     *          params={
     *              @Param(title="SubscribedForMailings", type="Логический", mandatory="N", description="Отписка от EMail рассылок."),
     *              @Param(title="SubscribedForPushes", type="Логический", mandatory="N", description="Отказ от Push уведомлений."),
     *              @Param(title="AllowProfileIndexing", type="Логический", mandatory="N", description="Управление запретом индексации профиля в поисковых системах.")
     *          }
     *     )
     * )
     */
    public function run()
    {
        $settings = $this->getRequestedUser()->Settings;

        if ($settings === null) {
            $settings = new Settings();
        }

        if ($this->hasRequestParam('SubscribedForMailings') && $modelChanged = true) {
            $settings->UnsubscribeAll = !$this->getRequestParamBool('SubscribedForMailings');
        }

        if ($this->hasRequestParam('SubscribedForPushes') && $modelChanged = true) {
            $settings->UnsubscribePush = !$this->getRequestParamBool('SubscribedForPushes');
        }

        if ($this->hasRequestParam('AllowProfileIndexing') && $modelChanged = true) {
            $settings->IndexProfile = $this->getRequestParamBool('AllowProfileIndexing');
        }

        if (isset($modelChanged) && false === $settings->save()) {
            throw new Exception($settings);
        }

        $userData = $this
            ->getDataBuilder()
            ->createUser($this->getRequestedUser(), [Builder::USER_SETTINGS])
            ->Settings;

        $this->setResult($userData);
    }
}
