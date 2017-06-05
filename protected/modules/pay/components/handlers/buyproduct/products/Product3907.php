<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 30.11.2015
 * Time: 18:36
 */

namespace pay\components\handlers\buyproduct\products;

use mail\models\Layout;

class Product3907 extends Base
{
    /**
     * @inheritdoc
     */
    public function getTo()
    {
        return 'reg@ifreshconf.ru';
    }

    /**
     * @inheritDoc
     */
    public function getToName()
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getLayoutName()
    {
        return Layout::None;
    }

    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return 'Приобретен товар '.$this->product->Title;
    }

}