<?php
namespace event\models;

use application\components\ActiveRecord;
use event\components\IWidget;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Name
 * @property int $Order
 *
 * @property Event $Event
 *
 * Описание вспомогательных методов
 * @method Widget   with($condition = '')
 * @method Widget   find($condition = '', $params = [])
 * @method Widget   findByPk($pk, $condition = '', $params = [])
 * @method Widget   findByAttributes($attributes, $condition = '', $params = [])
 * @method Widget[] findAll($condition = '', $params = [])
 * @method Widget[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Widget byId(int $id, bool $useAnd = true)
 * @method Widget byEventId(int $id, bool $useAnd = true)
 * @method Widget byName(string $name, bool $useAnd = true)
 */
class Widget extends ActiveRecord implements IWidget
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

    public function tableName()
    {
        return 'EventWidget';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
        ];
    }

    private $widget = null;

    /**
     * @return \event\components\Widget
     * @throws \application\components\Exception
     */
    public function getWidget()
    {
        if ($this->widget === null) {
            if (!class_exists($this->Name)) {
                throw new \application\components\Exception('Не существует виджета мероприятия с именем:'.$this->Name);
            }

            $this->widget = \Yii::app()->getController()->createWidget($this->Name, ['event' => $this->Event]);
        }

        return $this->widget;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->getWidget()->getTitle();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getWidget()->getName();
    }

    public function getEvent()
    {
        return $this->Event;
    }

    public function getAdminPanel()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->getWidget()->getPosition();
    }

    public function process()
    {
        $this->getWidget()->process();
    }

    public function run()
    {
        $this->getWidget()->run();
    }

    /**
     * @return bool
     */
    public function getIsActive()
    {
        return $this->getWidget()->getIsActive();
    }
}