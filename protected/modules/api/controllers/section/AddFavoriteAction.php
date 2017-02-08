<?php
namespace api\controllers\section;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class AddFavoriteAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Добавление в избранное.",
     *     description="",
     *     request=@Request(
     *          method="GET",
     *          url="/event/section/addFavorite",
     *          params={
     *              @Param(title="RunetId", type="", defaultValue="", description="Идентификатор."),
     *              @Param(title="SectionId", type="", defaultValue="", description="Идентификатор.")
     *          },
     *          response=@Response(body="{'Success': 'true'}")
     *     )
     * )
     */
      public function run()
      {
            $request = \Yii::app()->getRequest();
            $runetId = $request->getParam('RunetId');
            $user = \user\models\User::model()->byRunetId($runetId)->find();
            if ($user == null)
              throw new \api\components\Exception(202, [$runetId]);

            $sectionId = $request->getParam('SectionId');
            $section = \event\models\section\Section::model()->byDeleted(false)->findByPk($sectionId);
            if ($section === null)
              throw new \api\components\Exception(310, [$sectionId]);
            if ($section->EventId != $this->getEvent()->Id)
              throw new \api\components\Exception(311);

            $section->addToFavorite($user);
            $this->setSuccessResult();
      }
}