<?php

namespace api\controllers\company;

use api\components\Action;
use api\components\Exception;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\ApiAction;

class EditAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Company",
     *     title="Изменение",
     *     description="Позволяет изменять данные о компании.",
     *     request=@Request(
     *          method="POST",
     *          url="/company/edit/",
     *          body="",
     *          params={
     *              @Param(title="CompanyId", description="Айди компании.", mandatory="Y"),
     *              @Param(title="Code", description="Псевдоним компании, подходящий для генерации ЧПУ.", mandatory="N"),
     *              @Param(title="Name", description="Краткое название компании.", mandatory="N"),
     *              @Param(title="FullName", description="Полное название компании.", mandatory="N"),
     *              @Param(title="Info", description="Краткое описание компании.", mandatory="N"),
     *              @Param(title="FullInfo", description="Подробное описание компании.", mandatory="N"),
     *              @Param(title="Cluster", description="Кластер, к которому принадлежит компания. Возможные значения: РАЭК", mandatory="N")
     *          }
     *      )
     * )
     */
    public function run()
    {
        $company = $this->getRequestedCompany();

        $company->setAttributes($_POST);

        if (false === $company->save()) {
            throw new Exception($company);
        }

        $this->setSuccessResult();
    }
}
