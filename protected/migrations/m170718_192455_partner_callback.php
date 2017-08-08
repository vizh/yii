<?php

class m170718_192455_partner_callback extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('PartnerCallback', 'PartnerId', 'integer NOT NULL DEFAULT 57');
        $this->addForeignKey('fk_PartnerCallback_PartnerAccount', 'PartnerCallback', 'PartnerId', 'PartnerAccount', 'Id', 'cascade', 'cascade');
        $this->createIndex('PartnerCallback_EventId_PartnerId_idx', 'PartnerCallback', ['EventId', 'PartnerId']);

        $this->execute('ALTER TABLE "PartnerCallback" ADD COLUMN "TempPayCallback" varchar(1000) default NULL');
        /** @noinspection SqlResolve */
        $this->execute('UPDATE "PartnerCallback" set "TempPayCallback" = "PayCallback"');
        /** @noinspection SqlResolve */
        $this->execute('ALTER TABLE "PartnerCallback" DROP COLUMN "PayCallback" CASCADE');
        /** @noinspection SqlResolve */
        $this->execute('ALTER TABLE "PartnerCallback" RENAME COLUMN "TempPayCallback" TO "PayCallback"');

        $this->execute('ALTER TABLE "PartnerCallback" ALTER COLUMN "PartnerId" DROP DEFAULT');
        $this->renameColumn('PartnerCallback', 'PayCallback', 'OnOrderPaid');
        $this->addColumn('PartnerCallback', 'OnCouponActivate', 'varchar(1000) DEFAULT NULL');
        $this->addColumn('PartnerCallback', 'OnOrderItemRefund', 'varchar(1000) DEFAULT NULL');
        $this->addColumn('PartnerCallback', 'OnOrderItemChangeOwner', 'varchar(1000) DEFAULT NULL');

        $this->dropColumn('PartnerCallback', 'ExternalKey');
        $this->dropColumn('PartnerCallback', 'TryPayCallback');
        $this->dropColumn('PartnerCallback', 'OrderItemCallback');
        $this->dropColumn('PartnerCallback', 'RegisterCallback');

        $this->dropTable('PartnerCallbackUser');
    }

    public function safeDown()
    {
        $this->dropIndex('PartnerCallback_EventId_PartnerId_idx', 'PartnerCallback');
        $this->dropForeignKey('fk_PartnerCallback_PartnerAccount', 'PartnerCallback');
        $this->dropColumn('PartnerCallback', 'PartnerId');
        $this->dropColumn('PartnerCallback', 'OnOrderItemRefund');
        $this->dropColumn('PartnerCallback', 'OnOrderItemChangeOwner');
        $this->dropColumn('PartnerCallback', 'OnCouponActivate');
        $this->renameColumn('PartnerCallback', 'OnOrderPaid', 'PayCallback');

        $this->addColumn('PartnerCallback', 'ExternalKey', 'varchar(255) DEFAULT NULL');
        $this->addColumn('PartnerCallback', 'TryPayCallback', 'varchar(1000) DEFAULT NULL');
        $this->addColumn('PartnerCallback', 'OrderItemCallback', 'varchar(1000) DEFAULT NULL');
        $this->addColumn('PartnerCallback', 'RegisterCallback', 'varchar(1000) DEFAULT NULL');

        $this->execute('
            create table "PartnerCallbackUser"
            (
                "Id" serial not null
                    constraint "PartnerCallbackUser_pkey"
                        primary key,
                "PartnerCallbackId" integer,
                "UserId" integer,
                "Key" varchar(255),
                "CreationTime" timestamp default (\'now\'::text)::timestamp(0) without time zone
            )
        ');
    }
}
