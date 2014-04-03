<?php
namespace mail\components\mailers\template;

interface ITemplateMailer
{
  /**
   * @param \user\models\User[] $users
   */
  public function send($users);

  /**
   * @return sring
   */
  public function getVarNameUserUrl();

  /**
   * @return sring
   */
  public function getTagUserUrl();

  /**
   * @return sring
   */
  public function getVarNameUserRunetId();

  /**
   * @return sring
   */
  public function getTagUserRunetId();

  /**
   * @return sring
   */
  public function getVarNameUnsubscribeUrl();

  /**
   * @return sring
   */
  public function getTagUnsubscribeUrl();

  /**
   * @return sring
   */
  public function getTagMailBody();

  /**
   * @return sring
   */
  public function getVarNameMailBody();

  /**
   * @return array[]
   */
  public function getAttachments(\user\models\User $user);

  /**
   * @return bool
   */
  public function getIsHasAttachments();
} 