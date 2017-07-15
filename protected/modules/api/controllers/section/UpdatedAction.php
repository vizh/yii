<?php

namespace api\controllers\section;

use api\components\Action;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;

class UpdatedAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Section",
     *     title="Секции с залами",
     *     description="Список секций с залами и атрибутами.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/event/section/updated?SectionId=4109'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/section/updated",
     *          params={},
     *          response=@Response(body="['{$REPORT}']")
     *     )
     * )
     */
    public function run()
    {
        $sections = $this->getEvent()->Sections(['with' => ['LinkHalls.Hall', 'Attributes']]);

        $result = [];
        foreach ($sections as $section) {
            $result[] = $this->getAccount()->getDataBuilder()->createSection($section);
        }
        $this->setResult($result);
    }
}
