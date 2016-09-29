<?php
namespace api\controllers\section;

use event\models\section\Favorite;

class FavoritesAction extends \api\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();

        $model = Favorite::model()
            ->byUserId($this->getRequestedUser()->Id);

        $fromUpdateTime = $request->getParam('FromUpdateTime');
        if ($fromUpdateTime !== null) {
            $model->byUpdateTime($fromUpdateTime);
        }

        $withDeleted = $request->getParam('WithDeleted', false);
        if (!$withDeleted) {
            $model->byDeleted(false);
        }

        $criteria = new \CDbCriteria();
        $criteria->addCondition('"Section"."EventId" = :EventId');
        $criteria->with = ['Section' => ['together' => true, 'select'=> false]];
        $criteria->params = ['EventId' => $this->getEvent()->Id];

        $favorites = $model->findAll($criteria);
        $result = [];
        foreach ($favorites as $favorite)
        {
            $result[] = $this->getDataBuilder()->createFavorite($favorite);
        }
        $this->setResult($result);
    }
}