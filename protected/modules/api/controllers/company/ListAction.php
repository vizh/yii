<?php
namespace api\controllers\company;

use api\components\Action;
use api\components\Exception;
use api\models\Account;
use application\components\CDbCriteria;
use company\models\Company;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;

class ListAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Company",
     *     title="Список",
     *     description="Список компаний из указанного кластера. Пока используется только РАЭК. В списке не присутствуют сотрудники компаний.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/company/list?Cluster=%D0%A0%D0%90%D0%AD%D0%9A'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/company/list",
     *          body="",
     *          params={
     *              @Param(title="Cluster", mandatory="Y", description="(enum[РАЭК]) – кластер, компании которого необходимо получить. В данный момент может принимать единственное значение: РАЭК."),
     *              @Param(title="Query", mandatory="N", description="Поисковая строка."),
     *              @Param(title="PageToken", mandatory="N", description="Указатель на следующую страницу, берется из результата последнего запроса, значения NextPageToken."),
     *              @Param(title="MaxResults", mandatory="N", description="MaxResults (число) - максимальное количество компаний в ответе, от 0 до 200. Если нужно загрузить более 200 участников, необходимо использовать постраничную загрузку.")
     *          },
     *          response=@Response(body="{'Companies':['{$COMPANY}']}")
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