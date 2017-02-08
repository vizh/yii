<?php
namespace api\controllers\section;

use event\models\section\Favorite;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class FavoritesAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Список избранных",
     *     description="Список избранных секций.",
     *     request=@Request(
     *          method="GET",
     *          url="/event/section/favorites",
     *          params={
     *              @Param(title="RunetId", type="", defaultValue="", description="Идентификатор. Обязательно."),
     *              @Param(title="FromUpdateTime", type="", defaultValue="", description="(Y-m-d H:i:s) - время последнего обновления избранных секций пользователя, начиная с которого формировать список. Обязательно."),
     *              @Param(title="WithDeleted", type="", defaultValue="", description="Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные из избранного секции, иначе только не удаленные. Обязательно.")
     *          },
     *          response=@Response(body="{'SectionId': 'идентификатор секции','UpdateTime': 'время добавления или удаления в избранное','Deleted': 'true - если секция удалена из избранных секций пользователя, false - иначе.'}")
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