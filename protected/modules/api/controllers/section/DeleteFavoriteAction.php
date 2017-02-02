<?php
namespace api\controllers\section;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;

class DeleteFavoriteAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Удаление из избранного.",
     *     description="",
     *     request=@Request(
     *          method="GET",
     *          url="/event/section/deleteFavorite",
     *          body="",
     *          params={
     *              @Param(title="RunetId", type="", defaultValue="", description="Идентификатор."),
     *              @Param(title="SectionId", type="", defaultValue="", description="Идентификатор.")
     *          },
     *          response="{'Success': 'true'}"
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
    if ($section == null)
      throw new \api\components\Exception(310, [$sectionId]);
    if ($section->EventId != $this->getEvent()->Id)
      throw new \api\components\Exception(311);

    $favorite = \event\models\section\Favorite::model()->byUserId($user->Id)->bySectionId($section->Id)->byDeleted(false)->find();
    if ($favorite !== null) {
        $favorite->Deleted = true;
        $favorite->save();
    }

    $this->setSuccessResult();
  }
}