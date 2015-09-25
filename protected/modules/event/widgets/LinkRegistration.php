<?php
namespace event\widgets;

/**
 * Class LinkRegistration
 * @package event\widgets
 *
 * @property string $LinkRegistration
 */
class LinkRegistration extends \event\components\Widget
{
    public function getAttributeNames()
    {
        return ['LinkRegistration'];
    }


    public function run()
    {
        if ($this->getEvent()->isRegistrationClosed()) {
            return;
        }
        $this->render('linkregistration');
    }


    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Переход на страницу регистрации на сайт мероприятия');
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return \event\components\WidgetPosition::Content;
    }
}