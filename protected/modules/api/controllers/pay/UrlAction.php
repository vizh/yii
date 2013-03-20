<?php
namespace api\controllers\pay;

class UrlAction extends \api\components\Action
{
  public function run()
  {
    $result = new \stdClass();
    $result->Url = \Yii::app()->createAbsoluteUrl('/pay/cabinet/index', array('eventIdName' => $this->getAccount()->Event->IdName));
    $this->setResult($result);
  }
}
