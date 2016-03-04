<?php
namespace pay\models\forms\admin;

use user\models\User;

/**
 * Class UserBooking
 */
class UserBooking extends \CFormModel
{
    /**
     * @var int RunetId of the user
     */
    public $RunetId;

    /**
     * @var string
     */
    public $DateIn;

    /**
     * @var string
     */
    public $DateOut;

    /**
     * @var string
     */
    public $Booked;

    /**
     * @var User Current user
     */
    private $user;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['RunetId, DateIn, DateOut, Booked', 'required'],
            ['DateIn, DateOut, Booked', 'date', 'allowEmpty' => false, 'format' => 'yyyy-MM-dd'],
            [
                'RunetId',
                'exist',
                'className' => User::className(),
                'attributeName' => 'RunetId',
                'criteria' => ['condition' => '"Visible"'],
                'message' => \Yii::t('app', 'Пользователь с таким RunetId не найден в системе.')
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Owner' => 'Название',
            'DateIn' => 'Дата заезда',
            'DateOut' => 'Дата выезда',
            'Booked' => 'Бронь до'
        ];
    }

    /**
     * @inheritdoc
     */
    protected function afterValidate()
    {
        parent::afterValidate();

        $this->user = User::model()->byRunetId($this->RunetId)->byVisible(true)->find();
    }
}
