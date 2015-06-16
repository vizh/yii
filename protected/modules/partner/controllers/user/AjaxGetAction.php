<?php
namespace partner\controllers\user;

use user\models\User;

class AjaxGetAction extends \partner\components\Action
{
    public function run($term)
    {
        $model = User::model()->with(['Settings', 'Employments']);
        if (strpos($term, '@')) {
            $model->byEmail($term);
        } else {
            $model->bySearch($term, null, true, false)->limit(10);
        }

        $result = [];
        $users  = $model->findAll();
        /** @var User $user */
        foreach ($users as $user)
        {
            $employment = $user->getEmploymentPrimary();
            $result[] = [
                'value' => $user->RunetId,
                'label' => $user->getFullName().($employment !== null ? ' ('.$employment->Company->Name.')' : '')
            ];
        }
        echo json_encode($result);
    }
}