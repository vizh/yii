<?php
namespace api\controllers\section;

use event\models\section\LinkUser;
use event\models\section\Section;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class ReportsAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Доклады",
     *     description="Список докладов.
    User, Company, CustomText - всегда будет заполнено только одно из этих полей.
    Title, Thesis, FullInfo, Url - могут отсутствовать, если нет информации о докладе, либо роль не предполагает выступление с докладом (например, ведущий)",
     *     request=@Request(
     *          method="GET",
     *          url="/event/section/reports",
     *          body="",
     *          params={
     *              @Param(title="SectionId", description="Идентификатор секции. Обязательно"),
     *              @Param(title="FromUpdateTime ", description="Время последнего обновления доклада, начиная с которого формировать список."),
     *              @Param(title="WithDeleted", description="Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные доклады, иначе только не удаленные.")
     *          },
     *          response=@Response(body="[{
    'Id': 'идентификатор',
    'User': 'объект User (может быть пустым) - делающий доклад пользователь',
    'Company': 'объект Company (может быть пустым) - делающая доклад компания',
    'CustomText': 'произвольная строка с описанием докладчика',
    'SectionRoleId': 'идентификатор роли докладчика на этой секции',
    'SectionRoleTitle': 'название роли докладчика на этой секции',
    'Order': 'порядок выступления докладчиков',
    'Title': 'название доклада',
    'Thesis': 'тезисы доклада',
    'FullInfo': 'полная информация о докладе',
    'Url': 'ссылка на презентацию',
    'UpdateTime': 'дата/время последнего обновления',
    'Deleted': 'true - если секция удалена, false - иначе.'
}]")
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
