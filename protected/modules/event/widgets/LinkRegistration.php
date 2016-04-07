<?php
namespace event\widgets;

use event\components\Widget;
use event\components\WidgetPosition;

/**
 * Class LinkRegistration
 *
 * @property string $LinkRegistration
 *
 */
class LinkRegistration extends Widget
{
    /**
     * @inheritdoc
     */
    public function getAttributeNames()
    {
        return ['LinkRegistration'];
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->getEvent()->isRegistrationClosed()) {
            return;
        }

        $this->render('linkregistration');
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Переход на страницу регистрации на сайт мероприятия');
    }

    /**
     * @inheritdoc
     */
    public function getPosition()
    {
        return WidgetPosition::Content;
    }
}
