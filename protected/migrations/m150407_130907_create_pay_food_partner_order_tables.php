<?php

class m150407_130907_create_pay_food_partner_order_tables extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('PayFoodPartnerOrder', [
            'Id' => 'serial PRIMARY KEY',
            'Name' => 'varchar(255) NOT NULL',
            'Address' => 'varchar(255) NOT NULL',
            'INN' => 'varchar(255) NOT NULL',
            'KPP' => 'varchar(255) NOT NULL',
            'BankName' => 'varchar(255) NOT NULL',
            'Account' => 'varchar(255) NOT NULL',
            'CorrespondentAccount' => 'varchar(255) NOT NULL',
            'BIK' => 'varchar(255) NOT NULL',
            'ChiefName' => 'varchar(255) NOT NULL',
            'ChiefPosition' => 'varchar(255) NOT NULL',
            'ChiefNameP' => 'varchar(255) NOT NULL',
            'ChiefPositionP' => 'varchar(255) NOT NULL',
            'CreationTime' => 'timestamp DEFAULT (\'now\'::text)::timestamp(0) without time zone',
            'Paid' => 'boolean DEFAULT false',
            'PaidTime' => 'timestamp NULL',
            'Deleted' => 'boolean DEFAULT false',
            'DeletionTime' => 'timestamp NULL',
            'StatuteTitle' => 'varchar(255)',
            'RealAddress' => 'varchar(255)',
            'EventId' => 'integer NOT NULL',
            'Number' => 'varchar(255) NOT NULL',
            'Owner' => 'varchar(255) NOT NULL'
        ]);
        $this->addForeignKey('PayFoodPartnerOrder_EventId_fkey', 'PayFoodPartnerOrder', 'EventId', 'Event', 'Id', 'RESTRICT', 'RESTRICT');

        $this->createTable('PayFoodPartnerOrderItem', [
            'Id' => 'serial PRIMARY KEY',
            'ProductId' => 'integer NOT NULL',
            'Paid' => 'boolean DEFAULT false',
            'PaidTime' => 'timestamp NULL',
            'Deleted' => 'boolean DEFAULT false',
            'DeletionTime' => 'timestamp NULL',
            'OrderId' => 'integer NULL',
            'Count' => 'integer DEFAULT 0',
            'CreationTime' => 'timestamp DEFAULT (\'now\'::text)::timestamp(0) without time zone',
        ]);
        $this->addForeignKey('PayFoodPartnerOrderItem_ProductId_fkey', 'PayFoodPartnerOrderItem', 'ProductId', 'PayProduct', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('PayFoodPartnerOrderItem_OrderId_fkey', 'PayFoodPartnerOrderItem', 'OrderId', 'PayFoodPartnerOrder', 'Id', 'RESTRICT', 'RESTRICT');
        return true;
    }

    public function safeDown()
    {
        /*
        $this->dropForeignKey('PayFoodPartnerOrder_EventId_fkey', 'PayFoodPartnerOrder');
        $this->dropTable('PayFoodPartnerOrder');
        $this->dropForeignKey('PayFoodPartnerOrderItem_ProductId_fkey', 'PayFoodPartnerOrderItem');
        $this->dropForeignKey('PayFoodPartnerOrderItem_OrderId_fkey', 'PayFoodPartnerOrderItem');
        $this->dropTable('PayFoodPartnerOrderItem');
        */
        return false;
    }
}