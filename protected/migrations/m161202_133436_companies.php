<?php

class m161202_133436_companies extends CDbMigration
{
    public function safeUp()
    {
        $this->execute("CREATE TYPE \"CompanyClusterType\" AS ENUM ('', 'РАЭК')");
        $this->addColumn('Company', 'Cluster', '"CompanyClusterType"');
        $this->createIndex('Company_Cluster_idx', 'Company', 'Cluster', false);
        // Переименуем некорректно названный существующий индекс
        $this->dropIndex('Company_Name_index', 'Company');
        $this->createIndex('Company_Name_idx', 'Company', 'Name', false);
    }

    public function safeDown()
    {
        $this->dropIndex('Company_Cluster_idx', 'Company');
        $this->dropColumn('Company', 'Cluster');
        $this->execute('DROP TYPE "CompanyClusterType"');
        // Отмена переименования некорректно названного индекса
        $this->dropIndex('Company_Name_idx', 'Company');
        $this->createIndex('Company_Name_index', 'Company', 'Name', false);
    }
}