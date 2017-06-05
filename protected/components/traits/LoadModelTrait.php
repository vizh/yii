<?php
namespace application\components\traits;

use application\components\Exception;

trait LoadModelTrait
{
    /**
     * Загружает модель
     * @param string $class Имя класса модели
     * @param mixed $key Уникальный ключ для поиска: ID записи
     * @param bool $throwException
     * @return \CActiveRecord
     * @throws Exception
     * @throws \CHttpException
     */
    public function loadModel($class, $key, $throwException = true)
    {
        /** @var \application\components\ActiveRecord $class */
        if (method_exists($class, 'model')) {
            $model = null;
            if (!empty($key)) {
                $model = $class::model()->findByPk($key);
            }
            if ($model === null && $throwException) {
                throw new \CHttpException(404);
            }
            return $model;
        }
        throw new Exception('Переданный класс не является экземпляром CActiveRecord');
    }
}