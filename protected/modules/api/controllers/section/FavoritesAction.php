<?php
namespace api\controllers\section;

use event\models\section\Favorite;

class FavoritesAction extends \api\components\Action
{
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