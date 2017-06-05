<?php

class UserajaxController extends \runetid\components\Controller
{
    public function actionSearch($term)
    {
        $users = \user\models\User::GetBySearch($term, 5);
        if (!empty($users)) {
            foreach ($users as $user) {
                $result[] = [
                    'label' => $this->renderPartial('user', ['user' => $user], true),
                    'value' => $user->GetFullName().', RUNET-ID '.$user->RocId,
                    'rocid' => $user->RocId
                ];
            }
        }
        echo json_encode($result);
    }
}

?>
