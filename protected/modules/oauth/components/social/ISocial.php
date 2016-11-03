<?php
namespace oauth\components\social;

interface ISocial
{
    const Facebook = '14';
    const Twitter = '13';
    const Vkontakte = '15';
    const Google = '16';
    const PayPal = '21';
    const Linkedin = '22';
    const Ok = '23';

    /**
    * @return string
    */
    public function getOAuthUrl();

    /**
    * @return bool
    */
    public function isHasAccess();

    /**
    * @return void
    */
    public function renderScript();

    /**
    * @return Data
    */
    public function getData();

    /**
    * @return int
    */
    public function getSocialId();

    /**
    * @return string
    */
    public function getSocialTitle();

    /**
    * @return void
    */
    public function clearAccess();
}