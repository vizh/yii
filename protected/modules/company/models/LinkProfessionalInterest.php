<?php
namespace company\models;

use application\components\ActiveRecord;

/**
 * @property integer $CompanyId
 * @property integer $ProfessionalInterestId
 * @property bool $Primary
 *
 * Описание вспомогательных методов
 * @method LinkProfessionalInterest   with($condition = '')
 * @method LinkProfessionalInterest   find($condition = '', $params = [])
 * @method LinkProfessionalInterest   findByPk($pk, $condition = '', $params = [])
 * @method LinkProfessionalInterest   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkProfessionalInterest[] findAll($condition = '', $params = [])
 * @method LinkProfessionalInterest[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkProfessionalInterest byId(int $id, bool $useAnd = true)
 * @method LinkProfessionalInterest byCompanyId(int $id, bool $useAnd = true)
 * @method LinkProfessionalInterest byProfessionalInterestId(int $id, bool $useAnd = true)
 * @method LinkProfessionalInterest byPrimary(bool $primary, bool $useAnd = true)
 */
class LinkProfessionalInterest extends ActiveRecord
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
        return 'CompanyLinkProfessionalInterest';
    }
}