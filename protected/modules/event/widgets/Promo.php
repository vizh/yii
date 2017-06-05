<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 26.08.2015
 * Time: 15:48
 */

namespace event\widgets;

use application\components\web\Widget;
use event\models\Event;

class Promo extends Widget
{
    /** @var Event */
    public $event;

    /**
     * Является ли пользователь участником мероприятия
     * @var bool
     */
    public $isCurrentUserParticipant = false;

    public function run()
    {
        $this->render('promo', ['event' => $this->event]);
    }

    /**
     * @inheritdoc
     */
    public function getIsHasDefaultResources()
    {
        return true;
    }

    /**
     * Регистрация ресурсов виджета
     */
    protected function registerDefaultResources()
    {
        if (isset($this->event->PromoBlockStyles)) {
            \Yii::app()->getClientScript()->registerCss($this->event->IdName.'promo', $this->event->PromoBlockStyles);
        }
        parent::registerDefaultResources();
    }
}