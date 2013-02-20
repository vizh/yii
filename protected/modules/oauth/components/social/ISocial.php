<?php
namespace oauth\components\social;

interface ISocial{
  const Facebook = '14';
  const Twitter = '13';
  const Vkontakte = '15';

  public function getOAuthUrl();
  public function isHasAccess();

  /**
   * @return void
   */
  public function renderScript();

  /**
   * @return Data
   */
  public function getData();
  public function getSocialId();
}