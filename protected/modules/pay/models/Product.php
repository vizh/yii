<?php
namespace pay\models;

use application\models\translation\ActiveRecord;
use event\models\Event;
use pay\components\managers\BaseProductManager;

/**
 * Class Product
 *
 * Fields
 * @property int $Id
 * @property string $ManagerName
 * @property string $Title
 * @property string $Description
 * @property int $EventId
 * @property string $Unit
 * @property int $Count
 * @property bool $EnableCoupon
 * @property bool $Public
 * @property int $Priority
 * @property string $AdditionalAttributes
 * @property string $AdditionalAttributesTitle
 * @property string $OrderTitle
 * @property string $GroupName
 * @property bool $VisibleForRuvents
 * @property bool $Deleted
 * @property string $DeletionTime
 *
 * @property Event $Event
 * @property ProductAttribute[] $Attributes
 * @property ProductPrice[] $Prices
 * @property ProductPrice[] $PricesActive
 *
 *
 * @method Product find($condition='',$params=array())
 * @method Product findByPk($pk,$condition='',$params=array())
 * @method Product[] findAll($condition='',$params=array())
 * @method Product byId(int $id)
 * @method Product byVisibleForRuvents(bool $visible)
 * @method Product byDeleted(bool $deleted)
 *
 */
class Product extends ActiveRecord
{
    protected $useSoftDelete = true;

    /**
     * @var ProductAttribute[]
     */
    protected $productAttributes;

    /**
     * @var BaseProductManager
     */
    private $manager;

    /**
     * Creates a new one model
     * @param int|Event $event Event's identifier of the event object
     * @param string $name Name of the product
     * @param string $managerName Manager's name for the product @see ProductManager
     * @param string $unit Units that will be used in orders, for example
     * @param array $config Configuration for the other attributes, for example ['EnableCoupon' => true]
     * @return self|null
     */
    public static function create($event, $name, $managerName, $unit = 'шт', array $config = [])
    {
        if ($event instanceof Event) {
            $event = $event->Id;
        }

        try {
            $model = new self();
            $model->Title = $name;
            $model->EventId = $event;
            $model->ManagerName = $managerName;
            $model->Unit = $unit;

            foreach (['Title', 'EventId', 'ManagerName', 'Unit'] as $attr) {
                unset($config[$attr]);
            }

            $model->setAttributes($config, false);

            $model->save(false);

            return $model;

        } catch (\CDbException $e) {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'PayProduct';
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return array(
            'Event' => [self::BELONGS_TO, 'event\models\Event', 'EventId'],
            'Attributes' => [self::HAS_MANY, 'pay\models\ProductAttribute', 'ProductId'],
            'Prices' => [self::HAS_MANY, 'pay\models\ProductPrice', 'ProductId', 'order' => '"Prices"."StartTime" ASC'],
            'PricesActive' => [self::HAS_MANY, 'pay\models\ProductPrice', 'ProductId', 'order' => '"PricesActive"."StartTime" ASC', 'condition' => '("PricesActive"."EndTime" IS NULL OR "PricesActive"."EndTime" >  now())'],
            'UserAccess' => [self::HAS_MANY, 'pay\models\ProductUserAccess', 'ProductId']
        );
    }

    /**
     * @return BaseProductManager
     */
    public function getManager()
    {
        if ($this->manager === null)
        {
            $manager = '\pay\components\managers\\' . $this->ManagerName;
            $this->manager = new $manager($this);
        }
        return $this->manager;
    }

    /**
     * @return ProductAttribute[]
     */
    public function getProductAttributes()
    {
        if ($this->productAttributes === null)
        {
            $this->productAttributes = array();
            foreach ($this->Attributes as $attribute)
            {
                $this->productAttributes[$attribute->Name] = $attribute;
            }
        }

        return $this->productAttributes;
    }

    /**
     * @param ProductAttribute $attribute
     */
    public function setProductAttribute($attribute)
    {
        $this->productAttributes[$attribute->Name] = $attribute;
    }

    /**
     * @param int $eventId
     * @param bool $useAnd
     *
     * @return Product
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."EventId" = :EventId';
        $criteria->params = array('EventId' => $eventId);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     *
     * @param bool $public
     * @param bool $useAnd
     * @return \pay\models\Product
     */
    public function byPublic($public, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = ($public ? '' : 'NOT ') . '"t"."Public"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $userId
     * @param bool $useAnd
     *
     * @return $this
     */
    public function byUserAccess($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['UserAccess' => ['together' => true, 'select' => false]];
        $criteria->condition = '"UserAccess"."UserId" = :UserId';
        $criteria->params = ['UserId' => $userId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param string $managerName
     * @param bool $useAnd
     *
     * @return Product
     */
    public function byManagerName($managerName, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."ManagerName" = :ManagerName';
        $criteria->params = array('ManagerName' => $managerName);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * Исключить менеджер комнат
     * @param bool $useAnd
     * @return $this
     */
    public function excludeRoomManager($useAnd = true)
    {
        $criteria = new \CDbCriteria([
            'condition' => '"t"."ManagerName" <> \'RoomProductManager\''
        ]);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param string $time
     * @return int
     */
    public function getPrice($time = null)
    {
        return $this->getManager()->getPriceByTime($time);
    }

    /**
     * @return string[]
     */
    public function getTranslationFields()
    {
        return ['Title', 'Description'];
    }

    /**
     * @return AdditionalAttribute[]
     */
    public function getAdditionalAttributes()
    {
        if ($this->AdditionalAttributes == null)
        {
            return [];
        }
        return unserialize(base64_decode($this->AdditionalAttributes));
    }

    /**
     * @param AdditionalAttribute[] $attributes
     */
    public function setAdditionalAttributes($attributes)
    {
        $this->AdditionalAttributes = base64_encode(serialize($attributes));
    }

    /**
     * Является ли товар билетом
     * @return bool
     */
    public function getIsTicket()
    {
        return $this->ManagerName == 'Ticket';
    }
}