<?php

namespace application\widgets\alerts;

use application\components\web\Widget;
use user\models\User;

class UserVerify extends Widget
{
    /** @var null|User */
    private $user;

    /**
     * @var bool
     */
    private $show = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->user = \Yii::app()->getUser()->getCurrentUser();
        if ($this->user !== null && !$this->user->Verified) {
            $this->show = true;
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getIsHasDefaultResources()
    {
        return $this->show;
    }

    public function run()
    {
        if (!$this->show) {
            return;
        }
        $this->render('user-verify', ['user' => $this->user]);
    }
}