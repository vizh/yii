<?php

namespace api\controllers\section;

use api\components\Action;
use api\components\Exception;
use event\models\section\Section;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;
use user\models\User;
use Yii;

class UserAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Section",
     *     title="Секции пользователя.",
     *     description="Список секций в которых учавствует пользователь. Секции возвращаются с залами и атрибутами.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/event/section/user?RunetId=656438'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/section/user",
     *          params={
     *              @Param(title="RunetId", mandatory="Y", description="RunetId пользователя."),
     *          },
     *          response=@Response(body="['{$SECTION}']")
     *     )
     * )
     */
    public function run()
    {
        $request = Yii::app()->getRequest();
        $runetId = $request->getParam('RunetId', null);
        if ($runetId === null) {
            $runetId = $request->getParam('RocId', null);
        }

        $user = User::model()->byRunetId($runetId)->find();
        if ($user === null) {
            throw new Exception(202, [$runetId]);
        }

        $result = [];

        $criteria = new \CDbCriteria();
        $criteria->condition = '"LinkUsers"."UserId" = :UserId';
        $criteria->params = ['UserId' => $user->Id];

        $sections = Section::model()
            ->byEventId($this->getEvent()->Id)->byDeleted(false)
            ->with(['LinkUsers' => ['together' => true]])->findAll($criteria);

        foreach ($sections as $section) {
            $result[] = $this->getAccount()->getDataBuilder()->createSection($section);
        }

        $this->setResult($result);
    }
}
