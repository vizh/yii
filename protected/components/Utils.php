<?php

class Utils
{
    public static function PrepareStringForLike($keyword)
    {
        return strtr($keyword, ['%' => '\%', '_' => '\_', '\\' => '\\\\']);
    }

    public static function GeneratePassword($length = 8)
    {
        $base = md5(uniqid(rand(), true));
        $length = min(strlen($base), $length);
        return substr($base, 0, $length);
    }
}
