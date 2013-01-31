<?php
namespace oauth\components\social;

interface ISocial{
  public function getOAuthUrl();
  public function isHasAccess();
  public function getData();
  public function getSocialId();
}