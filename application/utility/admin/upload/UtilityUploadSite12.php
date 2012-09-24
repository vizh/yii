<?php
AutoLoader::Import('library.texts.*');
AutoLoader::Import('utility.source.*');

class UtilityUploadSite12 extends AdminCommand
{
  const Path = '/files/';
  const FileName = 'event246-list-sveta.csv';
  const EventId = 246;


  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $fieldMap = array(
      'FIO' => 0,
      'Company' => 1,

      'Email' => 2,

      'Phone' => 3,

      'Role' => 4,
      'SubRole' => 5,
    );

    $parser = new CsvParser($_SERVER['DOCUMENT_ROOT'] . self::Path . self::FileName);
    //$parser->UseRuLocale();
    $parser->SetInEncoding('utf-8');

    $results = $parser->Parse($fieldMap, true);


    $fileName = $_SERVER['DOCUMENT_ROOT'] . self::Path . 'new_' . self::FileName;
    $fp = fopen($fileName, 'w');


    foreach ($results as $info)
    {
      $user = null;
      if (!empty($info->Email))
      {
        $user = User::GetByEmail($info->Email);
      }
      $info->FirstTemp = !empty($user) ? $user->RocId : '';
      $info->SecondTemp = '';
      if (empty($user))
      {
        $users = User::GetBySearch($info->FIO);
        foreach ($users as $user)
        {
          if (empty($info->SecondTemp))
          {
            $info->SecondTemp .= $user->RocId;
          }
          else
          {
            $info->SecondTemp .= ','.$user->RocId;
          }
        }
      }
      fputcsv($fp, (array)$info);
    }
    fclose($fp);
  }
}
