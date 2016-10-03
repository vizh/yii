<?php
namespace application\components\attribute;

use application\components\AbstractDefinition;
use CActiveRecord;
use event\components\UserDataManager;

class ModelDefinition extends AbstractDefinition
{
    public $className;
    public $valueAttributeName;

    /**
     * @inheritdoc
     */
    public function getPrintValue(UserDataManager $manager, $useHtml = false)
    {
        $model = CActiveRecord::model($this->className)
            ->findByPk($manager->{$this->name});

        return $model !== null
            ? $model->{$this->valueAttributeName}
            : null;
    }

}