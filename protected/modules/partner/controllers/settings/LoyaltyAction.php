<?php
namespace partner\controllers\settings;

use application\helpers\Flash;
use partner\components\Action;
use pay\models\forms\LoyaltyProgramDiscount as LoyaltyProgramDiscountForm;
use pay\models\LoyaltyProgramDiscount;

class LoyaltyAction extends Action
{
    public function run()
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        $form = new LoyaltyProgramDiscountForm($this->getEvent());

        $action = $request->getParam('action');
        if ($action !== null) {
            $method = 'processAction'.ucfirst($action);
            $this->$method();
            $this->getController()->redirect(['loyalty']);
        }

        if ($request->getIsPostRequest()) {
            $form->fillFromPost();
            if ($form->createActiveRecord()) {
                Flash::setSuccess(\Yii::t('app', 'Скидка успешно создана!'));
                $this->getController()->refresh();
            }
        }

        $this->getController()->render('loyalty', [
            'form' => $form,
            'discounts' => $this->getDiscounts()
        ]);
    }

    /**
     * @return LoyaltyProgramDiscount[]
     */
    private function getDiscounts()
    {
        return LoyaltyProgramDiscount::model()->byEventId($this->getEvent()->Id)
            ->with(['Product'])->orderBy(['"StartTime"' => SORT_ASC, '"EndTime"' => SORT_ASC])->findAll();
    }

    /**
     * Удаление или остановка действия скидки
     * @throws \CHttpException
     */
    private function processActionDelete()
    {
        $request = \Yii::app()->getRequest();
        $discount = LoyaltyProgramDiscount::model()->byEventId($this->getEvent()->Id)->findByPk($request->getParam('id'));
        if ($discount === null) {
            throw new \CHttpException(404);
        }

        if ($discount->getStatus() == LoyaltyProgramDiscount::StatusActive) {
            $discount->EndTime = date('Y-m-d H:i:s');
            $discount->save();
        } elseif ($discount->getStatus() == LoyaltyProgramDiscount::StatusSoon) {
            $discount->delete();
        }
    }

}
