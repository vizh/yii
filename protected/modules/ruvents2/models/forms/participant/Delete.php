<?php

namespace ruvents2\models\Forms\Participant;

use application\components\helpers\ArrayHelper;
use event\models\Role;
use ruvents2\components\form\RequestForm;
use Yii;

class Delete extends RequestForm
{
    public $Id;

    public function rules()
    {
        return [
            ['Id', 'required'],
            ['Id', 'numerical', 'integerOnly' => true, 'min' => 1, 'max' => Yii::app()->params['RuventsMaxResults']]
        ];
    }
}