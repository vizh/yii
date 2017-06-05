<?php
namespace partner\models\forms\orderitem;

use application\components\form\CreateUpdateForm;
use application\helpers\Flash;
use pay\components\CodeException;
use pay\models\OrderItem;

/**
 * Class Refund
 * @package partner\models\forms\orderitem
 *
 * @property OrderItem $model
 */
class Refund extends CreateUpdateForm
{
    public $Agree;

    /**
     * @return array|void
     */
    public function rules()
    {
        return [
            ['Agree', 'boolean']
        ];
    }

    public function attributeLabels()
    {
        return [
            'Agree' => \Yii::t('app', 'Я подтверждаю отмену заказа, внесение изменений в финансовую статистику мероприятия, а также отмену статуса у участника')
        ];
    }

    /**
     * @inheritdoc
     */
    public function updateActiveRecord()
    {
        if (!$this->validate() || !$this->Agree) {
            return null;
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            if (!$this->model->Product->getManager()->rollback($this->model)) {
                throw new CodeException(CodeException::ERROR_ORDER_ITEM_REFUND);
            }
            $transaction->commit();
            return $this->model;
        } catch (\Exception $e) {
            Flash::setError($e->getMessage());
            return null;
        }
    }

} 