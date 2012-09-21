<?php
class UserContacts extends AdminCommand 
{
  public function doExecute() 
  {
    if (isset($_POST['Contacts']))
    {
      $errors = array();
      if (!empty($_POST['Contacts']['Data']))
      {
        $data = explode("\r\n", $_POST['Contacts']['Data']);
        $users = array(); 
        
        switch ($_POST['Contacts']['By'])
        {
          case 'rocid':
            foreach ($data as $strN => $item)
            {
              $item = trim($item, ' /');
              if (empty($item))
                continue;
              
              if (($pos = strrpos($item, '/')) !== false)
              {
                $item = substr($item, $pos+1);
              }
              $rocId = (int) $item;

              $user  = User::GetByRocid($rocId, array('Emails'));
              if ($user !== null)
              {
                $users[] = $user;
              }
              else 
              {
                $errors[] = 'Ошибка в строке '.($strN+1).', не найден пользователь: '.$data[$strN];
              }
            }
            break;
            
          case 'email':
            foreach ($data as $strN => $item)
            {
              $item = trim($item);
              if (empty($item))
                continue;
              
              $criteria = new CDbCriteria();
              $criteria->with = array(
                'Emails' => array('together' => true)
              );
              $criteria->condition = 't.Email = :Email OR Emails.Email = :Email';
              $criteria->params['Email'] = $item;
              $user = User::model()->find($criteria);
              if ($user != null)
              {
                $users[] = $user;
              }
              else 
              {
                $errors[] = 'Ошибка в строке '.($strN+1).', не найден пользователь с E-mail: '.$item;
              }
            }
            break;
        }
        $this->view->Users = $users;
        $this->view->Data  = $_POST['Contacts']['Data'];
      }
      else 
      {
        $errors[] = 'Не заполнены данные для поиска!';
      }
      $this->view->Errors = $errors;
      $this->view->Format = $_POST['Contacts']['Format'];
    }
    echo $this->view;
  }
}

?>
