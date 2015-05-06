<?php
namespace pay\models;
use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $ProductId
 * @property string $Name
 * @property string $Value
 *
 * @property Product $Product
 */
class ProductAttribute extends ActiveRecord
{
    protected $useSoftDelete = true;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'PayProductAttribute';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return array(
            'Product' => array(self::BELONGS_TO, '\pay\models\Product', 'ProductId')
        );
    }

    /**
     *
     * @param int $productId
     * @param bo0l $useAnd
     * @return \pay\models\ProductAttribute
     */
    public function byProductId($productId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."ProductId" = :ProductId';
        $criteria->params = array('ProductId' => $productId);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     *
     * @param string $name
     * @param bool $useAnd
     * @return \pay\models\ProductAttribute
     */
    public function byName($name, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Name" = :Name';
        $criteria->params = array('Name' => $name);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
}
