<?php
namespace event\widgets;

use event\components\WidgetPosition;

class Contacts extends \event\components\Widget
{
    public function run()
    {
        $phones = [];
        foreach ($this->event->LinkPhones as $linkPhone) {
            $phones[] = (string)$linkPhone->Phone;
        }

        $viewName = !$this->event->FullWidth ? 'contacts' : 'fullwidth/contacts';

        $this->render($viewName, [
            'phones' => $phones
        ]);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Контактная информация');
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return WidgetPosition::Sidebar;
    }
}
