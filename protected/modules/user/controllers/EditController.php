<?php

class EditController extends \application\components\controllers\PublicMainController
{
    public function actions()
    {
        return [
            'index' => 'user\controllers\edit\IndexAction',
            'photo' => 'user\controllers\edit\PhotoAction',
            'employment' => 'user\controllers\edit\EmploymentAction',
            'contacts' => '\user\controllers\edit\ContactsAction',
            'profinterests' => '\user\controllers\edit\ProfessionalInterestsAction',
            'education' => 'user\controllers\edit\EducationAction',
            'document' => 'user\controllers\edit\DocumentAction'
        ];
    }
}
