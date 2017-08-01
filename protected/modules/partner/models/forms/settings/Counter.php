<?php
namespace partner\models\forms\settings;

use application\components\form\CreateUpdateForm;
use application\helpers\Flash;
use event\models\Event;

/**
 * Class Counter
 * @package partner\models\forms\settings
 *
 * @property Event $model
 */
class Counter extends CreateUpdateForm
{
    public $Head;
    public $Body;
    public $AfterPayment;

    public function rules()
    {
        return [
            ['Head, Body, AfterPayment', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Head' => \Yii::t('app', 'HTML-код счетчиков в теге <head>'),
            'Body' => \Yii::t('app', 'HTML-код счетчиков в теге <body>'),
            'AfterPayment' => \Yii::t('app', 'HTML-код на странице после оплаты'),
        ];
    }

    /**
     * Загружает данные из модели в модель формы
     * @return bool Удалось ли загрузить данные
     */
    protected function loadData()
    {
        $this->Head = $this->model->CounterHeadHTML;
        $this->Body = $this->model->CounterBodyHTML;
        $this->AfterPayment = $this->model->AfterPaymentHTMLCode;
        return true;
    }

    /**
     * Обновляет запись в базе
     * @return \CActiveRecord|null
     * @throws Exception
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        /** @var \CDbTransaction $transaction */
        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $this->model->CounterHeadHTML = $this->Head;
            $this->model->CounterBodyHTML = $this->Body;
            $this->model->AfterPaymentHTMLCode = $this->AfterPayment;
            $this->model->save(false);
            $transaction->commit();
            return $this->model;
        } catch (\Exception $e) {
            Flash::setError($e->getMessage());
            return null;
        }
    }
}
