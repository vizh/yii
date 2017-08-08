<?php
namespace pay\components\handlers\buyproduct\products;

use mail\components\Mailer;
use mail\components\MailLayout;

class Base extends MailLayout
{
    /** @var \pay\models\Product */
    protected $product;

    /** @var  \user\models\User */
    protected $owner;

    public function __construct(Mailer $mailer, \CEvent $event)
    {
        parent::__construct($mailer);
        $this->product = $event->params['product'];
        $this->owner = $event->params['owner'];
    }

    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        return 'users@runet-id.com';
    }

    /**
     * @inheritdoc
     */
    public function getTo()
    {
        return $this->owner->Email;
    }

    /**
     * @inheritdoc
     */
    public function getUser()
    {
        return $this->owner;
    }

    /**
     * @return bool
     */
    public function showUnsubscribeLink()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return 'Вами успешно был приобретен товар: ' . $this->product->Title;
    }

    /**
     * @inheritdoc
     */
    public function getBody()
    {
        $view = 'pay.views.mail.buyproduct.products.' . $this->product->Id;
        if ($this->isViewExists($view)) {
            return $this->renderBody($view, ['product' => $this->product, 'owner' => $this->owner]);
        }
        return null;
    }
}