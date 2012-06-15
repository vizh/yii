<?php
AutoLoader::Import('library.rocid.pay.*');
class PartnerCouponGive extends PartnerCommand
{
    protected function doExecute() 
    {
        $coupons = Registry::GetRequestVar('Coupons', array());
        if ( !empty ($coupons))
        {
            $criteria = new CDbCriteria();
            $criteria->condition = 't.EventId = :EventId';
            $criteria->params = array(
                ':EventId' => $this->Account->EventId
            );
            $criteria->addInCondition('t.Code', $coupons);
            
            $this->view->Coupons = Coupon::model()->findAll($criteria);
            
            if ( isset ($_REQUEST['Give'])
                    && Yii::app()->request->getIsPostRequest()) 
            {
                foreach ($this->view->Coupons as $coupon) 
                {
                    $coupon->Recipient = date('d.m.Y') .': '. $_REQUEST['Give']['Recipient'] .'; '. $coupon->Recipient;
                    $coupon->save();
                }
                $this->view->Success = 'Промо-коды выданы!';
            }
        }
        else 
        {
            $this->view->Error = 'Не выбраны промо-коды для выдачи.';
        }
        
        
        echo $this->view;
    }
}

?>
