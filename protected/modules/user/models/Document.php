<?php
namespace user\models;

use application\components\ActiveRecord;
use user\models\forms\document\BaseDocument;

/**
 * This is the model class for table "UserDocument".
 *
 * The followings are the available columns in table 'UserDocument':
 * @property integer $Id
 * @property integer $TypeId
 * @property integer $UserId
 * @property string $Attributes
 * @property bool $Actual
 * @property string $CreationTime
 *
 * The followings are the available model relations:
 * @property DocumentType $Type
 * @property User $User
 *
 * @method Document byTypeId(integer $typeId)
 * @method Document byUserId(integer $userId)
 * @method Document byActual(boolean $actual)
 *
 * @method Document[] findAll()
 * @method Document find()
 */
class Document extends ActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Document the static model class
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
        return 'UserDocument';
    }


    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'Type' => [self::BELONGS_TO, '\user\models\DocumentType', 'TypeId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
        ];
    }

    /**
     * Возаращет форму для редактирования документа
     * @param User $user
     * @return BaseDocument
     */
    public function getForm(User $user)
    {
        return $this->Type->getForm($user, $this);
    }

}