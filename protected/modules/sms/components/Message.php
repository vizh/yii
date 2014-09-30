<?php
namespace sms\components;


abstract class Message
{
    protected $gate;

    public function __construct(Gate $gate)
    {
        $this->gate = $gate;
    }

    /**
     * @return string
     */
    abstract public function getMessage();

    /**
     * @return string
     */
    abstract public function getTo();

    /**
     *
     */
    public final function send()
    {
        if ($this->getMessage() !== null && $this->getTo() !== null) {
            $this->gate->send($this);
        }
    }
} 