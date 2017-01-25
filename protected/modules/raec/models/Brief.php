<?php
namespace raec\models;

use application\components\ActiveRecord;
use raec\components\BriefData;
use user\models\User;

/**
 * @property int $Id
 * @property int $UserId
 * @property string $CreationTime
 * @property string $Data
 *
 * @property User $User
 *
 * Описание вспомогательных методов
 * @method Brief   with($condition = '')
 * @method Brief   find($condition = '', $params = [])
 * @method Brief   findByPk($pk, $condition = '', $params = [])
 * @method Brief   findByAttributes($attributes, $condition = '', $params = [])
 * @method Brief[] findAll($condition = '', $params = [])
 * @method Brief[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Brief byId(int $id, bool $useAnd = true)
 * @method Brief byUserId(int $id, bool $useAnd = true)
 */
class Brief extends ActiveRecord
{
    private $briefData = null;

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
        return 'RaecBrief';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId']
        ];
    }

    /**
     * @return BriefData
     */
    public function getBriefData()
    {
        if ($this->briefData == null) {
            $this->briefData = new BriefData($this);
        }

        return $this->briefData;
    }

    /**
     * @return int
     */
    public function getCompletePercent()
    {
        $count = 0;
        $attributes = $this->getBriefData()->getAttributes();
        foreach ($attributes as $attr => $value) {
            if (!empty($value)) {
                $count++;
            }
        }

        return round($count / sizeof($attributes) * 100);
    }
}