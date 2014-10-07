<?php
namespace application\components\attribute;

class ModelDefinition extends Definition
{
    public $className;
    public $valueAttributeName;

    /**
     * @inheritdoc
     */
    public function getPrintValue($container)
    {
        $finder = \CActiveRecord::model($this->className);
        $model = $finder->findByPk($container->{$this->name});
        if ($model !== null) {
            return $model->{$this->valueAttributeName};
        }
        return null;
    }


} 