<?php
namespace competence\models\test\runet2014;

use user\models\User;

class A4 extends \competence\models\form\Input
{
    public function __construct($question, $scenario = '')
    {
        parent::__construct($question, $scenario);
        if (empty($this->value)) {
            /** @var User $user */
            $user = \Yii::app()->getUser()->getCurrentUser();
            if ($user->getEmploymentPrimary() !== null && !empty($user->getEmploymentPrimary()->Position)) {
                $this->value = $user->getEmploymentPrimary()->Position;
            }
        }
    }
}
