<?php
AutoLoader::Import('library.texts.*');
AutoLoader::Import('utility.source.*');

class UtilityUploadSite12 extends AdminCommand
{
  const Path = '/files/';
  const FileName = 'event246-all.csv';
  const EventId = 246;


  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $fieldMap = array(
      'Company' => 0,
      'FIO' => 1,
      'RocId' => 2,

      'Role' => 3,
      'SubRole' => 4,


      'Email' => 5,

      'Phone' => 6,


    );

    $parser = new CsvParser($_SERVER['DOCUMENT_ROOT'] . self::Path . self::FileName);
    //$parser->UseRuLocale();
    $parser->SetInEncoding('utf-8');

    $results = $parser->Parse($fieldMap, true);


    $fileName = $_SERVER['DOCUMENT_ROOT'] . self::Path . 'new_' . self::FileName;
    $fp = fopen($fileName, 'w');


    foreach ($results as $info)
    {
      if (!empty($info->RocId))
      {
        fputcsv($fp, (array)$info);
        continue;
      }
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
