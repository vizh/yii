<?php
namespace event\controllers\admin\edit\part;

use event\models\Event;

class IndexAction extends \CAction
{
    public function run($eventId)
    {
        $event = Event::model()->findByPk($eventId);
        if ($event == null) {
            throw new \CHttpException(404);
        }

        $this->getController()->render('part/index', [
            'event' => $event
        ]);
    }
}