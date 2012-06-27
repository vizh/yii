<?php
class UserVisible extends AdminCommand
{
    protected function doExecute() 
    {
        $visible = Registry::GetRequestVar('Visible', array());
        $this->view->Step = 1;
        
        if (yii::app()->request->getIsPostRequest()
                && !empty ($visible))
        {
            $user = User::model()->GetByRocid($visible['RocId']);
            if ($user != null)
            {
                $this->view->User = $user;
                $this->view->Step = 2;
                
                if ( isset ($visible['Visible']))
                {
                    $user->Settings->Visible = (int) $visible['Visible'];
                    $user->Settings->save();
                }
            }
            else
            {
                $this->view->SetTemplate('error');
                $this->view->Error = 'Пользователь с таким rocID не найден!';
            }
        }
        
        echo $this->view;
    }
}
