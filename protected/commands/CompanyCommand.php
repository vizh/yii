<?php

use application\components\console\BaseConsoleCommand;

class CompanyCommand extends BaseConsoleCommand
{
    public function actionLogo()
    {
        $offset = 0;

        do {
            $criteria = new \CDbCriteria();
            $criteria->limit = 1000;
            $criteria->offset = $offset;
            $companies = \company\models\Company::model()->orderBy('"t"."Id"')->findAll($criteria);
            foreach ($companies as $company) {
                $logo = new \company\models\Logo($company);
                $original = $logo->getOriginal(true);
                if (strpos($original, 'none') !== false) {
                    var_dump($original);
                    //$company->getLogo()->save($original);
                }
            }
            $offset += 1000;
        } while (!empty($companies));

    }
}