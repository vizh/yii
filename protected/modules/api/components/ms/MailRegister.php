<?php
namespace api\components\ms;

use mail\components\Mailer;
use mail\models\Layout;
use user\components\handlers\Register;

class MailRegister extends Register
{
    /**
     * @var string
     */
    private $payUrl;

    public function __construct(Mailer $mailer, \CEvent $event)
    {
        parent::__construct($mailer, $event);
        $this->payUrl = $event->params['payUrl'];
    }


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
     * @inheritdoc
     */
    public function getBody()
    {
        return $this->renderBody('event.views.mail.register.devcon16.devcon16-hy47k', [
            'user' => $this->user,
            'password' => $this->password,
            'payUrl' => $this->payUrl
        ]);
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return 'Благодарим Вас за интерес к конференции DevCon 2016!';
    }


}