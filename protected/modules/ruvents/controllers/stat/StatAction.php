<?php
namespace ruvents\controllers\stat;

use ruvents\models\Visit;

/**
 * Class StatAction Base actions for the other actions
 */
class StatAction extends \CAction
{
    /**
     * Fetches unique names of the groups
     * @param int $eventId Identifier of the event
     * @return string[]
     */
    protected function fetchUniqueGroups($eventId)
    {
        $substringPattern = "SUBSTRING(\"MarkId\" FROM '^Питание\\s\\d{2}\\.\\d{2}/\\w+')";

        $groups = \Yii::app()->getDb()->createCommand()
            ->select($substringPattern)
            ->from(Visit::model()->tableName())
            ->where('"EventId" = :eventId', [':eventId' => $eventId])
            ->group($substringPattern)
            ->order($substringPattern . ' DESC')
            ->queryColumn();

        $_groups = array_filter($groups, function ($name) {
            return !is_null($name);
        });

        $map = [];
        foreach ($_groups as $group) {
            $key = \Inflector::transliterate(strtr(\Inflector::transliterate($group), [
                ' ' => '_',
                '/' => '_',
                '.' => ''
            ]));

            $map[$key] = $group;
        }

        return $map;
    }
}
