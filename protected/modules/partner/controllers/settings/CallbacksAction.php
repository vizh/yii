<?php

namespace partner\controllers\settings;

use application\components\Exception;
use partner\components\Action;
use partner\models\PartnerCallback;
use Yii;

class CallbacksAction extends Action
{
    public function run()
    {
        $callbacks = $this
            ->getAvailableCallbacks()
            ->findAll();

        // Создаём, если ничего не нашлось
        if (empty($callbacks)) {
            $callbacks[] = new PartnerCallback();
        }

        // Передаём инициализационные данные для клиентской части
        $this->addScriptData('Callbacks', $callbacks);
        $this->addScriptData('CurrentPartner', Yii::app()->partner->getAccount());

        $this->getController()->render('callbacks');
    }

    public function runAjaxUpdate()
    {
        $callback = $this
            ->getAvailableCallbacks((int)Yii::app()->getRequest()->getPost('Id'))
            ->find();

        if ($callback === null) {
            $callback = new PartnerCallback();
            $callback->EventId = $this->getEvent()->Id;
            $callback->PartnerId = Yii::app()->partner->Id;
        }

        $callback->setAttributes($_POST);

        if (false === $callback->save()) {
            throw new Exception($callback);
        }

        $this->renderSuccessJson();
    }

    public function runAjaxList()
    {
        $callbacks = $this
            ->getAvailableCallbacks()
            ->findAll();

        $this->renderJson($callbacks);
    }

    /**
     * Возвращает список обратных вызовов доступных для текущего пользователя.
     * Если указан $id, то выборка уточняется до конкретного обратного вызова.
     *
     * @param int|null $id
     *
     * @return PartnerCallback
     */
    private function getAvailableCallbacks($id = 0)
    {
        $partner = Yii::app()
            ->partner
            ->getAccount();

        $callbacks = PartnerCallback::model()
            ->byEventId($this->getEvent()->Id);

        // Определим уровень доступа текущего партнёра.
        // Для рассширенных показываем все обратные вызовы для их мероприятий.
        if (false === $partner->getIsExtended()) {
            $callbacks->byPartnerId($partner->Id);
        }

        if ($id !== 0) {
            $callbacks->byId($id);
        }

        return $callbacks;
    }
}