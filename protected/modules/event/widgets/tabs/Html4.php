<?php
namespace event\widgets\tabs;

/**
 * Class Html
 * @package event\widgets\tabs
 *
 * @property string $TabTitle4
 * @property string $TabContent4
 */
class Html4 extends \event\components\Widget
{
    public function getAttributeNames()
    {
        return ['TabTitle4', 'TabContent4'];
    }

    public function run()
    {
        $this->render('html', ['TabContent' => $this->TabContent4]);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return isset($this->TabTitle4) ? $this->TabTitle4 : 'Таб 4';
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