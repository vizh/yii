<?php
namespace partner\controllers\coupon;

use application\helpers\Flash;
use partner\components\Action;
use partner\models\forms\coupon\Generate;
use pay\models\Coupon;

class GenerateAction extends Action
{
    public function run()
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        $form = new Generate($this->getEvent());
        if ($request->getIsPostRequest()) {
            $form->fillFromPost();
            $coupons = $form->createActiveRecord();
            if ($coupons !== null) {
                $success = '';
                /** @var Coupon $coupon */
                foreach ($coupons as $coupon) {
                    $success .= \CHtml::tag('li', ['class' => 'list-group-item'], $coupon->Code);
                }
                $success = \CHtml::tag('ul', ['class' => 'list-group m-top_10'], $success);
                Flash::setSuccess('<strong>'.\Yii::t('app', 'Промо-коды успешно сгенерированы').'</strong>'.$success);
                $this->getController()->refresh();
            }
        }
        $this->getController()->render('generate', [
            'form' => $form
        ]);
    }
}
