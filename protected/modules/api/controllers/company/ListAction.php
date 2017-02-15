<?php
namespace api\controllers\company;

use api\components\Action;
use api\components\Exception;
use api\models\Account;
use application\components\CDbCriteria;
use company\models\Company;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class ListAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Company",
     *     title="Список",
     *     description="Список компаний.",
     *     request=@Request(
     *          method="GET",
     *          url="/company/list",
     *          body="",
     *          params={
     *              @Param(title="Cluster", description="(enum[РАЭК]) – кластер, компании которого необходимо получить. В данный момент может принимать единственное значение: РАЭК.", mandatory="Y"),
     *              @Param(title="Query", description="Поисковая строка."),
     *              @Param(title="PageToken", description="Указатель на следующую страницу, берется из результата последнего запроса, значения NextPageToken."),
     *              @Param(title="MaxResults", description="MaxResults (число) - максимальное количество компаний в ответе, от 0 до 200. Если нужно загрузить более 200 участников, необходимо использовать постраничную загрузку.")
     *          },
     *          response=@Response(body="{'Companies':[{'Id':77529,'Name':'RUVENTS','FullName':'ООО «РУВЕНТС»','Info':null,'Logo':{'Small':'http://runet-id.dev/upload/images/company/logo/b/e/f/b/9/befb921b1aa035508c9a58b8828469c5-d864780c4b18a07512a2de7044703e9189e757d6.png','Medium':'http://runet-id.dev/upload/images/company/logo/b/e/f/b/9/befb921b1aa035508c9a58b8828469c5-594f0c64feeb1daa88af22e7484a0bf29cf77021.png','Large':'http://runet-id.dev/upload/images/company/logo/b/e/f/b/9/befb921b1aa035508c9a58b8828469c5-0f1ebad037e00404db8dc9d479da5dfb563fca83.png'},'Url':'http://ruvents.com','Phone':'+7 (495) 6385147','Email':'info@ruvents.com','Address':'г. Москва, Пресненская наб., д. 12','Cluster':'РАЭК','ClusterGroups':[],'OGRN':null}]}")
     *     )
     * )
     */
    public function run()
    {
        // Данный метод доступен только для собственных мероприятий
        if ($this->getAccount()->Role !== Account::ROLE_OWN) {
            throw new Exception(104);
        }

        // Сейчас возможна работа только с компаниями кластера РАЭК
        if ($this->getRequestParam('Cluster') !== Company::CLUSTER_RAEC) {
            throw new Exception('В данный момент реализована поддержка только кластера РАЭК');
        }

        $model = Company::model();

        if ($this->hasRequestParam('Query')) {
            $model->bySearch($this->getRequestParam('Query'));
        }

        if ($this->hasRequestParam('Code')) {
            $model->byCode($this->getRequestParam('Code'));
        }

        if ($this->hasRequestParam('Cluster')) {
            $model->byCluster($this->getRequestParam('Cluster'));
        }

        $criteria = CDbCriteria::create()
            ->setWith(['ActiveRaecUsers', 'LinkEmail', 'LinkAddress', 'LinkPhones', 'LinkRaecClusters'])
            ->setLimit(min($this->getRequestParam('MaxResults', $this->getMaxResults()), $this->getMaxResults()))
            ->setOffset(0);

        if ($this->hasRequestParam('PageToken')) {
            $criteria->setOffset($this->getController()->parsePageToken($this->getRequestParam('PageToken')));
        }

        $companies = $model
            ->ordered()
            ->findAll($criteria);

        $result = ['Companies' => []];
        foreach ($companies as $company) {
            $result['Companies'][] = $this->getDataBuilder()->createCompany($company);
        }

        if ($criteria->limit === count($companies)) {
            $result['NextPageToken'] = $this->getController()->getPageToken($criteria->offset + $criteria->limit);
        }

        $this->setResult($result);
    }
}