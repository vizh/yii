<?php
namespace event\models;

use Yii;

final class Approved
{
    const YES = 1;
    const NO = -1;
    const NONE = 0;

    public static function getLabels()
    {
        return [
            self::NONE => Yii::t('app', 'На рассмотрении'),
            self::YES => Yii::t('app', 'Подтвержден'),
            self::NO => Yii::t('app', 'Отклонен')
        ];
    }
}
