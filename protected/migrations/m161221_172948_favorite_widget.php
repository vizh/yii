<?php

use event\models\WidgetClass;

class m161221_172948_favorite_widget extends CDbMigration
{
    public function up()
    {
        $widget = new WidgetClass();
        $widget->Class = 'event\widgets\Favorite';
        $widget->save();
    }

    public function down()
    {
        WidgetClass::model()
            ->byClass('event\widgets\Favorite')
            ->find()
            ->delete();
    }
}