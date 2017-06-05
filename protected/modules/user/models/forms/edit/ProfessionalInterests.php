<?php
namespace user\models\forms\edit;

class ProfessionalInterests extends \CFormModel
{
    private $_names = null;

    public function attributeNames()
    {
        if ($this->_names == null) {
            $this->_names = array_keys($this->getProfessionalInterestList());
        }
        return $this->_names;
    }

    private $_values = null;

    public function __get($name)
    {
        if (in_array($name, $this->attributeNames())) {
            return isset($this->_values[$name]) ? $this->_values[$name] : null;
        }
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->attributeNames())) {
            $this->_values[$name] = $value;
        } else {
            parent::__set($name, $value);
        }
    }

    public function rules()
    {
        return [
            [implode(',', $this->attributeNames()), 'safe']
        ];
    }

    /**
     *
     * @return string[]
     */
    public function getProfessionalInterestList()
    {
        return \CHtml::listData(\application\models\ProfessionalInterest::model()->getOrderedList(), 'Code', 'Title');
    }
}
