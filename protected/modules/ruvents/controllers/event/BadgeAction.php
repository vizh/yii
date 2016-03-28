<?php
namespace ruvents\controllers\event;

use ruvents\models\Setting;
use Yii;

class BadgeAction extends \ruvents\components\Action
{
    public function run()
    {
        $setting = Setting::model()
            ->byEventId($this->getEvent()->Id)
            ->byName('badge')
            ->find();

        $viewPath = $setting === null
            ? '/badge/default'
            : $setting->Value;
        
        echo json_encode([
            'Badge' => Yii::app()->controller->renderPartial($viewPath, null, true)
        ]);
    }
}
