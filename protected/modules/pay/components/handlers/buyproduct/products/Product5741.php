<?php
namespace pay\components\handlers\buyproduct\products;

use mail\models\Layout;

class Product5741 extends Base
{
    /**
     * @return string
     */
    public function getLayoutName()
    {
        return Layout::DevCon16;
    }

    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        return 'devcon@runet-id.com';
    }

    /**
     * @inheritdoc
     */
    public function getFromName()
    {
        return 'DevCon 2016';
    }


    /**
     * @return bool
     */
    public function getIsPriority()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function showFooter()
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getSubject()
    {
        return 'DevCon 2016: успешная регистрация на сертификацию';
    }


    /**
     * @inheritdoc
     */
    public function getBody()
    {
        $view = 'pay.views.mail.buyproduct.products.devcon16-certification';
        return $this->renderBody($view, ['user' => $this->owner, 'event' => $this->product->Event]);
    }
}
