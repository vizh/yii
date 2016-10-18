<?php

class m161013_004322_indexes extends CDbMigration
{
    public function up()
    {
        $this->execute('CREATE INDEX "PayOrderItem_ProductId_index" ON "PayOrderItem" USING BTREE ("ProductId")');
        $this->execute('CREATE INDEX "PayOrderItem_Paid_index" ON "PayOrderItem" USING BTREE ("Paid")');
        $this->execute('CREATE INDEX "PayOrderItem_OwnerId_index" ON "PayOrderItem" USING BTREE ("OwnerId")');
        $this->execute('CREATE INDEX "PayOrderItem_ChangedOwnerId_index" ON "PayOrderItem" USING BTREE ("ChangedOwnerId")');
        $this->execute('CREATE INDEX "PayOrderItem_Deleted_index" ON "PayOrderItem" USING BTREE ("Deleted")');
        $this->execute('CREATE INDEX "PayOrderItem_Refund_index" ON "PayOrderItem" USING BTREE ("Refund")');

        $this->execute('CREATE INDEX "UserLinkPhone_UserId_index" ON "UserLinkPhone" USING BTREE ("UserId")');
        $this->execute('CREATE INDEX "UserLinkPhone_PhoneId_index" ON "UserLinkPhone" USING BTREE ("PhoneId")');

        $this->dropIndex('Key_ParticipantUser', 'EventParticipant');

        $this->execute('CREATE INDEX "EventParticipant_PartId_index" ON "EventParticipant" USING BTREE ("PartId")');
        $this->execute('CREATE INDEX "EventParticipant_RoleId_index" ON "EventParticipant" USING BTREE ("RoleId")');

        $this->execute('CREATE INDEX "ApiExternalUser_AccountId_UserId_index" ON "ApiExternalUser" USING BTREE ("AccountId", "UserId")');
        $this->createIndex('RuventsBadge_EventId_UserId_index', 'RuventsBadge', 'EventId,UserId');
        $this->createIndex('AttributeDefinition_GroupId_index', 'AttributeDefinition', 'GroupId');
    }

    public function down()
    {
        $this->dropIndex('PayOrderItem_ProductId_index', 'PayOrderItem');
        $this->dropIndex('PayOrderItem_Paid_index', 'PayOrderItem');
        $this->dropIndex('PayOrderItem_OwnerId_index', 'PayOrderItem');
        $this->dropIndex('PayOrderItem_ChangedOwnerId_index', 'PayOrderItem');
        $this->dropIndex('PayOrderItem_Deleted_index', 'PayOrderItem');
        $this->dropIndex('PayOrderItem_Refund_index', 'PayOrderItem');

        $this->dropIndex('UserLinkPhone_UserId_index', 'UserLinkPhone');
        $this->dropIndex('UserLinkPhone_PhoneId_index', 'UserLinkPhone');

        $this->createIndex('Key_ParticipantUser', 'EventParticipant', 'UserId');

        $this->dropIndex('EventParticipant_PartId_index', 'EventParticipant');
        $this->dropIndex('EventParticipant_RoleId_index', 'EventParticipant');

        $this->dropIndex('ApiExternalUser_AccountId_UserId_index', 'ApiExternalUser');
        $this->dropIndex('RuventsBadge_EventId_UserId_index', 'RuventsBadge');
        $this->dropIndex('AttributeDefinition_GroupId_index', 'AttributeDefinition');
    }
}