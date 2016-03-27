<?php
namespace ruvents\models;
use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Attributes
 *
 * @property string[] $EditableUserData
 * @property string[] $AvailableUserData
 *
 * @method Setting find()
 * @method Setting byEventId(int $eventId)
 */
class Setting extends ActiveRecord
{
    /**
     * @param string $className
     *
     * @return Setting
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'RuventsSetting';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        try {
            return parent::__get($name);
        } catch (\CException $e) {
            return property_exists($this->getSettings(), $name)
                ? $this->getSettings()->$name
                : null;
        }
    }

    /**
     * @inheritdoc
     */
    public function __isset($name)
    {
        if (property_exists($this->getSettings(), $name)) {
            return true;
        }
        return parent::__isset($name);
    }


    private $settings = null;

    /**
     * @return \stdClass|null
     */
    public function getSettings()
    {
        if ($this->settings === null) {
            $this->settings = json_decode($this->Attributes);
        }
        return $this->settings;
    }
}