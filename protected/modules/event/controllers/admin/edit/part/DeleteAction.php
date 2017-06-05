<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alaris
 * Date: 26/01/15
 * Time: 14:30
 */

namespace event\controllers\admin\edit\part;

use event\models\Part;

class DeleteAction extends \CAction
{
    public function run($eventId, $partId)
    {
        $part = Part::model()->findByPk($partId);
        if ($part == null || $part->EventId != $eventId) {
            throw new \CHttpException(404);
        }

        echo 'Не реализовано, требует проверки статусов у участников и путей разрешения конфликтов';
    }
}