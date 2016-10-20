<?php
namespace pay\components\handlers\order\activate;

class Forinnovations16 extends Base
{
    /**
     * @return string
     */
    public function getLayoutName()
    {
        return 'oi16';
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return 'support@forinnovations.ru';
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return 'Open Innovations 2016';
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        if ($this->order->Type == \pay\models\OrderType::Receipt) {
            return 'Успешная оплата квитанции на участие в форуме '.$this->event->Title;
        } elseif ($this->order->Type == \pay\models\OrderType::Juridical) {
            return 'Успешная оплата счета на участие в форуме '.$this->event->Title;
        }

        return 'Успешная оплата участия в форуме '.$this->event->Title;
    }

    /**
     * @inheritdoc
     */
    protected function getJuridicalViewPath()
    {
        return $this->getPhysicalViewPath();
    }

    /**
     * @inheritdoc
     */
    protected function getPhysicalViewPath()
    {
        return 'pay.views.mail.order.activate.forinnovations16';
    }

    /**
     * @inheritdoc
     */
    public function showFooter()
    {
        return false;
    }

}