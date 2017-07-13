<?php

namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use mail\components\mailers\SESMailer;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\ApiAction;
use user\components\handlers\recover\mail\Recover as MailRecover;
use user\models\User;
use Yii;

class PasswordRestoreAction extends Action
{
    const CREDENTIAL_TYPE_EMAIL = 1;
    const CREDENTIAL_TYPE_PHONE = 2;
    const CREDENTIAL_TYPE_RUNETID = 3;

    /**
     * @ApiAction(
     *     controller="User",
     *     title="Восстановление пароля",
     *     description="Инициирует отправку письма с инструкциями по восстановлению пароля.",
     *     request=@Request(
     *          method="POST",
     *          url="/user/passwordRestore",
     *          params={
     *              @Param(title="Credential", type="Cтрока", mandatory="Y", description="Адрес Email, телефон или RunetId зарегистрированного пользователя")}))
     */
    public function run()
    {
        $user = User::model();
        $credential = $this->getRequestParam('Credential');

        switch ($this->getDetectedCredentialType($credential)) {
            case self::CREDENTIAL_TYPE_EMAIL:
                $user->byEmail($credential);
                break;

            case self::CREDENTIAL_TYPE_PHONE:
                $user->byPrimaryPhone($credential);
                break;

            case self::CREDENTIAL_TYPE_RUNETID:
                $user->byRunetId($credential);
                break;

            default:
                throw new Exception(209);
        }

        $user = $user->find();

        if ($user === null) {
            throw new Exception(209);
        }

        $mail = new MailRecover(new SESMailer(), $user);
        $mail->send();

        $this->setSuccessResult();
    }

    /**
     * Пытается определить тип удостоверения пользователя
     *
     * @param $credential
     *
     * @return int|null
     */
    private function getDetectedCredentialType($credential)
    {
        // Сначана проверим, что переданное удостоверение является Email адресом, это проще всего
        if (false !== filter_var($credential, FILTER_VALIDATE_EMAIL)) {
            return self::CREDENTIAL_TYPE_EMAIL;
        }

        // Вторым по простоте выявления является номер RunetId, так что проверим теперь этот вариант
        if (is_numeric($credential) && false !== User::model()->byRunetId($credential)->exists()) {
            return self::CREDENTIAL_TYPE_RUNETID;
        }

        // Ну и напоследок попытаемся выяснить, не телефонный ли это номер...
        $phoneTool = PhoneNumberUtil::getInstance();
        // Вот тут большой вопрос.. Для россии будет работать, но вот для иностранных граждан,
        // для ВСЕХ которых у нас EN, будут проблемы. Поляки, Итальянцы и т.п. Все будут малость в пролёте...
        // Но мы хотя-бы попытаемся :)
        $currentRegionCode = strtoupper(Yii::app()->getLanguage());

        try {
            // Пробуем распарсить переданную строку. Тут может быть вызвано исключение.
            $phoneNumber = $phoneTool->parse($credential, $currentRegionCode);
            // Если не было брошено исключение, то мы на верном пути и нам осталась собственно проверка
            if (false !== $phoneTool->isValidNumberForRegion($phoneNumber, $currentRegionCode)) {
                return self::CREDENTIAL_TYPE_PHONE;
            }
        } catch (NumberParseException $e) {
            // Тут нечего делать
        }

        return null;
    }
}