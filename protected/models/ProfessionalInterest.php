<?php
namespace application\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Code
 * @property string $Title
 * @property string $Description
 * @property string $En
 *
 * @method ProfessionalInterest findByPk()
 */
class ProfessionalInterest extends ActiveRecord
{
    /**
     * @inheritDoc
     */
    protected $defaultOrderBy = ['"t"."Title"' => SORT_ASC];

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
        return 'ProfessionalInterest';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [];
    }

    public function getOrderedList()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."Title" ASC';
        return $this->findAll($criteria);
    }
}
