<?php
namespace competence\models\test\runet2014;

use user\models\User;

class A3 extends \competence\models\form\Input
{
    public function __construct($question, $scenario = '')
    {
        parent::__construct($question, $scenario);
        if (empty($this->value)) {
            /** @var User $user */
            $user = \Yii::app()->getUser()->getCurrentUser();
            if ($user->getEmploymentPrimary() !== null && $user->getEmploymentPrimary()->Company !== null) {
                $this->value = $user->getEmploymentPrimary()->Company->Name;
            }
        }
    }

}
