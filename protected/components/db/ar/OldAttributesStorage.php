<?php
namespace application\components\db\ar;

trait OldAttributesStorage
{
    /**
     * @inheritdoc
     */
    protected function afterFind()
    {
        $this->oldAttributes = $this->getAttributes();
        parent::afterFind();
    }

    protected $oldAttributes = [];

    /**
     * Устанавливает значения атрибутов до измнения модели
     * @param $value
     */
    public function setOldAttributes($value)
    {
        $this->oldAttributes = $value;
    }

    /**
     * Возвращает значение атрибутов до изменения модели
     * @return array
     */
    public function getOldAttributes()
    {
        return $this->oldAttributes;
    }
} 