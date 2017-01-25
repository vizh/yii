<?php
namespace user\models;

use application\components\ActiveRecord;
use user\models\forms\document\BaseDocument;

/**
 * @property integer $Id
 * @property string $Title
 * @property string $FormName
 *
 * Описание вспомогательных методов
 * @method DocumentType   with($condition = '')
 * @method DocumentType   find($condition = '', $params = [])
 * @method DocumentType   findByPk($pk, $condition = '', $params = [])
 * @method DocumentType   findByAttributes($attributes, $condition = '', $params = [])
 * @method DocumentType[] findAll($condition = '', $params = [])
 * @method DocumentType[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method DocumentType byId(int $id, bool $useAnd = true)
 */
class DocumentType extends ActiveRecord
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

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'UserDocumentType';
    }

    /**
     * Возаращает форму для редактирования документа
     *
     * @param User $user
     * @param Document|null $document
     * @return BaseDocument
     */
    public function getForm(User $user = null, Document $document = null)
    {
        $class = '\user\models\forms\document\\'.$this->FormName;

        return new $class($this, $user, $document);
    }
}