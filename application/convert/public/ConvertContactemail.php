<?php
//6
AutoLoader::Import('convert.source.DevutilsDb');

class ConvertContactemail extends AbstractCommand
{  
  protected function doExecute()
  {
//    echo 'Already doing';
//    exit;
    set_time_limit(1000);
    
    $oldConn = DevutilsDb::GetOldDbConnection();    
    $newConn = DevutilsDb::GetNewDbConnection();    
    
    $sqlSelectUser = 'SELECT `email_id`, `user_id`, `email`,
      `primary`, `is_personal`, `visibility`, `valid`
      FROM user_email ORDER BY email_id ASC LIMIT ';
      
    $sqlSelectCompany = 'SELECT `company_email_id`, `company_id`, `email`,
      `primary`, `visibility`
      FROM company_email ORDER BY company_email_id ASC LIMIT ';
      
    $sqlInsertMain = 'INSERT INTO ContactEmail (`Email`, `Primary`, 
      `IsPersonal`, `Visibility`, `Valid`) 
      VALUES (:Email, :Primary, :IsPersonal, :Visibility, :Valid)';
      
    $sqlInsertUserLink = 'INSERT INTO Link_User_ContactEmail 
      (UserId, EmailId)
      VALUES ';

    $sqlUpdateUser = 'UPDATE User SET Email = :Email WHERE  UserId = :UserId';
      
    $sqlInsertCompanyLink = 'INSERT INTO Link_Company_ContactEmail
      (CompanyId, EmailId) 
      VALUES ';
          
    
    try
    {
      $insertCmd = $newConn->createCommand($sqlInsertMain);
      $updateUserCmd = $newConn->createCommand($sqlUpdateUser);
      
      $offset = 0;
      $limit = 1000;    
      $selectLim = $offset . ', ' . $limit;
      $rows = $oldConn->createCommand($sqlSelectUser . $selectLim)->queryAll();      
      
      while (! empty($rows))
      {        
        $insertUserLink =  '';        
        foreach ($rows as $row)
        {
          $insertCmd->bindValue(':Email', $row['email']);
          $insertCmd->bindValue(':Primary', $row['primary']);
          $insertCmd->bindValue(':IsPersonal', $row['is_personal']);
          $insertCmd->bindValue(':Visibility', $row['visibility']);
          $insertCmd->bindValue(':Valid', $row['valid']);
          $insertCmd->execute();
          $emailId = $newConn->getLastInsertID();

          $updateUserCmd->bindValue(':Email', $row['email']);
          $updateUserCmd->bindValue(':UserId', $row['user_id']);
          $updateUserCmd->execute();
          
          $insertUserLink .= ', (\'' . $row['user_id'] . '\', \'' . $emailId . '\')';                  
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
          $insertCmd->bindValue(':Email', $row['email']);
          $insertCmd->bindValue(':Primary', $row['primary']);
          $insertCmd->bindValue(':IsPersonal', 0);
          $insertCmd->bindValue(':Visibility', $row['visibility']);
          $insertCmd->bindValue(':Visibility', 1);
          $insertCmd->execute();
          $emailId = $newConn->getLastInsertID();
          
          $insertCompanyLink .= ', (\'' . $row['company_id'] . '\', \'' . $emailId . '\')';                  
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