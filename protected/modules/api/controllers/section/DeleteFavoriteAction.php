<?php
namespace api\controllers\section;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;

class DeleteFavoriteAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Section",
     *     title="Удаление из избранного",
     *     description="Удаление секции из избранного.",
     *     samples={
    @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/event/section/deleteFavorite?RunetId=656438&SectionId=4107'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/section/deleteFavorite",
     *          params={
     *              @Param(title="RunetId", mandatory="Y", description="RunetId пользователя."),
     *              @Param(title="SectionId", mandatory="Y", description="Идентификатор секции.")
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