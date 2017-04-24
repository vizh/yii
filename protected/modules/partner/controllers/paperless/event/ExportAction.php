<?php

namespace partner\controllers\paperless\event;

use application\components\Exception;
use application\components\helpers\ArrayHelper;
use application\models\paperless\DeviceSignal;
use application\models\paperless\Event as EventModel;
use application\models\paperless\Event;
use partner\components\Action;

class ExportAction extends Action
{
    public function run($id = null)
    {
        $event = EventModel::model()
            ->findByPk($id);

        if ($event === null) {
            throw new Exception(404);
        }

        $signals = DeviceSignal::model()
            ->byDeviceNumber(ArrayHelper::getColumn($event->DeviceLinks, 'DeviceId'))
            ->with(['Participant' => ['with' => ['User' => ['with' => ['Employments', 'Settings', 'LinkPhones']]]]])
            ->orderBy(['"t"."Id"' => SORT_DESC])
            ->findAll();

        $fmem = fopen('php://memory', 'wb');

        // Заголовки
        fputcsv($fmem, ['##', 'Дата и время', 'RUNET-ID', 'Ф.И.О.', 'Компания', 'Должность', 'Email', 'Телефон'], ';');

        foreach ($signals as $signal) {
            if ($signal->Processed === true && $signal->Participant !== null) {
                $user = $signal->Participant->User;
                $work = $user->getEmploymentPrimary();
                $data = [
                    $signal->Id,
                    $signal->ProcessedTime,
                    $user->RunetId,
                    $user->getFullName(),
                    $work->Company->Name,
                    $work->Position,
                    $user->Email,
                    $user->getPhone()
                ];
                fputcsv($fmem, $data, ';');
            }
        }

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$event->Subject.'.csv";');
        header('Content-Transfer-Encoding: binary');

        // Пишем UTF8 BOM
        echo "\xEF\xBB\xBF";

        fseek($fmem, 0);
        fpassthru($fmem);

        exit;
    }
}