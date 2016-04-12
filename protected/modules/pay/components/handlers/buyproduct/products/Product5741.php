<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 12.04.2016
 * Time: 0:09
 */

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
        return 'Успешная регистрация на сертификацию';
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