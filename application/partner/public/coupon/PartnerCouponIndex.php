<?php
AutoLoader::Import('library.rocid.pay.*');


class PartnerCouponIndex extends PartnerCommand
{
    
    const CouponOnPage = 20;
    
    /**
    * Основные действия комманды
    * @return void
    */
    protected function doExecute()
    {
        $this->SetTitle('Поиск промо-кодов');
        $this->view->HeadScript( 
            array('src'=>'/js/partner/coupon.index.js')
        );
        
        
        $criteria = new CDbCriteria();
        $criteria->condition = 't.EventId = :EventId';
        $criteria->params = array(
            ':EventId' => $this->Account->EventId
        );
        $criteria->with = array(
            'CouponActivatedList' => array('together' => true),
            'Product'
        );
        
        $page = (int) Registry::GetRequestVar('page', 0);
        if ($page === 0) 
        {
            $page = 1;
        }
        
        $criteria->limit  = self::CouponOnPage;
        $criteria->offset = self::CouponOnPage * ($page-1);
        
        $filter = Registry::GetRequestVar('filter', array());
        if ( !empty ($filter)) 
        {
            foreach ($filter as $field => $value)
            {
                if ( $value !== '')
                {
                    switch ($field)
                    {
                        case 'Discount':
                            if ( (int) $value['From'] > 0)
                            {
                                $criteria->addCondition('t.Discount >= :DiscountFrom');
                                $criteria->params[':DiscountFrom'] = $value['From'] / 100;
                            }
                            
                            if ( (int) $value['To'] > 0)
                            {
                                $criteria->addCondition('t.Discount <= :DiscountTo');
                                $criteria->params[':DiscountTo'] = $value['To'] / 100;
                            }
                            break;
                            
                        case 'Code':
                            $criteria->addCondition('t.Code = :Code');
                            $criteria->params[':Code'] = $value;
                            break;
                        
                        case 'Recipient':
                            $criteria->addCondition(
                                't.Recipient IS '. ((int) $value == 1 ? 'NOT' : '') .' NULL'
                            );
                            break;
                        
                        case 'Activated':
                            $criteria->addCondition(
                                'CouponActivatedList.CouponActivatedId IS '. ((int) $value == 1 ? 'NOT' : '') .' NULL'
                            );
                            break;
                    }
                }
                else 
                {
                    unset ($filter[$field]);
                }
            }
            $this->view->Filter = $filter;
        }
        
        $this->view->Coupons   = Coupon::model()->findAll($criteria);
        $this->view->Paginator = new Paginator(
            RouteRegistry::GetUrl('partner', 'coupon', 'index'). '?page=%s', $page, self::CouponOnPage, Coupon::model()->count($criteria), array('filter' => $this->view->Filter)
        );
        echo $this->view;
    }
}
