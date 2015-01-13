<?php
namespace mail\components;

use mail\models\Layout;

class MailController extends \CController
{
    protected $mail;

    /**
     * @param MailLayout $mail
     */
    public function __construct(MailLayout $mail)
    {
        parent::__construct('default', null);
        $template = $mail->getLayoutName();
        if (empty($template) || $template == Layout::None) {
            $template = 'empty';
        }

        $this->layout = '/layouts/mail/'.$template;
        $this->mail = $mail;
    }
}
