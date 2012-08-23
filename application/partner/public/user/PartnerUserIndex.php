<?php
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

class PartnerUserIndex extends PartnerCommand
{
    const UsersOnPage = 20;
    
    
    /**
    * Основные действия комманды
    * @return void
    */
    protected function doExecute()
    {
      $this->SetTitle('Поиск участников мероприятия');

        $criteria = new CDbCriteria();
        $criteria->condition = 't.EventId = :EventId AND Settings.Visible = \'1\'';
        $criteria->params = array(
          ':EventId' => $this->Account->EventId
        );
        $criteria->with = array(
          'User',
          'User.Employments',
          'User.Settings',
          'User.Employments.Company',
          'EventRole',
          'User.Emails',
          'User.Phones'
        );
        
        
        $page = (int) Registry::GetRequestVar('page', 0);
        if ($page === 0) 
        {
            $page = 1;
        }

        
        
        $filter = Registry::GetRequestVar('filter', array());
        if ( !empty ($filter)) 
        {
          foreach ($filter as $field => $value) 
          {
            if ( !empty ($value))
            {
              switch ($field) 
              {
                case 'RoleId':
                    $criteria->addCondition('t.RoleId = :RoleId');
                    $criteria->params[':RoleId'] = $value;
                    break;

                case 'RocId':
                    $criteria->addCondition('User.RocId = :RocId');
                    $criteria->params[':RocId'] = $value;
                    break;

                case 'Name':
                    $nameParts = preg_split('/[, .]/', $value, -1, PREG_SPLIT_NO_EMPTY);
                    if ( sizeof ($nameParts) == 1) 
                    {
                      $criteria->addCondition(
                        'User.FirstName LIKE :NamePart0 OR User.LastName LIKE :NamePart0'
                      );
                      $criteria->params[':NamePart0'] = '%'. $nameParts[0] .'%';
                    }
                    else
                    {
                      $criteria->addCondition('
                          (User.FirstName LIKE :NamePart0 AND User.LastName LIKE :NamePart1) OR (User.FirstName LIKE :NamePart1 AND User.LastName LIKE :NamePart0)
                      ');
                      $criteria->params[':NamePart0'] = '%'. $nameParts[0] .'%';
                      $criteria->params[':NamePart1'] = '%'. $nameParts[1] .'%';
                    }

                    break;
              }
            }
          }
          $this->view->Filter = $filter;
        }
        
        $criteria->group = 't.UserId';
        $count = count(EventUser::model()->findAll($criteria));

        $this->view->Count = $count;
        $this->view->Event = Event::model()->findByPk($this->Account->EventId);
        
        $criteria->limit  = self::UsersOnPage;
        $criteria->offset = self::UsersOnPage * ($page-1);
        
        
        $users = array();
        $eventUsers = EventUser::model()->findAll($criteria);
        foreach ($eventUsers as $eventUser)
        {
            $users [$eventUser->UserId] = array(
              'EventUser' => $eventUser
            );
            if ( !empty ($this->view->Event->Days))
            {
              $users[$eventUser->UserId]['DayRoles'] = EventUser::model()->byUserId($eventUser->UserId)->byEventId($eventUser->EventId)->findAll('t.DayId IS NOT NULL');
            }
        }
        $this->view->Users = $users;
        
        $this->view->Roles = Event::model()->findByPk($this->Account->EventId)->GetUsingRoles();
        
        $this->view->Paginator = new Paginator(
            RouteRegistry::GetUrl('partner', 'user', 'index').'?page=%s', $page, self::UsersOnPage, $count, array('filter' => $filter)
        );
        
        echo $this->view;
    }
}