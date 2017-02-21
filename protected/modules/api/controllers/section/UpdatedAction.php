<?php
namespace api\controllers\section;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;

class UpdatedAction extends \api\components\Action
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
    $sections = $this->getEvent()->Sections(array('with' => array('LinkHalls.Hall', 'Attributes')));

    $result = array();
    foreach ($sections as $section)
    {
      $result[] = $this->getAccount()->getDataBuilder()->createSection($section);
    }
    $this->setResult($result);
  }
}
