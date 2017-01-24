<?php
namespace event\models;

use application\components\ActiveRecord;
use application\components\Exception;
use event\components\IWidget;
use event\components\Widget;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $Order
 * @property int $ClassId
 *
 * @property Event $Event
 * @property WidgetClass $Class
 *
 * Описание вспомогательных методов
 * @method LinkWidget   with($condition = '')
 * @method LinkWidget   find($condition = '', $params = [])
 * @method LinkWidget   findByPk($pk, $condition = '', $params = [])
 * @method LinkWidget   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkWidget[] findAll($condition = '', $params = [])
 * @method LinkWidget[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkWidget byId(int $id, bool $useAnd = true)
 * @method LinkWidget byEventId(int $id, bool $useAnd = true)
 * @method LinkWidget byClassId(int $id, bool $useAnd = true)
 */
class LinkWidget extends ActiveRecord implements IWidget
{
    /**
     * @param string $className
     * @return Widget
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventLinkWidget';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'Class' => [self::BELONGS_TO, '\event\models\WidgetClass', 'ClassId']
        ];
    }

    /** @var Widget */
    private $widget = null;

    /**
     * Создает виджет
     *
     * @return Widget
     * @throws Exception
     */
    public function getWidget()
    {
        if ($this->widget === null) {
            if (empty($this->Class)) {
                throw new Exception('Не существует виджета мероприятия с Id:'.$this->ClassId);
            }
            $this->widget = $this->Class->createWidget($this->Event);
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