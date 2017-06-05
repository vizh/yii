<?php

/**
 * Class m160531_111318_add_mail_sending_service adds field for mail's service
 */
class m160531_111318_add_mail_sending_service extends CDbMigration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('MailTemplate', 'MailerClass', 'VARCHAR(100) NOT NULL DEFAULT \'PhpMailer\'');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('MailTemplate', 'MailerClass');
    }
}
