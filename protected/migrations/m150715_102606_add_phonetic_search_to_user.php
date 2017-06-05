<?php

class m150715_102606_add_phonetic_search_to_user extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->addColumn('User', 'SearchFirstName', 'tsvector');
        $this->addColumn('User', 'SearchLastName', 'tsvector');
        $this->execute('CREATE INDEX "User_FirstName_idx" ON "User" USING BTREE("FirstName")');
        $this->execute('CREATE INDEX "User_SearchFirstName_idx" ON "User" USING GIN("SearchFirstName")');
        $this->execute('CREATE INDEX "User_LastName_idx" ON "User" USING BTREE("LastName")');
        $this->execute('CREATE INDEX "User_SearchLastName_idx" ON "User" USING GIN("SearchLastName")');

        /** @var \CDbCommand $command */
        $offset = 0;
        $users = [];
        do {
            $command = \Yii::app()->getDb()->createCommand();
            $command->from('User');
            $command->order = 'Id ASC';
            $command->andWhere('"User"."Visible"');
            $command->offset = $offset;
            $command->limit = 1000;
            $users = $command->queryAll();

            foreach ($users as $user) {
                $command->update('User', [
                    'SearchFirstName' => new \CDbExpression('to_tsvector(\''.\application\components\utility\PhoneticSearch::getIndex($user['FirstName']).'\')'),
                    'SearchLastName' => new \CDbExpression('to_tsvector(\''.\application\components\utility\PhoneticSearch::getIndex($user['LastName']).'\')')
                ], '"Id" = '.$user['Id']);
            }
            $offset += 1000;
            echo $offset.'<br/>';
        } while (!empty($users));
    }

    public function safeDown()
    {
        $this->dropIndex('User_FirstName_idx', 'User');
        $this->dropIndex('User_SearchFirstName_idx', 'User');
        $this->dropIndex('User_LastName_idx', 'User');
        $this->dropIndex('User_SearchLastName_idx', 'User');
        $this->dropColumn('User', 'SearchFirstName');
        $this->dropColumn('User', 'SearchLastName');
    }
}