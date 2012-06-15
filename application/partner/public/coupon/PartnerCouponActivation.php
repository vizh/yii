<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.user.*');

class PartnerCouponActivation extends PartnerCommand 
{
    protected function doExecute() 
    {
        $this->SetTitle('Активация промо-кода');
        $this->view->HeadScript( array ('src'=>'/js/libs/jquery-ui-1.8.16.custom.min.js'));
        $this->view->HeadLink(
            array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '/css/blitzer/jquery-ui-1.8.16.custom.css')
        );
        $this->view->HeadScript( array ('src'=>'/js/partner/user.edit.js'));
        
        $activation = Registry::GetRequestVar('Activation'); 
        if ( isset ($activation)) 
        {
            $coupon = Coupon::GetByCode($activation['Coupon']);
            
            if ($coupon != null
                    && $coupon->EventId == $this->Account->EventId)
            {
                $user = User::GetByRocid($activation['RocId']);
                if ($user != null)
                {
                    try {
                        $coupon->Activate($user, $user);
                    } 
                    catch (Exception $e) 
                    {
                        $this->view->Error = $e->getMessage();
                    }
                    $this->view->Success = 'Купон '. $coupon->Code .' успешно активирован на пользователя: '. $user->GetFullName();
                }
                else 
                {
                    $this->view->Error = 'Не удалось найти пользователя с rocID: '. intval($activation['RocId']) .'. Убедитесь, что все данные указаны правильно. ';
                }
            }
            else
            {
                $this->view->Error = 'Не удалось найти промо-код "'. $activation['Coupon'] .'". Убедитесь что код введен верно.';
            }
            $this->view->FieldValues = $activation;
        }

        echo $this->view;
    }
}

?>
