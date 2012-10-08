<?php
namespace partner\controllers\coupon;

class UsersAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->setPageTitle('Активированные промо-коды');
    $this->getController()->initActiveBottomMenu('users');

    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'Coupon',
      'User',
      'OrderItems'
    );
    $criteria->condition = 'Coupon.EventId = :EventId';
    $criteria->params = array(
      ':EventId' => \Yii::app()->partner->getAccount()->EventId
    );

    $request = \Yii::app()->request;
    $page = intval($request->getParam('page', null));
    if ($page == 0) {
      $page = 1;
    }

    $criteria->limit  = \CouponController::CouponOnPage;
    $criteria->offset = \CouponController::CouponOnPage * ($page - 1);

    $filter = $request->getParam('filter', array());
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
      }
    }

    $activations = \pay\models\CouponActivated::model()->findAll($criteria);
    $count = \pay\models\CouponActivated::model()->count($criteria);

    $this->getController()->render('users',
      array(
        'filter' => $filter,
        'activations' => $activations,
        'count' => $count,
        'page' => $page
      )
    );
  }
}
