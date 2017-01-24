<?php
namespace event\models;

final class RoleType
{
    const NONE = 'none';
    const LISTENER = 'listener';
    const SPEAKER = 'speaker';
    const MASTER = 'master';

    static public function compare($role1, $role2)
    {
        $weight = [
            self::NONE => 0,
            self::LISTENER => 1,
            self::SPEAKER => 2,
            self::MASTER => 3
        ];

        if ($weight[$role1] > $weight[$role2]) {
            return $role1;
        }

        return $role2;
    }
}
