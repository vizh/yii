<?php
namespace mail\components\mail;

use application\components\utility\PKPassGenerator;
use event\models\Event;
use mail\components\Mailer;
use mail\models\forms\admin\Template as TemplateForm;
use mail\models\Template as TemplateModel;
use mail\models\TemplateLog;
use user\models\User;

class Template extends \mail\components\MailLayout
{
    protected $user;
    protected $template;

    public function __construct(Mailer $mailer, User $user, TemplateModel $template)
    {
        parent::__construct($mailer);
        $this->user = $user;
        $this->template = $template;
    }

    /**
     * @return bool
     */
    public function isHtml()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->template->From;
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->template->FromName;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->user->Email;
    }

    /**
     * @return string
     */
    public function getToName()
    {
        return $this->user->getFullName();
    }

    /**
     * @return array
     */
    public function getAttachments()
    {
        $attachments = [];
        if ($this->template->SendPassbook) {
            $participants = $this->user->Participants[0];
            $pkPass = new PKPassGenerator($participants->Event, $this->user, $participants->Role);
            $attachments['ticket.pkpass'] = $pkPass->runAndSave();
        };

        $form = new TemplateForm($this->template);
        $path = $form->getPathAttachments();
        if (file_exists($path)) {
            $files = \CFileHelper::findFiles($path);
            foreach ($files as $file) {
                $attachments[basename($file)] = $file;
            }
        }
        return $attachments;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->template->Subject;
    }

    /**
     * @return bool
     */
    protected function getRepeat()
    {
        return true;
    }

    public function getLog()
    {
        $log = new TemplateLog();
        $log->UserId = $this->user->Id;
        $log->TemplateId = $this->template->Id;
        return $log;
    }

    /**
     * @return string
     */
    public function getLayoutName()
    {
        return $this->template->Layout;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->renderBody($this->template->getViewName(), [
            'user' => $this->user,
            'event' => Event::model()->findByPk($this->template->RelatedEventId)
        ]);
    }

    /**
     * @return User
     */
    function getUser()
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function showUnsubscribeLink()
    {
        return $this->template->ShowUnsubscribeLink;
    }

    /**
     * @return bool
     */
    public function showFooter()
    {
        return $this->template->ShowFooter;
    }

    /**
     * @inheritdoc
     */
    public function getRelatedEvent()
    {
        return $this->template->RelatedEvent;
    }
}