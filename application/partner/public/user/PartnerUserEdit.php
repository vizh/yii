<?php
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

class PartnerUserEdit extends PartnerCommand
{

  /**
   * Основные действия комманды
   * @param int $rocId
   * @return void
   */
    protected function doExecute($rocId = 0)
    {
        $this->view->HeadScript(array('src'=>'/js/libs/jquery-ui-1.8.16.custom.min.js'));
        $this->view->HeadLink(array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '/css/blitzer/jquery-ui-1.8.16.custom.css'));
        $this->view->HeadScript(array('src'=>'/js/partner/user.edit.js'));

        $this->SetTitle('Добавление/редактирование участника мероприятия');

        $rocId = intval($rocId);
        $user = User::GetByRocid($rocId);
        
        $event = Event::GetById($this->Account->EventId);
        
        $eventUser = null;
        if ( !empty ($user))
        {
            if ( empty ($event->Days))
            {
                $eventUser = EventUser::GetByUserEventId( $user->UserId, $this->Account->EventId);
                $this->view->eventUser = $eventUser;
            }
            else 
            {
                $eventUserDays = EventUser::model()->byEventId( $this->Account->EventId)->byUserId( $user->UserId)->findAll();
                $arEventUserDays = array();
                foreach ($eventUserDays as $eventUserDay)
                {
                    $arEventUserDays[ $eventUserDay->DayId ] = $eventUserDay->RoleId;
                }
                $this->view->EventUserDays = $arEventUserDays;
            }
        }

        if (Yii::app()->request->getIsPostRequest())
        {
            if (empty($user))
            {
                $rocId = intval(Registry::GetRequestVar('RocId', 0));
                $user = User::GetByRocid($rocId);
            }

            if ( !empty ($user))
            {                
                if ( empty ($event->Days))
                {
                    $roleId = (int) Registry::GetRequestVar('RoleId');
                
                    if ($roleId == 0 && !empty($eventUser))
                    {
                        $eventUser->delete();
                    }
                    elseif ($roleId != 0)
                    {
                        $role = EventRoles::GetById($roleId);
                        if ( empty ($eventUser))
                        {
                            $eventUser = $event->RegisterUser($user, $role);
                        }
                        else
                        {
                            $eventUser->UpdateRole($role);
                        }
                    }
                }
                else
                {
                    $roleIds = Registry::GetRequestVar('RoleId');
                    if ( is_array($roleIds))
                    {
                        foreach ($roleIds as $dayId => $roleId)
                        {
                            $eventUser = EventUser::model()->byEventId( $this->Account->EventId)->byDayId( $dayId)->byUserId( $user->UserId)->find();
                            if ($roleId != 0)
                            {
                                $role = EventRoles::GetById($roleId);
                                if ($eventUser != null)
                                {
                                    $eventUser->UpdateRole($role);
                                }
                                else
                                {
                                    $eventDay = EventDay::model()->findByPk($dayId);
                                    $event->RegisterUserOnDay($eventDay, $user, $role);
                                }
                            }
                            else if ($roleId == 0 && $eventUser != null)
                            {
                                $eventUser->delete();
                            }
                        }
                    }
                }
                Lib::Redirect(RouteRegistry::GetUrl('partner', 'user', 'index') . '?' . http_build_query(array('filter' => array('RocId' => $user->RocId))));
            }
            else
            {
                $this->view->Error = 'Не удалось найти пользователя с rocID ' . $rocId . '. Убедитесь, что все данные указаны правильно.';
            }
        }
        
        
        $this->view->User  = $user;
        $this->view->Roles = EventRoles::GetAll();
        $this->view->Event = $event; 
        
        
        echo $this->view->__toString();
    }
}