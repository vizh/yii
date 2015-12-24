<?php
namespace ruvents\models;
use application\components\ActiveRecord;
use user\models\User;

/**
 * This is the model class for table "RuventsVisit".
 *
 * The followings are the available columns in table 'RuventsVisit':
 * @property integer $Id
 * @property string $EventId
 * @property integer $UserId
 * @property string $MarkId
 * @property string $CreationTime
 *
 * The followings are the available model relations:
 * @property User $User
 *
 * @method Visit[] findAll()
 * @method Visit byEventId(int $id)
 */
class Visit extends ActiveRecord
{
    public $CountForCriteria = 0;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Visit the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'RuventsVisit';
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
        ];
    }
}