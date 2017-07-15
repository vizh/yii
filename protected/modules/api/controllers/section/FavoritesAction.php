<?php

namespace api\controllers\section;

use api\components\Action;
use event\models\section\Favorite;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;

class FavoritesAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Section",
     *     title="Список избранных",
     *     description="Список избранных секций.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/event/section/favorites?RunetId=656438'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/section/favorites",
     *          params={
     *              @Param(title="RunetId", mandatory="Y", description="Идентификатор."),
     *              @Param(title="FromUpdateTime", mandatory="N", description="(Y-m-d H:i:s) - время последнего обновления избранных секций пользователя, начиная с которого формировать список."),
     *              @Param(title="WithDeleted", mandatory="N", description="Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные из избранного секции, иначе только не удаленные.")
     *          },
     *          response=@Response(body="['{$SECTION}']")
     *     )
     * )
     */
    public function run()
    {
        $model = Favorite::model()
            ->byUserId($this->getRequestedUser()->Id);

        if ($this->hasRequestParam('FromUpdateTime')) {
            $model->byUpdateTime($this->getRequestParam('FromUpdateTime'));
        }

        if ($this->getRequestParamBool('WithDeleted', false) !== true) {
            $model->byDeleted(false);
        }

        $criteria = new \CDbCriteria();
        $criteria->addCondition('"Section"."EventId" = :EventId');
        $criteria->with = ['Section' => ['together' => true, 'select' => false]];
        $criteria->params = ['EventId' => $this->getEvent()->Id];

        $favorites = $model
            ->findAll($criteria);

        $result = [];
        $builder = $this->getDataBuilder();

        foreach ($favorites as $favorite) {
            $result[] = $builder
                ->createFavorite($favorite);
        }

        $this->setResult($result);
    }
}
