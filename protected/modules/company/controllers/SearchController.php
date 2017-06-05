<?php

/**
 * Created by IntelliJ IDEA.
 * User: Alaris
 * Date: 2/21/13
 * Time: 12:31 PM
 * To change this template use File | Settings | File Templates.
 */
class SearchController extends \application\components\controllers\PublicMainController
{
    public function actionAjax($fullName)
    {
        $companyModel = \company\models\Company::model();
        $name = $companyModel->parseFullName($fullName);
        $result = [];
        if (mb_strlen($name) >= 2) {
            /** @var $companies \catalog\models\Company[] */
            $companies = $companyModel->bySearch($name)->findAll(['limit' => 10]);
            foreach ($companies as $company) {
            }
        }
        echo json_encode($result);
    }
}
