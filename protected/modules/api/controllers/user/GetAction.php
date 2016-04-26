<?php
namespace api\controllers\user;

use api\components\Exception;
use api\models\Account;
use competence\models\Question;
use competence\models\Result;
use oauth\models\Permission;
use user\models\User;

/**
 * Class GetAction
 */
class GetAction extends \api\components\Action
{
    /**
     * @throws Exception
     */
    public function run()
    {
        $id = \Yii::app()->getRequest()->getParam('RunetId', null);
        if ($id === null) {
            $id = \Yii::app()->getRequest()->getParam('RocId', null);
        }

        $originalUser = User::model()->byRunetId($id)->find();
        if ($originalUser !== null) {
            $user = !empty($originalUser->MergeUserId) ? $originalUser->MergeUser : $originalUser;
            $this->getDataBuilder()->createUser($user);
            $this->getDataBuilder()->buildUserEmployment($user);
            $this->getDataBuilder()->buildUserEvent($user);
            $this->getDataBuilder()->buildUserData($user);
            $userData = $this->getDataBuilder()->buildUserBadge($user);

            # TODO: remove this "if" after svyaz16
            if ($this->getEvent()->IdName === 'svyaz16') {
                $attributes = [];

                $keys = [
                    'q1' => 'Какие выставки кроме Связь-2016, одновременно проходящие на ЦВК Экспоцентр, Вы планируете посетить?',
                    'q2' => 'Вы посещаете выставку Связь-2016 по профессиональным интересам или по личным?',
                    'q3' => 'Заинтересован принять участие в выставке в качестве экспонента',
                    'Custom_Number' => 'BarcodeNumber',
                    'city' => 'Страна',
                ];

                foreach ($userData->Attributes as $key => $value) {
                    $attributes[$keys[$key]] = $value;
                }

                foreach ([48 => 'TestRu', 49 => 'TestEn'] as $testId => $testName) {
                    $ruResults = Result::model()
                        ->byUserId($user->Id)
                        ->byTestId($testId)
                        ->find();

                    if (!$ruResults) {
                        continue;
                    }

                    $ruResults = $ruResults->getResultByData();

                    $questions = Question::model()->byTestId($testId)->findAll();

                    $questionsData = [];

                    foreach ($questions as $question) {
                        $questionsData[$question->Code]['title'] = $question->Title;

                        if (!key_exists('Values', $question->getFormData())) {
                            continue;
                        }

                        $values = $question->getFormData()['Values'];

                        foreach ($values as $value) {
                            $questionsData[$question->Code]['values'][$value->key] = $value->title;
                        }
                    }

                    foreach ($ruResults as $code => $result) {
                        if ($code === 'A10') {
                            continue;
                        }

                        if (is_array($result['value'])) {
                            foreach ($result['value'] as $value) {
                                $attributes[$testName][$questionsData[$code]['title']][] = $questionsData[$code]['values'][$value];
                            }
                        } else {
                            if (isset($questionsData[$code]['values'])) {
                                $result['value'] = $questionsData[$code]['values'][$result['value']];
                            }

                            $attributes[$testName][$questionsData[$code]['title']] = $result['value'];
                        }
                    }
                }

                $userData->Attributes = $attributes;
            }

            if ($this->hasContactsPermission($user, $userData)) {
                $userData = $this->getDataBuilder()->buildUserContacts($user);
            }

            if (!empty($originalUser->MergeUserId)) {
                $userData->RedirectRunetId = $originalUser->RunetId;
            }

            $this->setResult($userData);
        } else {
            throw new Exception(202, [$id]);
        }
    }

    /**
     * @param User   $user
     * @param object $userData
     * @return bool
     */
    private function hasContactsPermission(User $user, $userData)
    {
        switch ($this->getAccount()->Role) {
            case Account::ROLE_OWN:
                return true;
                break;

            case Account::ROLE_PARTNER_WOC:
                return false;
                break;

            default:
                $permissionModel = Permission::model()->byUserId($user->Id)->byAccountId($this->getAccount()->Id)
                    ->byDeleted(false);

                return isset($userData->Status) || $permissionModel->exists();
        }
    }
}
