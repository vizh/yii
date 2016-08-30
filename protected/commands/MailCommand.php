<?php
use mail\models\Template;
use application\components\console\BaseConsoleCommand;
use mail\components\mailers\MandrillMailer;
use user\models\User;

class MailCommand extends BaseConsoleCommand
{
    public function actionIndex()
    {
        for ($i=0; $i<10; $i++) {
            $pid = pcntl_fork();
            if ($pid == 0){

                Yii::log('worker #'.posix_getpid().' started', \CLogger::LEVEL_INFO, 'mail');
                Yii::getLogger()->flush(true);

                /** @var Template $template */
                $template = Template::model()->byActive()->bySuccess(false)->find(['order' => '"t"."Id" ASC']);
                if ($template) {
                    Yii::log('worker #'.posix_getpid().' sending template #'.$template->Id, \CLogger::LEVEL_INFO, 'mail');
                    Yii::getLogger()->flush(true);

                    $template->send();
                }

                Yii::log('worker #'.posix_getpid().' done', \CLogger::LEVEL_INFO, 'mail');
                Yii::getLogger()->flush(true);

                exit;
            }
        }
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