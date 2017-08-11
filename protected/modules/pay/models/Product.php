<?php
namespace pay\models;

use application\models\translation\ActiveRecord;
use event\models\Event;
use pay\components\managers\BaseProductManager;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $ManagerName
 * @property string $Title
 * @property string $Description
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
 * Описание вспомогательных методов
 * @method Product   with($condition = '')
 * @method Product   find($condition = '', $params = [])
 * @method Product   findByPk($pk, $condition = '', $params = [])
 * @method Product   findByAttributes($attributes, $condition = '', $params = [])
 * @method Product[] findAll($condition = '', $params = [])
 * @method Product[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Product byId(int $id, bool $useAnd = true)
 * @method Product byEventId(int $id, bool $useAnd = true)
 * @method Product byManagerName(string $managerName, bool $useAnd = true)
 * @method Product byGroupName(string $groupName, bool $useAnd = true)
 * @method Product byPublic(bool $public = true, bool $useAnd = true)
 * @method Product byVisibleForRuvents(bool $visible = true, bool $useAnd = true)
 * @method Product byDeleted(bool $deleted = true, bool $useAnd = true)
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
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    /**
     * Creates a new one model
     *
     * @param int|Event $event Event's identifier of the event object
     * @param string $name Name of the product
     * @param string $managerName Manager's name for the product @see ProductManager
     * @param string $unit Units that will be used in orders, for example
     * @param array $config Configuration for the other attributes, for example ['EnableCoupon' => true]
     *
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

    public function tableName()
    {
        return 'PayProduct';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, 'event\models\Event', 'EventId'],
            'Attributes' => [self::HAS_MANY, 'pay\models\ProductAttribute', 'ProductId'],
            'Prices' => [self::HAS_MANY, 'pay\models\ProductPrice', 'ProductId', 'order' => '"Prices"."StartTime" ASC'],
            'PricesActive' => [self::HAS_MANY, 'pay\models\ProductPrice', 'ProductId', 'order' => '"PricesActive"."StartTime" ASC', 'condition' => '("PricesActive"."EndTime" IS NULL OR "PricesActive"."EndTime" >  now())'],
            'UserAccess' => [self::HAS_MANY, 'pay\models\ProductUserAccess', 'ProductId']
        ];
    }

    /**
     * @return BaseProductManager
     */
    public function getManager()
    {
        if ($this->manager === null) {
            $manager = '\pay\components\managers\\'.$this->ManagerName;
            $this->manager = new $manager($this);
        }

        return $this->manager;
    }

    /**
     * @return ProductAttribute[]
     */
    public function getProductAttributes()
    {
        if ($this->productAttributes === null) {
            $this->productAttributes = [];
            foreach ($this->Attributes as $attribute) {
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

    public function byEventManager()
    {
        $this->byManagerName(BaseProductManager::EVENT);
    }

    public function byFoodManager()
    {
        $this->byManagerName(BaseProductManager::FOOD);
    }

    public function byRoomManager()
    {
        $this->byManagerName(BaseProductManager::ROOM);
    }

    /**
     * Исключить менеджер комнат
     *
     * @param bool $useAnd
     *
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
     *
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
        if ($this->AdditionalAttributes == null) {
            return [];
        }

        /** @noinspection UnserializeExploitsInspection */
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
     *
     * @return bool
     */
    public function getIsTicket()
    {
        return $this->ManagerName === 'Ticket';
    }
}