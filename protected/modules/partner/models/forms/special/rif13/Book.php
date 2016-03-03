<?php
namespace partner\models\forms\special\rif13;

use pay\models\Product;
use user\models\User;

class Book extends \CFormModel
{
    public $DateIn;
    public $DateOut;
    public $ProductId;
    public $RunetId;
    public $BookTime;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['DateIn, DateOut, BookTime', 'date', 'format' => 'yyyy-MM-dd'],
            ['DateIn, DateOut, ProductId, RunetId, BookTime', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DateIn' => 'Дата въезда',
            'DateOut' => 'Дата выезда',
            'ProductId' => 'ID номера для проживания',
            'RunetId' => 'RUNET-ID',
            'BookTime' => 'Время брони (Y-m-d)',
        ];
    }

    public function bookRoom()
    {
        $this->BookTime .= ' 22:59:59';
        $orderItem = $this->product->getManager()->createOrderItem($this->user, $this->user, null, [
            'DateIn' => $this->DateIn,
            'DateOut' => $this->DateOut
        ]);
        $orderItem->Booked = $this->BookTime;

        $orderItem->save();

        return $orderItem->Id;
    }

    /**
     * @inheritdoc
     */
    protected function afterValidate()
    {
        parent::afterValidate();

        if ($this->DateIn > $this->DateOut) {
            $this->addError('DateIn', 'Дата въезда должна быть меньше даты выезда');
            $this->addError('DateOut', 'Дата выезда должна быть больше даты въезда');
        }

        /** @var $product Product */
        $this->product = Product::model()->findByPk($this->ProductId);
        if ($this->product === null || $this->product->ManagerName !== 'RoomProductManager' || $this->product->EventId !== \Yii::app()->partner->getEvent()->Id) {
            $this->addError('ProductId', 'Не верно задан ID номера для проживания');
        }

        $this->user = User::model()->byRunetId($this->RunetId)->find();
        if ($this->user === null) {
            $this->addError('RunetId', 'Не верно задан RUNET-ID');
        }

        if ($this->BookTime < date('Y-m-d')) {
            $this->addError('BookTime', 'Нельзя задать истекшее время бронирования');
        }
    }
}
