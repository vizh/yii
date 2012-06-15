<?php
//11 ?
AutoLoader::Import('convert.source.DevutilsDb');

class ConvertEventprogramroles extends AbstractCommand
{
  protected function doExecute()
  {
//    echo 'Already doing';
//    exit;
    set_time_limit(1000);
    
    $oldConn = DevutilsDb::GetOldDbConnection();
    $newConn = DevutilsDb::GetNewDbConnection();    
    
    $sqlSelect = 'SELECT `role_id`, `name`
      FROM mod_program_user_roles ORDER BY role_id ASC LIMIT ';
      
    $sqlInsert = 'INSERT INTO EventProgramRoles (`RoleId`, `Name`) 
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
