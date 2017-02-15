<?php
namespace api\controllers\professionalinterest;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class ListAction extends \api\components\Action
{
    /**
     * @ApiAction(
     *     controller="Interests",
     *     title="Список",
     *     description="Список доступных проф. интересов",
     *     request=@Request(
     *          method="GET",
     *          url="/professionalinterest/list",
     *          params={},
     *          response=@Response( body="[{'Id': 1,'Title': 'Аналитика'}]" )
     *     )
     * )
     */
  public function run()
  {
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Title" ASC';
    $interests = \application\models\ProfessionalInterest::model()->findAll($criteria);
    $result = [];
    foreach ($interests as $interes)
    {
      $result[] = $this->getDataBuilder()->createProfessionalInterest($interes);
    }
    $this->setResult($result);
  }
} 