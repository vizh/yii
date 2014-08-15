<?php
class TicketController extends application\components\controllers\PublicMainController
{
    public $layout = '//layouts/ticket';

    /** @var \event\models\Event */
    protected $event = null;

    public function actionIndex($eventIdName, $runetId, $hash)
    {
        $this->event = \event\models\Event::model()->byIdName($eventIdName)->find();
        $user  = \user\models\User::model()->byRunetId($runetId)->find();

        if ($this->event == null || $user == null)
            throw new \CHttpException(404);

        $orderItems = \pay\models\OrderItem::model()
            ->byOwnerId($user->Id)->byChangedOwnerId(null)->byChangedOwnerId($user->Id, false)
            ->byEventId($this->event->Id)->byPaid(true)->findAll();

        $params = ['event' => $this->event, 'user' => $user, 'orderItems' => $orderItems];
        $model = \event\models\Participant::model()->byUserId($user->Id)->byEventId($this->event->Id);
        if (count($this->event->Parts) == 0) {
            $participant = $model->find();
            if ($participant == null || $participant->getHash() !== $hash)
                throw new \CHttpException(404);
            $params['role'] = $participant->Role;
        } else {
            $participants = $model->findAll([
                'with' => ['Part' => ['together' => true]],
                'order' => '"Part"."Order"'
            ]);
            if (count($participants) == 0 || $participants[0]->getHash() !== $hash)
                throw new \CHttpException(404);
            $params['participants'] = $participants;
        }
        $this->renderTicket($params);
    }

    protected function renderTicket($params)
    {
        $path = \Yii::getPathOfAlias('event.views.ticket.'.$this->event->IdName).'.php';
        $view = file_exists($path) ? $this->event->IdName : 'index';
        $this->setPageTitle(\Yii::t('app', 'Ваш билет на мероприятие «{event}»', ['{event}' => $this->event->Title]));
        \Yii::app()->getClientScript()->reset();
        $this->render($view, $params);
    }
}
