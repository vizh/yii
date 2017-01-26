<?php
namespace event\models;

use application\components\ActiveRecord;
use event\components\IWidget;

/**
 * @property int $Id
 * @property string $Class
 * @property bool $Visible
 *
 * Описание вспомогательных методов
 * @method WidgetClass   with($condition = '')
 * @method WidgetClass   find($condition = '', $params = [])
 * @method WidgetClass   findByPk($pk, $condition = '', $params = [])
 * @method WidgetClass   findByAttributes($attributes, $condition = '', $params = [])
 * @method WidgetClass[] findAll($condition = '', $params = [])
 * @method WidgetClass[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method WidgetClass byId(int $id, bool $useAnd = true)
 * @method WidgetClass byClass(string $class, bool $useAnd = true)
 * @method WidgetClass byVisible(bool $visible, bool $useAnd = true)
 */
class WidgetClass extends ActiveRecord
{
    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'EventWidgetClass';
    }

    /**
     * Создает виджет
     *
     * @param Event $event
     * @param bool $skipInit
     * @return IWidget
     */
    public function createWidget(Event $event, $skipInit = false)
    {
        $controller = \Yii::app()->getController();
        $widget = \Yii::app()->getWidgetFactory()->createWidget($controller, $this->Class, ['event' => $event]);
        if (!$skipInit) {
            $widget->init();
        }

        return $widget;
    }
}
