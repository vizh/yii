<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.user.*');

class PartnerCouponUsers extends PartnerCommand
{

    const CouponOnPage = 20;
    
    /**
    * Основные действия комманды
    * @return void
    */
    protected function doExecute()
    {
        $this->SetTitle('Активированные промо-коды');
        
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'Coupon',
            'User',
            'OrderItems'
        );
        $criteria->condition = 'Coupon.EventId = :EventId';
        $criteria->params = array(
            ':EventId' => $this->Account->EventId
        );

        $page = intval(Registry::GetRequestVar('page', null));
        if ($page == 0) {
            $page = 1;
        }

        $criteria->limit  = self::CouponOnPage;
        $criteria->offset = self::CouponOnPage * ($page - 1);
        
        $filter = Registry::GetRequestVar('filter', array());
        if ( !empty ($filter))
        {
            foreach ($filter as $field => $value) 
            {
                if ($value !== '') 
                {
                    switch ($field)
                    {
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
                        
                        case 'Code':
                            $criteria->addCondition('Coupon.Code = :Code');
                            $criteria->params[':Code'] = $value;
                            break;
                    }
                }
                else
                {
                    unset ($filter[$field]);
                }
                $this->view->Filter = $filter;
            }
        }
        $this->view->Activations = CouponActivated::model()->findAll($criteria);
        $this->view->Paginator = new Paginator(
            RouteRegistry::GetUrl('partner', 'coupon', 'users'). '?page=%s', $page, self::CouponOnPage, CouponActivated::model()->count($criteria), array('filter' => $this->view->Filter)
        );

        echo $this->view;
    }
}
