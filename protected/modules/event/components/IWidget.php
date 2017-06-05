<?php
namespace event\components;

interface IWidget
{

    /**
     * @return \event\models\Event
     */
    public function getEvent();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getPosition();

    /**
     * @return void
     */
    public function process();

    /**
     * @return void
     */
    public function run();

    /**
     * @return bool
     */
    public function getIsActive();

    /**
     * @return IWidgetAdminPanel
     */
    public function getAdminPanel();
}