<?php
namespace user\models;

use application\components\ActiveRecord;
use user\models\forms\document\BaseDocument;

/**
 * @property integer $Id
 * @property integer $TypeId
 * @property integer $UserId
 * @property string $Attributes
 * @property bool $Actual
 * @property string $CreationTime
 *
 * @property DocumentType $Type
 * @property User $User
 *
 * Описание вспомогательных методов
 * @method Document   with($condition = '')
 * @method Document   find($condition = '', $params = [])
 * @method Document   findByPk($pk, $condition = '', $params = [])
 * @method Document   findByAttributes($attributes, $condition = '', $params = [])
 * @method Document[] findAll($condition = '', $params = [])
 * @method Document[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Document byId(int $id, bool $useAnd = true)
 * @method Document byTypeId(int $id, bool $useAnd = true)
 * @method Document byUserId(int $id, bool $useAnd = true)
 * @method Document byActual(bool $actual = true, bool $useAnd = true)
 */
class Document extends ActiveRecord
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
        return 'UserDocument';
    }

    public function relations()
    {
        return [
            'Type' => [self::BELONGS_TO, '\user\models\DocumentType', 'TypeId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
        ];
    }

    /**
     * Возаращет форму для редактирования документа
     *
     * @param User $user
     * @return BaseDocument
     */
    public function getForm(User $user)
    {
        return $this->Type->getForm($user, $this);
    }

}