<?php
namespace ruvents2\controllers;

use application\components\helpers\ArrayHelper;
use ruvents2\components\Controller;
use ruvents2\components\data\CDbCriteria;
use ruvents2\components\Exception;
use user\models\User;

class UsersController extends Controller
{
    const MAX_LIMIT = 50;

    public function actionList($query = null, $onlyVisible = true)
    {
        if (empty($query)) {
            throw Exception::createInvalidParam('query', 'Строка поиска не может быть пустой');
        }

        $users = [];

        $userModel = User::model();
        if (filter_var($query, FILTER_VALIDATE_EMAIL)) {
            $userModel->byEmail($query);
            if ($onlyVisible) {
                $userModel->byVisible(true);
            }
            $user = $userModel->find();
            if ($user !== null) {
                $users[] = $user;
            }
        } else {
            $userModel = $userModel->bySearch($query, null, true, $onlyVisible);
            $users = $userModel->findAll(
                CDbCriteria::create()
                    ->setLimit(self::MAX_LIMIT)
                    ->setWith([
                        'Employments' => ['together' => false],
                        'Employments.Company' => ['together' => false],
                        'LinkPhones.Phone' => ['together' => false]
                    ])
            );
        }

        $result = [];
        foreach ($users as $user) {
            $result[] = $this->getUserData($user);
        }

        $this->renderJson(['Users' => $result]);
    }

    /**
     * @param User $user
     * @return array
     */
    public function getUserData($user)
    {
        $data = ArrayHelper::toArray($user, ['user\models\User' => ['Id' => 'RunetId', 'LastName', 'FirstName', 'FatherName', 'Email']]);

        $employment = $user->getEmploymentPrimary();
        if ($employment !== null) {
            $data['Company'] = $employment->Company->Name;
            $data['Position'] = $employment->Position;
        }

        $phone = $user->getPhone();
        if (!empty($phone)) {
            $data['Phone'] = $phone;
        }
        return $data;
    }
}