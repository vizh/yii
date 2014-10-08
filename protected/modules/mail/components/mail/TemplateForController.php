<?php
namespace mail\components\mail;

use mail\components\Mail;

class TemplateForController extends Mail
{
    private $from;

    private $fromName;

    private $to;

    private $subject;

    private $body;

    public function __construct($mailer, $from, $fromName, $to, $subject, $body)
    {
        parent::__construct($mailer);
        $this->from = $from;
        $this->fromName = $fromName;
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    public $isHtml = true;

    public function isHtml()
    {
        return $this->isHtml;
    }

    public $isTest = false;

    protected function getRepeat()
    {
        return $this->isTest;
    }
}