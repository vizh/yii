<?php

class m150810_100323_pay_coupon_modify extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute('UPDATE "PayCoupon" SET "Discount" = "Discount" * 100');
        $this->addColumn('PayCoupon', 'ManagerName', 'string NOT NULL DEFAULT \'Percent\'');
        $this->createTable('PayCollectionCouponLinkProduct', [
            'CollectionCouponId' => 'integer',
            'ProductId' => 'integer',
            'PRIMARY KEY ("CollectionCouponId", "ProductId")'
        ]);
        $this->addForeignKey('PayCollectionCouponLinkProduct_CouponId_fkey', 'PayCollectionCouponLinkProduct', 'CollectionCouponId', 'PayCollectionCoupon', 'Id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('PayCollectionCouponLinkProduct_ProductId_fkey', 'PayCollectionCouponLinkProduct', 'ProductId', 'PayProduct', 'Id', 'RESTRICT', 'RESTRICT');

        $attributes = \pay\models\CollectionCouponAttribute::model()->byName('Products')->findAll();
        foreach ($attributes as $attribute) {
            foreach (explode(',', $attribute->Value) as $id) {
                $link = new \pay\models\CollectionCouponLinkProduct();
                $link->ProductId = $id;
                $link->CollectionCouponId = $attribute->CollectionCouponId;
                $link->save();
            }
        }
    }

    public function safeDown()
    {
        $this->dropColumn('PayCoupon', 'ManagerName');
        $this->dropForeignKey('PayCollectionCouponLinkProduct_CouponId_fkey', 'PayCollectionCouponLinkProduct');
        $this->dropForeignKey('PayCollectionCouponLinkProduct_ProductId_fkey', 'PayCollectionCouponLinkProduct');
        $this->dropTable('PayCollectionCouponLinkProduct');
    }
}