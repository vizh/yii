<?php
//9
AutoLoader::Import('convert.source.DevutilsDb');

class ConvertUsersettings extends AbstractCommand
{  
  protected function doExecute()
  {
//    echo 'Already doing';
//    exit;
    set_time_limit(1000);
    
    $oldConn = DevutilsDb::GetOldDbConnection();
    $newConn = DevutilsDb::GetNewDbConnection();    
    
    $sqlSelect = 'SELECT `setting_id`, `user_id`, `verify`, `visible`,
      `who_view`, `proj_news`, `event_news`, `notice_photo`, `notice_msg`, `notice_profile`
      FROM user_settings ORDER BY setting_id ASC LIMIT ';
      
    $sqlInsert = 'INSERT INTO UserSettings (`SettingId`, `UserId`, `Verify`, `Visible`, 
      `WhoView`, `ProjNews`, `EventNews`, `NoticePhoto`, `NoticeMsg`, `NoticeProfile`) 
      VALUES ';            
    
    $offset = 0;
    $limit = 1000;    
    $selectLim = $offset . ', ' . $limit;
    $rows = $oldConn->createCommand($sqlSelect . $selectLim)->queryAll();
    while (! empty($rows))
    {
      $insertValues = '';
      foreach ($rows as $row)
      {
        foreach ($row as $key => $val)
        {
          $row[$key] = addcslashes($val, '\'"\\');
        }
        $insertValues .= ', (\'' . implode('\',\'', $row) . '\')';        
      }
      $insertValues = substr($insertValues, 1);      
      $newConn->createCommand($sqlInsert . $insertValues)->execute();
      $offset += $limit;
      $selectLim = $offset . ', ' . $limit;
      $rows = $oldConn->createCommand($sqlSelect . $selectLim)->queryAll();
    }
    echo 'OK';
  }
}