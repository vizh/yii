<?php

/**
 * Class FbController
 *
 * Реализует возможность управления мероприятиями на facebook
 */
class FbController extends \application\components\controllers\AdminMainController
{
    public $layout = '/admin/layouts/simple';

    /**
     * Публикует мероприятие на Facebook
     * @param $eventId
     */
    public function actionPublish($eventId)
    {
        $this->process(function () use ($eventId) {
            $event = $this->loadModel($eventId);
            $event->fbPublish();
        });
        $this->render('publish');
    }

    /**
     * Обновляет мероприятие на Facebook
     * @param $eventId
     */
    public function actionUpdate($eventId)
    {
        $this->process(function () use ($eventId) {
            $event = $this->loadModel($eventId);
            $event->fbUpdate();
        });
        $this->render('update');
    }

    /**
     * Удаляет мероприятие с Facebook
     * @param $eventId
     */
    public function actionDelete($eventId)
    {
        $this->process(function () use ($eventId) {
            $event = $this->loadModel($eventId);
            $event->fbDelete();
        });
        $this->render('delete');
    }

    /**
     * Выполняет действия с обработкой ошибок
     * @param callable $func
     */
    private function process(callable $func)
    {
        try {
            $func();
            \Yii::app()->getClientScript()->registerScript(
                'fb-window-close',
                'setTimeout(function() {window.close(); window.opener.location.reload();}, 3000)',
                \CClientScript::POS_READY
            );
        } catch (\FacebookApiException $e) {
            $this->render('error', ['error' => 'Ошибка Facebook:<br/>'.$e->getMessage()]);
            \Yii::app()->end();
        } catch (\CException $e) {
            $this->render('error', ['error' => 'Внутренняя ошибка:<br/>'.$e->getMessage()]);
            \Yii::app()->end();
        }
    }

    /**
     * Загружает модель \event\models\Event
     * @param $eventId
     * @return \event\models\Event
     * @throws CHttpException
     */
    public function loadModel($eventId)
    {
        $event = \event\models\Event::model()->findByPk($eventId);
        if (empty($event)) {
            throw new \CHttpException(404, 'Мероприятие не найдено!');
        }

        if (!$event->Visible) {
            throw new \CHttpException(403, 'Мероприятие скрыто!');
        }

        return $event;
    }
} 