<?php
namespace contact\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $CountryCode
 * @property string $CityCode
 * @property string $Phone
 * @property string $Addon
 * @property string $Type
 *
 * Описание вспомогательных методов
 * @method Phone   with($condition = '')
 * @method Phone   find($condition = '', $params = [])
 * @method Phone   findByPk($pk, $condition = '', $params = [])
 * @method Phone   findByAttributes($attributes, $condition = '', $params = [])
 * @method Phone[] findAll($condition = '', $params = [])
 * @method Phone[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Phone byId(int $id, bool $useAnd = true)
 * @method Phone byCountryCode(string $code, bool $useAnd = true)
 * @method Phone byCityCode(string $code, bool $useAnd = true)
 * @method Phone byPhone(string $phone, bool $useAnd = true)
 * @method Phone byAddon(string $addon, bool $useAnd = true)
 * @method Phone byType(string $type, bool $useAnd = true)
 */
class Phone extends ActiveRecord
{
    /**
     * @param string $className
     * @return Phone
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'ContactPhone';
    }

    /**
     * @param string $phone
     */
    public function parsePhone($phone)
    {
        if (preg_match('/\+(\d+)\s*(\(\d+\))\s*([\d-]+)/', $phone, $matches) > 0) {
            $this->CountryCode = $matches[1];
            $this->CityCode = !empty($matches[2]) ? trim($matches[2], '()') : null;
            $this->Phone = str_replace('-', '', $matches[3]);
        } else {
            $this->CountryCode = null;
            $this->CityCode = null;
            $this->Phone = $phone;
        }
    }

    public function __toString()
    {
        $phone = '';
        if (!empty($this->CountryCode)) {
            $phone .= '+'.$this->CountryCode.' ';
        }

        if (!empty($this->CityCode)) {
            $phone .= '('.$this->CityCode.') ';
        }

        $phone .= $this->Phone;

        if (!empty($this->Addon)) {
            $phone .= ', '.\Yii::t('app', 'доб.').' '.$this->Addon;
        }

        return $phone;
    }

    /**
     * @param forms\Phone $form
     */
    public function setAttributesFromForm(\contact\models\forms\Phone $form)
    {
        $this->CountryCode = $form->CountryCode;
        $this->CityCode = !empty($form->CityCode) ? $form->CityCode : null;
        $this->Phone = $form->Phone;
        $this->Type = $form->Type;
    }

    /**
     * @return string
     */
    public function getWithoutFormatting()
    {
        $result = $this->CountryCode;
        if (!empty($this->CityCode)) {
            $result .= $this->CityCode;
        }
        $result .= $this->Phone;

        return $result;
    }
}