<?php
use mail\models\Template;
use application\components\console\BaseConsoleCommand;
use mail\components\mailers\MandrillMailer;
use user\models\User;

class MailCommand extends BaseConsoleCommand
{
    public function actionIndex($args)
    {
        $startTime = time();
        /** @var Template $template */
        $template = Template::model()->byActive()->bySuccess(false)->find(['order' => '"t"."Id" ASC']);
        if ($template === null)
            return 0;

        while (true) {
            $template->send();
            if ($template->Success || time() - $startTime >= 180)
                return 0;
        }

        return 1;
    }

    /**
    public function actionClearRejects($args)
    {
        $path = \Yii::getPathOfAlias('mail.data.rejects') . '.csv';
        $handle = fopen($path, "r");

        $criteria = new \CDbCriteria();
        $criteria->with = ['Settings'];
        $criteria->addCondition('NOT "Settings"."UnsubscribeAll"');

        $count = 0;

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            $email = $row[0];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }
            $users = User::model()->byEmail($email)->findAll($criteria);
            if (!empty($users)) {
                foreach ($users as $user) {
                    $user->Settings->UnsubscribeAll = true;
                    $user->Settings->save();
                }
                $count++;
                var_dump($email);
            }
        }
        echo $count;

    }***/
}