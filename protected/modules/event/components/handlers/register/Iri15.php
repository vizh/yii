<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 15.04.15
 * Time: 16:02
 */

namespace event\components\handlers\register;

use mail\models\Layout;

class Iri15 extends Base
{
    public function getSubject()
    {
        return 'Вас пригласили в ИРИ';
    }

    public function getBody()
    {
        return $this->renderBody('event.views.mail.register.iri15.iri15', [
            'user' => $this->user
        ]);
    }

    protected function getRepeat()
    {
        return false;
    }

    public function getAttachments()
    {
        return [];
    }

    public function getLayoutName()
    {
        return Layout::OneColumn;
    }

    public function getFromName()
    {
        return 'ИРИ';
    }

    public function getFrom()
    {
        return 'iri@runet-id.com';
    }

}