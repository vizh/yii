<?php

class m150915_121515_user_referer_table extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->createTable('UserReferral', [
            'Id' => 'serial PRIMARY KEY',
            'UserId' => 'integer NULL',
            'ReferrerUserId' => 'integer NOT NULL',
            'EventId' => 'integer NOT NULL',
            'CreationTime' => 'timestamp NULL DEFAULT (\'now\'::text)::timestamp(0) without time zone'
        ]);
        $this->addForeignKey('UserReferral_UserId_fkey', 'UserReferral', 'UserId', 'User', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('UserReferral_ReferrerUserId_fkey', 'UserReferral', 'ReferrerUserId', 'User', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('UserReferral_EventId_fkey', 'UserReferral', 'EventId', 'Event', 'Id', 'RESTRICT', 'RESTRICT');

        $this->createTable('PayReferralDiscount', [
            'Id' => 'serial PRIMARY KEY',
            'EventId' => 'integer NOT NULL',
            'ProductId' => 'integer NULL',
            'Discount' => 'integer NOT NULL',
            'CreationTime' => 'timestamp NULL DEFAULT (\'now\'::text)::timestamp(0) without time zone',
            'StartTime' => 'timestamp NULL',
            'EndTime' => 'timestamp NULL'
        ]);
        $this->addForeignKey('PayReferralDiscount_EventId_fkey', 'PayReferralDiscount', 'EventId', 'Event', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('PayReferralDiscount_ProductId_fkey', 'PayReferralDiscount', 'ProductId', 'PayProduct', 'Id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('UserReferral_UserId_fkey', 'UserReferral');
        $this->dropForeignKey('UserReferral_ReferrerUserId_fkey', 'UserReferral');
        $this->dropTable('UserReferral');
        $this->dropForeignKey('PayReferralDiscount_EventId_fkey', 'PayReferralDiscount');
        $this->dropForeignKey('PayReferralDiscount_ProductId_fkey', 'PayReferralDiscount');
        $this->dropTable('PayReferralDiscount');
    }
}