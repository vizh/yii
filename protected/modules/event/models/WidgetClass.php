<?php
namespace event\models;
use event\components\IWidget;

/**
 * @property int $Id
 * @property string $Class
 */
class WidgetClass extends \CActiveRecord
{
    /**
     * @param string $className
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventWidgetClass';
    }

    /**
     *
     * @param string $class
     * @param bool $useAnd
     * @return $this
     */
    public function byClass($class, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Class" = :Class';
        $criteria->params = array('Class' => $class);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     *
     * @param bool $visble
     * @param bool $useAnd
     * @return $this
     */
    public function byVisible($visible = true, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = (!$visible ? 'NOT' : '').' "t"."Visible"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }


    /**
     * Создает виджет
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