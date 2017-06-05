<?php
namespace event\widgets\tabs;

/**
 * Class Html
 * @package event\widgets\tabs
 *
 * @property string $TabTitle6
 * @property string $TabContent6
 */
class Html6 extends \event\components\Widget
{
    public function getAttributeNames()
    {
        return ['TabTitle6', 'TabContent6'];
    }

    public function run()
    {
        $this->render('html', ['TabContent' => $this->TabContent6]);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return isset($this->TabTitle6) ? $this->TabTitle6 : 'Таб 6';
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return \event\components\WidgetPosition::Tabs;
    }

    protected function getInternalAdminPanel()
    {
        return new \event\widgets\panels\tabs\Html($this);
    }
}