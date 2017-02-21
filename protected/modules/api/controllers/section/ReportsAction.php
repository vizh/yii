<?php
namespace api\controllers\section;

use event\models\section\LinkUser;
use event\models\section\Section;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;

class ReportsAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Section",
     *     title="Доклады",
     *     description="Список докладов.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/event/section/reports?SectionId=4109'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/section/reports",
     *          params={
     *              @Param(title="SectionId", mandatory="Y", description="Идентификатор секции."),
     *              @Param(title="FromUpdateTime", mandatory="N", description="Время последнего обновления доклада, начиная с которого формировать список."),
     *              @Param(title="WithDeleted", mandatory="N", description="Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные доклады, иначе только не удаленные.")
     *          },
     *          response=@Response(body="['{$REPORT}']")
     *     )
     * )
     */
    public function run()
    {
        $section = Section::model()
            ->byEventId($this->getEvent()->Id)
            ->byDeleted(false)
            ->findByPk($this->getRequestParam('SectionId'));

        if ($section === null) {
            throw new \api\components\Exception(310, [$this->getRequestParam('SectionId')]);
        }

        $model = LinkUser::model()
            ->bySectionId($section->Id);

        if ($this->hasRequestParam('FromUpdateTime')) {
            $model->byUpdateTime($this->getRequestParam('FromUpdateTime'));
        }

        if ($this->getRequestParamBool('WithDeleted', false) !== true) {
            $model->byDeleted(false);
        }

        $linkedUsers = $model
            ->with([
                'User',
                'User.Employments.Company' => ['on' => '"Employments"."Primary"'],
                'Role',
                'Report'
            ])
            ->orderBy(['"t"."Order"' => SORT_ASC])
            ->findAll();

        $result = [];
        $builder = $this->getDataBuilder();
        foreach ($linkedUsers as $link) {
            $result[] = $builder->createReport($link);
        }

        $this->setResult($result);
    }
}
