<?php
namespace mail\components\mail;

use \mail\components\Mailer;
use \user\models\User;
use \mail\models\Template as TemplateModel;
use \application\components\utility\PKPassGenerator;
use \mail\models\TemplateLog;

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

        //get attachments from folder
        $dir =  \Yii::getpathOfAlias('webroot.files.emailAttachments.'.$this->template->Id);
        if (file_exists($dir)) {
            $files = \CFileHelper::findFiles($dir);
            foreach ($files as $file) {
                $attachments[basename($file)] = $file;
            };
        };

        if ($this->template->Id == 493) {
            $attachments['Карта гостя.pdf'] = \Yii::getPathOfAlias('application') . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
                . 'www' . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'mail' . DIRECTORY_SEPARATOR . 'devcon15' . DIRECTORY_SEPARATOR
                . 'map-guest.pdf';
        };

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
        return $this->renderBody($this->template->getViewName(), ['user' => $this->user]);
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