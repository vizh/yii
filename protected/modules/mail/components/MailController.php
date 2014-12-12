<?php
namespace mail\components;

use mail\models\Layout;

class MailController extends \CController
{
    protected $user;
    protected $showUnsubscribeLink;
    protected $showFooter;

    /**
     * @param \user\models\User $user
     * @param string $template
     */
    public function __construct(\user\models\User $user, $template = null, $showFooter = true, $showUnsubscribeLink = true)
    {
        parent::__construct('default', null);
        if (empty($template) || $template == Layout::None) {
            $template = 'empty';
        }

        $this->layout = '/layouts/mail/'.$template;
        $this->user = $user;
        $this->showUnsubscribeLink = $showUnsubscribeLink;
        $this->showFooter = $showFooter;
    }
}
