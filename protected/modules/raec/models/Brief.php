<?php
namespace raec\models;
use raec\components\BriefData;
use raec\models\forms\brief\About;
use raec\models\forms\brief\Resume;
use raec\models\forms\brief\Users;
use user\models\User;

/**
 * Class Brief
 * @property int $Id
 * @property int $UserId
 * @property string $CreationTime
 * @property string $Data
 * @property User $User
 * @package raec\models
 */
class Brief extends \CActiveRecord
{
    /**
     * @param string $className
     * @return Brief
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'RaecBrief';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId']
        ];
    }

    private $briefData = null;

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