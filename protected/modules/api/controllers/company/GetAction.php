<?php
namespace api\controllers\company;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

use api\components\Action;

class GetAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Company",
     *     title="Детальная информация о компании",
     *     description="Возвращает детальную информацию о компании",
     *     samples={
     *          @Sample(lang="javascript", code=""),
     *          @Sample(lang="php", code="")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/company/get",
     *          body="",
     *          params={
     *              @Param(title="CompanyId", description="Айди компании.", mandatory="Y")
     *          },
     *          response=@Response(body="{'Id':77529,'Name':'RUVENTS','FullName':'ООО «РУВЕНТС»','Info':null,'Logo':{'Small':'http://runet-id.dev/upload/images/company/logo/b/e/f/b/9/befb921b1aa035508c9a58b8828469c5-d864780c4b18a07512a2de7044703e9189e757d6.png','Medium':'http://runet-id.dev/upload/images/company/logo/b/e/f/b/9/befb921b1aa035508c9a58b8828469c5-594f0c64feeb1daa88af22e7484a0bf29cf77021.png','Large':'http://runet-id.dev/upload/images/company/logo/b/e/f/b/9/befb921b1aa035508c9a58b8828469c5-0f1ebad037e00404db8dc9d479da5dfb563fca83.png'},'Url':'http://ruvents.com','Phone':'+7 (495) 6385147','Email':'info@ruvents.com','Address':'г. Москва, Пресненская наб., д. 12','Cluster':'РАЭК','ClusterGroups':[],'OGRN':null,'Employments':[{'RocId':454,'RunetId':454,'LastName':'Борзов','FirstName':'Максим','FatherName':'','CreationTime':'2007-05-25 19:29:22','Visible':true,'Verified':true,'Gender':'male','Photo':{'Small':'http://runet-id.dev/files/photo/0/454_50.jpg?t=1475191745','Medium':'http://runet-id.dev/files/photo/0/454_90.jpg?t=1475191306','Large':'http://runet-id.dev/files/photo/0/454_200.jpg?t=1475191317'},'Attributes':{},'Work':{'Position':'Генеральный директор','Company':{'Id':77529,'Name':'RUVENTS'},'StartYear':2014,'StartMonth':4,'EndYear':null,'EndMonth':null},'Status':{'RoleId':1,'RoleName':'Участник','RoleTitle':'Участник','UpdateTime':'2012-04-18 12:06:49','TicketUrl':'http://runet-id.dev/ticket/rif12/454/7448b8c03688bf317a7506f41/','Registered':false},'Email':'max.borzov@gmail.com','Phone':'79637654577','PhoneFormatted':'8 (963) 765-45-77','Phones':['89637654577','79637654577']}]}")
     *      )
     * )
     */
    public function run()
    {
        $companyId = \Yii::app()->getRequest()->getParam('CompanyId', null);

        $company = \company\models\Company::model()->findByPk($companyId);
        if ($company === null) {
            throw new \api\components\Exception(241, [$companyId]);
        }
        $result = $this->getDataBuilder()->createCompany($company);

        if ($this->getAccount()->EventId !== null) {
            $criteria = new \CDbCriteria();
            $criteria->with = [
                'Employments' => ['together' => true],
                'Participants' => ['together' => true]
            ];
            $criteria->addCondition('"Employments"."EndYear" IS NULL AND "Employments"."Primary"');
            $criteria->addCondition('"Employments"."CompanyId" = :CompanyId');
            $criteria->addCondition('"Participants"."EventId" = :EventId');
            $criteria->params['EventId'] = $this->getEvent()->Id;
            $criteria->params['CompanyId'] = $company->Id;
            $criteria->order = '"t"."LastName", "t"."FirstName"';

            $users = \user\models\User::model()->byVisible(true)->findAll($criteria);
            $result->Employments = [];
            foreach ($users as $user) {
                $result->Employments[] = $this->getDataBuilder()->createUser($user);
            }
        }

        $this->setResult($result);
    }
}