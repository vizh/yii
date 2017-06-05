<?php

use application\components\console\BaseConsoleCommand;
use job\models\Company;
use job\models\Job;

class JobCommand extends BaseConsoleCommand
{
    public function run($args)
    {
        $vacanciesData = file_get_contents(Yii::app()->getParams()['BuduGuru.jobsExportUrl']);
        $vacanciesData = json_decode($vacanciesData, true);

        foreach ($vacanciesData as $vacancyData) {
            $vacancy = Job::model()
                ->byUrl($vacancyData['url'])
                ->find();

            $company = Company::model()
                ->byName($vacancyData['companyName'])
                ->find();

            if ($vacancy === null) {
                $vacancy = new Job();
            }

            if ($company === null) {
                $company = new Company();
                $company->Name = $vacancyData['companyName'];
                $company->save();
                $company = Company::model()
                    ->byName($vacancyData['companyName'])
                    ->find();
            }

            $vacancy->Title = $vacancyData['title'];
            $vacancy->Url = $vacancyData['url'];
            $vacancy->CategoryId = 28; // Информационные технологии, интернет, телеком
            $vacancy->PositionId = 25; // Инженер
            $vacancy->CompanyId = $company->Id; // Вроде, не важно
            $vacancy->Text = $vacancyData['description'];
            $vacancy->SalaryFrom = $vacancyData['priceLo'];
            $vacancy->SalaryTo = $vacancyData['priceHi'];
            $vacancy->save();
        }
    }
}