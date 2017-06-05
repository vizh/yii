<?php
namespace event\components;

interface IWidgetAdminPanel
{
    public function getEvent();

    public function addError($message);

    /**
     *
     * @param string $header
     * @param string $footer
     * @return string
     */
    public function errorSummary($header = '', $footer = '');

    public function setSuccess();

    /**
     * @return string
     */
    public function getSuccess();

    /**
     * @return bool
     */
    public function hasSuccess();

    /**
     * @return bool
     */
    public function process();
}
