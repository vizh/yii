<?php

class m150624_112448_create_user_document_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('UserDocumentType', [
            'Id' => 'serial PRIMARY KEY',
            'Title' => 'varchar(255) NOT NULL',
            'FormName' => 'varchar(255) NOT NULL'
        ]);

        $this->insert('UserDocumentType', [
            'Title' => 'Паспорт',
            'FormName' => 'Passport'
        ]);

        $this->insert('UserDocumentType', [
            'Title' => 'Заграничный паспорт',
            'FormName' => 'ForeignPassport'
        ]);

        $this->createTable('UserDocument', [
            'Id' => 'serial PRIMARY KEY',
            'TypeId' => 'integer NOT NULL',
            'UserId' => 'integer NOT NULL',
            'Attributes' => 'json NOT NULL',
            'Actual' => 'boolean DEFAULT true',
            'CreationTime' => 'timestamp NULL DEFAULT (\'now\'::text)::timestamp(0) without time zone',
        ]);

        $this->addForeignKey('UserDocument_TypeId_fkey', 'UserDocument', 'TypeId', 'UserDocumentType', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('UserDocument_UserId_fkey', 'UserDocument', 'UserId', 'User', 'Id', 'RESTRICT', 'RESTRICT');

        $this->execute('
            CREATE FUNCTION "CheckUserDocumentActual"() RETURNS TRIGGER AS $UserDocument$
                BEGIN
                    IF NEW."Actual" THEN
                        UPDATE "public"."UserDocument"
                        SET "Actual" = FALSE
                        WHERE "UserId" = NEW."UserId" AND "TypeId" = NEW."TypeId" AND "Id" != NEW."Id";
                    END IF;
                    RETURN NEW;
                END;
            $UserDocument$ LANGUAGE plpgsql;
        ');

        $this->execute('
            CREATE TRIGGER "CheckActual"
            AFTER INSERT OR UPDATE ON "public"."UserDocument"
            FOR EACH ROW
            EXECUTE PROCEDURE "CheckUserDocumentActual"();
        ');
    }

    public function safeDown()
    {
        $this->dropForeignKey('UserDocument_TypeId_fkey', 'UserDocument');
        $this->dropForeignKey('UserDocument_UserId_fkey', 'UserDocument');
        $this->dropTable('UserDocumentType');
        $this->execute('DROP TRIGGER "CheckActual" ON "public"."UserDocument"');
        $this->execute('DROP FUNCTION "CheckUserDocumentActual"()');
        $this->dropTable('UserDocument');
    }
}