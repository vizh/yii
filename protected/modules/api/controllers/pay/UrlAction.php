<?php

namespace api\controllers\pay;

use api\components\Action;
use Yii;

class UrlAction extends Action
{
    public function run()
    {
        $this->setResult((object)[
            'Url' => Yii::app()->createAbsoluteUrl('/pay/cabinet/auth', [
                'eventIdName' => $this->getEvent()->IdName,
                'runetId' => $this->getRequestedPayer()->RunetId,
                'hash' => $this->getRequestedPayer()->getHash()
            ])
        ]);
    }
}
