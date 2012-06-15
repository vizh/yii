<?php
AutoLoader::Import('library.rocid.user.*');

class UploadParser
{
  const STATE_BAD_MAIL = 'BAD MAIL';

  /**
   * @static
   * @param UserParseData $data
   * @return string
   */
  public static function ParseUser(UserParseData $data)
  {
    $emailValidator = new CEmailValidator();
    if (empty($data->Email) || ! $emailValidator->validateValue($data->Email))
    {
      return self::STATE_BAD_MAIL;
    }


  }
}