<?php
namespace event\widgets;

class ProfessionalInterests extends \event\components\Widget
{

    public function run()
    {
        $this->render('professionalinterests', []);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Профессиональные интересы');
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return \event\components\WidgetPosition::Sidebar;
    }
}
