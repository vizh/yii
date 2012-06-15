<?php
AutoLoader::Import('library.rocid.company.*');
AutoLoader::Import('library.rocid.attachment.*');
AutoLoader::Import('library.rocid.user.*');

AutoLoader::Import('convert.public.*');

class TestTest2 extends GeneralCommand
{
  protected function doExecute()
  {
    $time= time();
    echo $time . ' == ' . date('Y-m-d H:i:s');
//    AutoLoader::Import('library.mail.*');
//
//    for ($i=0; $i< 40 ; $i++)
//    {
//      $mail = new PHPMailer(false);
//
//      $mail->AddAddress('nikitin@internetmediaholding.com');
//      $mail->SetFrom('support@rocid.ru', 'rocID', false);
//      $mail->CharSet = 'utf-8';
//      $subject = Registry::GetWord('mail');
//      $subject = (string)$subject['recovery'];
//      $mail->Subject = '=?UTF-8?B?'. base64_encode($subject) .'?=';
//      $mail->AltBody = 'Для просмотра этого сообщения необходимо использовать клиент, поддерживающий HTML';
//      $mail->MsgHTML('Тест отправки письма!');
//      $mail->Send();
//    }
//
//
//    echo 'Mail send!';

    //phpinfo();

//    $log = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'chrono.log';
//    $fh = fopen($log, 'a') or die("can't open file");
//    fwrite($fh, $_SERVER['QUERY_STRING'] . "\n");
//    fclose($fh);
//========================================================================================
//====================  ТЕГИ =============================================   

//    AutoLoader::Import('news.source.*');
    
    
//    $news = new News();
//    $contentType = $news->GetContentType();
//    
//    echo $contentType;
//    
//    $news = Tag::GetTaggedContentIds('MegaTest', $contentType);
//    
//    echo sizeof($news);
//    
//    print_r($news);
//====
    
//    foreach ($news as $n)
//    {
//      echo '<br/> Id: ' . $n->GetNewsId() . ' Title: ' . $n->GetTitle();
//    }
    
//    $getNewsId = array(2, 11, 16, 17);
//    $tags = array('LastTest', 'SecondTegInAdd');
//    
//    $data = Lib::TransformDataArray($getNewsId);
//    $criteria = new CDbCriteria();
//    $criteria->condition = 'NewsId IN (' . implode(',', $data[0]) . ')';
//    $criteria->params = $data[1];
//    
//    $news = News::model()->findAll($criteria);
//    
//    foreach ($news as $n)
//    {
//      Tag::AddTaggedContent($tags, $n);
//    }
//    
//    echo 'All tags added';
    

//========================================================================================
//====================  Тесты запросов =============================================    
    //$user = User::model()->with(array('EventUsers.EventRole'))->findByPk(6674);
  
  
    //$eventUser = EventUser::model()->findByPk(5457);
    
    //print_r($eventUser);
    //echo '---------- <br/>';
    //print_r($eventUser->EventRole());
    //$eventRole = EventRoles::model()->findByPk(1);
    
    //print_r($eventRole);
//========================================================================================
//====================  АТТАЧМЕНТЫ =============================================    
//    print_r($_POST);
//    print_r($_FILES);
//    if (Registry::GetRequestVar('Send'))
//    {
//      foreach ($_FILES as $key=>$info)
//      {
//        if (is_array($info['name']))
//        {
//          for ($i=0; $i < sizeof($info['name']); $i++)
//          {          
//            $fileInfo = array();
//            $fileInfo['name'] = $info['name'][$i];
//            $fileInfo['type'] = $info['type'][$i];
//            $fileInfo['tmp_name'] = $info['tmp_name'][$i];
//            $fileInfo['size'] = $info['size'][$i];
//            Attachment::CreateAttachment($fileInfo);
//          }          
//        }
//        else
//        {
//          Attachment::CreateAttachment($info);
//        }
//      }
//    }
//    
//    $container = new ViewContainer();
//    $attachement = new Attachment();
//    $files = $attachement->findAll();
//    if (! empty($files))
//    {
//      foreach ($files as $file)
//      {
//        $view = new View();
//        $view->SetTemplate('attachment');
//        $view->Name = $file->GetName();
//        $view->Url = $file->GetUrl();
//        $container->AddView($view);
//      }
//    }
//    $this->view->List = $container;
//    echo $this->view->__toString();    
    



//  $companyId = 5417;
//  
//  $company = Company::model()->with('Users.User.EventUsers.Event');    
//  $criteria = new CDbCriteria();
//  $criteria->condition = 'Company.CompanyId = :CompanyId';
//  $criteria->params = array(':CompanyId' => $companyId);
//  $company = $company->find($criteria);

//  print_r($company);
  


//========================================================================
//========================= ПОИСК =======================================
//    Registry::SetRequestVar('Name', '35287');
//    Registry::SetRequestVar('EventId', '');       

 
//    $profilePlugin = SearchManager::GetSearchPlugin('Profile');
//    $profileResult = $profilePlugin->GetSearchResults();
//    $this->printSearchTestInfo($profileResult);
//    
//    $companyPlugin = SearchManager::GetSearchPlugin('Company');
//    $companyResult = $companyPlugin->GetSearchResults();
//    $this->printSearchTestInfo($companyResult);
//    
//    $eventPlugin = SearchManager::GetSearchPlugin('Event');
//    $eventResult = $eventPlugin->GetSearchResults();
//    $this->printSearchTestInfo($eventResult);
    
//    print_r($result);
  }
  
  private function printSearchTestInfo($results)
  {
    echo 'Count:' . sizeof($results) . '<br/>';
    $i = 0;
    foreach ($results as $res)
    {      
      echo 'Record ' . $i . ': ';
      foreach ($res as $key => $value)
      {
        echo $key . ' = ' . $value . '  ';
      }
      $i++;
      echo '<br/>';
    }
    echo '<br/>';
  }
  
  
}