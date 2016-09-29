<?php

namespace application\extensions\behaviors;

use application\components\CDbCriteria;
use CActiveRecordBehavior;

class DeletableBehavior extends CActiveRecordBehavior
{
    protected function beforeDelete($event)
    {
        $model = $this->owner;

        $model->setAttribute('Deleted', true);
        $model->setAttribute('DeletionTime', 'NOW()');
        $model->save();

        return false;
    }

    protected function beforeFind($event)
    {
        CDbCriteria::create()
            ->addCondition('not Deleted')
            ->apply($this->owner);
    }

    public static function getMigrationFields()
    {
        return [
            'Deleted' => 'BOOLEAN NOT NULL DEFAULT false',
            'DeleteTime' => 'TIMESTAMP WITHOUT TIME ZONE DEFAULT NULL',
        ];
    }
}