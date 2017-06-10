<?php

YiiBase::$classMap['application\components\WebApplication'] = dirname(__FILE__).'/components/WebApplication.php';

/**
 * @method static Yii app()
 */
class Yii extends YiiBase
{
    /**
     * Creates a Web application instance.
     * @param mixed $config application configuration.
     * If a string, it is treated as the path of the file that contains the configuration;
     * If an array, it is the actual configuration information.
     * Please make sure you specify the {@link CApplication::basePath basePath} property in the configuration,
     * which should point to the directory containing all application logic, template and data.
     * If not, the directory will be defaulted to 'protected'.
     * @return CWebApplication
     */
    public static function createWebApplication($config = null)
    {
        return self::createApplication('\application\components\WebApplication', $config);
    }

    public static function PublicPath()
    {
        return $_SERVER['DOCUMENT_ROOT'];
    }

    public static function getExistClass($namespace, $name, $default = null)
    {
        $namespace = rtrim($namespace, ' \\').'\\';
        $path = \Yii::getPathOfAlias(str_replace('\\', '.', ltrim($namespace, '\\'))).DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $name).'.php';
        if (file_exists($path)) {
            return $namespace.$name;
        }
        return $default !== null ? $namespace.$default : null;
    }

    public static function getExistClassArray($namespace, $names, $default = null)
    {
        foreach ($names as $name) {
            $class = self::getExistClass($namespace, $name, null);
            if ($class) {
                return $class;
            }
        }
        return $default !== null ? $namespace.$default : null;
    }

}