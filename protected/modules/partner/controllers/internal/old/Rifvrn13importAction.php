<?php
namespace partner\controllers\internal;

class Rifvrn13importAction extends \partner\components\Action
{
    const Path = '/files/';
    const FileName = 'rrifvrn2013-users.csv';
    const EventId = 467;

    public function run()
    {
        if (\Yii::app()->partner->getAccount()->EventId != self::EventId) {
            return;
        }

        $fieldMap = [
            'RunetId' => 0,
            'FullName' => 1,
            'Status' => 2,
        ];
        $parser = new \application\components\parsing\CsvParser($_SERVER['DOCUMENT_ROOT'].self::Path.self::FileName);
        $parser->SetInEncoding('utf-8');
        $results = $parser->Parse($fieldMap, true);

        $event = \event\models\Event::model()->findByPk(self::EventId);
        $role1 = \event\models\Role::model()->findByPk(1);
        $role3 = \event\models\Role::model()->findByPk(3);
        foreach ($results as $result) {
            $user = \user\models\User::model()->byRunetId($result->RunetId)->find();
            if ($user == null) {
                echo 'Пользователь с RunetID: '.$result->RunetId.' не найден<br/>';
            } else {
                if ($result->Status == 1) {
                    $event->registerUser($user, $role3);
                    echo 'Пользователь с RunetID: '.$result->RunetId.' докладчик<br/>';
                } else {
                    $event->registerUser($user, $role1);
                    echo 'Пользователь с RunetID: '.$result->RunetId.' участник<br/>';
                }
            }
        }
        echo 'OK!';
    }
}

?>
