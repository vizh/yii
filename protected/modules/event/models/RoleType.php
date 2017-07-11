<?php
namespace event\models;

final class RoleType
{
    const NONE = 'none';
    const LISTENER = 'listener';
    const SPEAKER = 'speaker';
    const MASTER = 'master';

    private static $roleWeights = [
        self::NONE => 0,
        self::LISTENER => 1,
        self::SPEAKER => 2,
        self::MASTER => 3
    ];

    public static function exists($role)
    {
        return isset(self::$roleWeights[$role]);
    }

    public static function compare($role1, $role2)
    {
        return self::$roleWeights[$role1] > self::$roleWeights[$role2]
            ? $role1
            : $role2;
    }
}
