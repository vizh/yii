<?php
//8
AutoLoader::Import('convert.source.DevutilsDb');

class ConvertContactserviceaccount extends AbstractCommand
{  
  protected function doExecute()
  {
//    echo 'Already doing';
//    exit;
    set_time_limit(1000);
    
    $oldConn = DevutilsDb::GetOldDbConnection();    
    $newConn = DevutilsDb::GetNewDbConnection();    
    
    $sqlSelectUser = 'SELECT `user_id`, `service_id`, `account`, `visibility`
      FROM user_service_account ORDER BY user_id ASC LIMIT ';    
      
    $sqlSelectServiceTypes = 'SELECT `service_id`, `site_id`, `account_url_mask`, 
      `protocol`, `is_messenger`
      FROM service ORDER BY service_id ASC';
      
    $sqlInsertMain = 'INSERT INTO ContactServiceAccount 
      (`ServiceTypeId`, `Account`, `Visibility`) 
      VALUES (:ServiceTypeId, :Account, :Visibility)';
      
    $sqlInsertUserLink = 'INSERT INTO Link_User_ContactServiceAccount 
      (UserId, ServiceId)
      VALUES ';
    
    $sqlInsertServiceTypes = 'INSERT INTO ContactServiceType 
      (`ServiceTypeId`, `AccountUrlMask`, `Protocol`, `IsMessenger`) 
      VALUES (:ServiceTypeId, :AccountUrlMask, :Protocol, :IsMessenger)';
    
    try
    {
      $insertCmd = $newConn->createCommand($sqlInsertMain);      
      $offset = 0;
      $limit = 1000;    
      $selectLim = $offset . ', ' . $limit;
      $rows = $oldConn->createCommand($sqlSelectUser . $selectLim)->queryAll();      
      
      while (! empty($rows))
      {        
        $insertUserLink =  '';        
        foreach ($rows as $row)
        {
          $insertCmd->bindValue(':ServiceTypeId', $row['service_id']);
          $insertCmd->bindValue(':Account', $row['account']);
          $insertCmd->bindValue(':Visibility', $row['visibility']);
          $insertCmd->execute();
          $serviceId = $newConn->getLastInsertID();
          
          $insertUserLink .= ', (\'' . $row['user_id'] . '\', \'' . $serviceId . '\')';                  
        }        
        if (! empty($insertUserLink))
        {          
          $insertUserLink = substr($insertUserLink, 1);      
          $newConn->createCommand($sqlInsertUserLink . $insertUserLink)->execute();
        }        
        $offset += $limit;
        $selectLim = $offset . ', ' . $limit;
        $rows = $oldConn->createCommand($sqlSelectUser . $selectLim)->queryAll();
      }
      
      //Конвертация таблицы service в ContactServiceType
//      $rows = $oldConn->createCommand($sqlSelectServiceTypes)->queryAll();
//      $insertCmd = $newConn->createCommand($sqlInsertServiceTypes);
//      foreach ($rows as $row)
//      {
//        $insertCmd->bindValue(':ServiceTypeId', $row['service_id']);
//        $insertCmd->bindValue(':AccountUrlMask', $row['account_url_mask']);
//        $insertCmd->bindValue(':Protocol', $row['protocol']);
//        $insertCmd->bindValue(':IsMessenger', $row['is_messenger']);
//        $insertCmd->execute();
//      }
            
      echo 'OK';
    }
    catch (Exception $e)
    {
      echo $sqlInsertUserLink . $insertUserLink;
      //echo $sqlInsertCompanyLink . $insertCompanyLink;
      throw $e;
    }
  }
}