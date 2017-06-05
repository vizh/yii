<?php
namespace application\components;

class Cookie
{
    /**
     * @static
     * @param string $name
     * @return \CHttpCookie|null
     */
    public static function Get($name)
    {
        return (isset(\Yii::app()->request->cookies[$name])) ? \Yii::app()->request->cookies[$name] : null;
    }

    /**
     * @static
     * @param \CHttpCookie $cookie
     * @return void
     */
    public static function Set($cookie)
    {
        if (isset(\Yii::app()->params['CookieDomain']) && empty($cookie->domain)) {
            $cookie->domain = \Yii::app()->params['CookieDomain'];
        }
        \Yii::app()->request->cookies[$cookie->name] = $cookie;
    }

    /**
     * @param $name
     * @param mixed|null $defaultValue
     * @return mixed|null
     */
    public static function Param($name, $defaultValue = null)
    {
        $cookie = Cookie::Get($name);
        return $cookie !== null ? $cookie->value : $defaultValue;
    }

    /**
     * @static
     * @param string $name
     * @return void
     */
    public static function Delete($name)
    {
        unset(\Yii::app()->request->cookies[$name]);
    }

    /**
     * @static
     * @return void
     */
    public static function Clear()
    {
        \Yii::app()->request->cookies->clear();
    }

}