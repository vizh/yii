<?php


class Utils
{

  public static function PrepareStringForLike($keyword)
  {
    return strtr($keyword, array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\'));
  }
}
