<?php

class m170413_092439_paperless_material_partner extends CDbMigration
{
	public function safeUp()
	{
	    $this->addColumn('PaperlessMaterial', 'PartnerName', 'string');
	    $this->addColumn('PaperlessMaterial', 'PartnerSite', 'string');
	    $this->addColumn('PaperlessMaterial', 'PartnerLogo', 'string');
	}

	public function safeDown()
	{
	    $this->dropColumn('PaperlessMaterial', 'PartnerName');
	    $this->dropColumn('PaperlessMaterial', 'PartnerSite');
	    $this->dropColumn('PaperlessMaterial', 'PartnerLogo');
	}
}