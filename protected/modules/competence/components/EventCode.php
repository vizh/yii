<?php
namespace application\modules\competence\components;

use competence\models\Test;
use event\models\Participant;
use user\models\User;

class EventCode
{
    const HASH_SALT = ';et4?AQYRpV3DZN\sYez%/u1t';
    const CODE_LENGTH = 8;

    /**
     * Генерирует код для авторизации на опросе мероприятия
     * @param User $user
     * @param Test $test
     * @return string
     */
    public static function generate(User $user, Test $test)
    {
        return substr(md5($user->Id.self::HASH_SALT.$test->Id), 5, static::CODE_LENGTH);
    }

    /**
     * Разбирает код пользователя
     * @param string $code
     * @param Test $test
     * @return null|User
     */
    public static function parse($code, Test $test)
    {
        if (!empty($test->EventId)) {
            $criteria = new \CDbCriteria();
            if (is_numeric($code)) {
                $criteria->addCondition('"User"."RunetId" = :RunetId AND NOT "User"."Visible"');
                $criteria->params['RunetId'] = $code;
            } else {
                $criteria->addCondition('substr(MD5(concat("t"."UserId",:HashSalt,:TestId)), 6, '.static::CODE_LENGTH.') = :Code');
                $criteria->params['HashSalt'] = static::HASH_SALT;
                $criteria->params['TestId'] = $test->Id;
                $criteria->params['Code'] = $code;
            }
            /** @var Participant $participant */
            $participant = Participant::model()->byEventId($test->EventId)->with('User')->find($criteria);
            if ($participant !== null) {
                return $participant->User;
            }
        }
        return null;
    }
}

