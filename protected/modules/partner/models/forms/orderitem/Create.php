<?php
namespace partner\models\forms\orderitem;

use application\components\form\CreateUpdateForm;
use application\helpers\Flash;
use event\models\Event;
use pay\components\Exception;
use pay\models\OrderItem;
use pay\models\Product;
use user\models\User;

class Create extends CreateUpdateForm
{
    public $ProductId;

    public $Payer;

    public $Owner;

    public $OrderItem;

    /** @var \event\models\Event */
    protected $event;

    /**
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
        parent::__construct();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['Payer, Owner, ProductId', 'required'],
            ['Payer, Owner', 'exist', 'className' => '\user\models\User', 'attributeName' => 'RunetId'],
            ['ProductId', 'in', 'range' => array_keys($this->getProductData())]
        ];
    }

    /**
     * return string[]
     */
    public function getProductData()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."Title" ASC';
        $criteria->addNotInCondition('"t"."ManagerName"', ['RoomProductManager']);
        $products = Product::model()->byEventId($this->event->Id)->byDeleted(false)->findAll($criteria);
        return \CHtml::listData($products, 'Id', 'Title');
    }

    public function attributeLabels()
    {
        return [
            'ProductId' => \Yii::t('app', 'Товар'),
            'Payer' => \Yii::t('app', 'Плательщик'),
            'Owner' => \Yii::t('app', 'Получатель'),
        ];
    }

    /**
     * @return OrderItem|null
     */
    public function createActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $payer = User::model()->byRunetId($this->Payer)->find();
        $owner = User::model()->byRunetId($this->Owner)->find();

        try {
            $product = Product::model()->findByPk($this->ProductId);
            return $product->getManager()->createOrderItem($payer, $owner);
        } catch (Exception $e) {
            Flash::setError($e->getMessage());
            return null;
        }
    }

}