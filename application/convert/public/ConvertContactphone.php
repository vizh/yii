<?php
//6
AutoLoader::Import('convert.source.DevutilsDb');

class ConvertContactphone extends AbstractCommand
{  
  protected function doExecute()
  {
//    echo 'Already doing';
//    exit;
    set_time_limit(1000);
    
    $oldConn = DevutilsDb::GetOldDbConnection();    
    $newConn = DevutilsDb::GetNewDbConnection();    
    
    $sqlSelectUser = 'SELECT `phone_id`, `user_id`, `phone`, `addon`,
      `primary`, `when_call`, `type`, `visibility`
      FROM user_phone ORDER BY phone_id ASC LIMIT ';
      
    $sqlSelectCompany = 'SELECT `company_phone_id`, `company_id`, `phone`, `addon`,
      `primary`, `is_fax`, `visibility`
      FROM company_phone ORDER BY company_phone_id ASC LIMIT ';
      
    $sqlInsertMain = 'INSERT INTO ContactPhone (`Phone`, `Addon`, `Primary`, 
      `WhenCall`, `Type`, `Visibility`) 
      VALUES (:Phone, :Addon, :Primary, :WhenCall, :Type, :Visibility)';
      
    $sqlInsertUserLink = 'INSERT INTO Link_User_ContactPhone 
      (UserId, PhoneId)
      VALUES ';
      
    $sqlInsertCompanyLink = 'INSERT INTO Link_Company_ContactPhone
      (CompanyId, PhoneId) 
      VALUES ';
          
    
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
          $insertCmd->bindValue(':Phone', $row['phone']);
          $insertCmd->bindValue(':Addon', $row['addon']);
          $insertCmd->bindValue(':Primary', $row['primary']);
          $insertCmd->bindValue(':WhenCall', $row['when_call']);
          $insertCmd->bindValue(':Type', $row['type']);
          $insertCmd->bindValue(':Visibility', $row['visibility']);
          $insertCmd->execute();
          $phoneId = $newConn->getLastInsertID();
          
          $insertUserLink .= ', (\'' . $row['user_id'] . '\', \'' . $phoneId . '\')';                  
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
      
      $offset = 0;
      $limit = 1000;    
      $selectLim = $offset . ', ' . $limit;
      $rows = $oldConn->createCommand($sqlSelectCompany . $selectLim)->queryAll();      
      
      while (! empty($rows))
      {        
        $insertCompanyLink =  '';        
        foreach ($rows as $row)
        {
          $insertCmd->bindValue(':Phone', $row['phone']);
          $insertCmd->bindValue(':Addon', $row['addon']);
          $insertCmd->bindValue(':Primary', $row['primary']);
          $insertCmd->bindValue(':WhenCall', '');
          $insertCmd->bindValue(':Type', intval($row['is_fax']) === 0 ? 'work' : 'fax');
          $insertCmd->bindValue(':Visibility', $row['visibility']);
          $insertCmd->execute();
          $phoneId = $newConn->getLastInsertID();
          
          $insertCompanyLink .= ', (\'' . $row['company_id'] . '\', \'' . $phoneId . '\')';                  
        }        
        if (! empty($insertCompanyLink))
        {          
          $insertCompanyLink = substr($insertCompanyLink, 1);      
          $newConn->createCommand($sqlInsertCompanyLink . $insertCompanyLink)->execute();
        }        
        $offset += $limit;
        $selectLim = $offset . ', ' . $limit;
        $rows = $oldConn->createCommand($sqlSelectCompany . $selectLim)->queryAll();
      }

      
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