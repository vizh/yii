<?php
namespace application\components\auth;

/**
 * Class WebUser extends a classic web user
 */
class WebUser extends \CWebUser
{
    /** @var \user\models\User */
    private $_currentUser;

    /** @var \api\models\Account */
    private $_currentAccount;

    /**
     * @return \user\models\User
     */
    public function getCurrentUser()
    {
        if (!$this->isGuest && $this->_currentUser === null) {
            $this->_currentUser = \user\models\User::model()->findByPk($this->getId());
            if ($this->_currentUser !== null) {
                $this->_currentUser->refreshLastVisit();
            }
        }

        return $this->_currentUser;
    }

    public function getCurrentAccount()
    {
        if ($this->_currentAccount === null && \Yii::app()->hasModule('api')) {
            $this->_currentAccount = \api\components\WebUser::Instance()->getAccount();
        }

        return $this->_currentAccount;
    }

    public function setIsRecentlyLogin()
    {
        $this->setFlash('RecentlyLogin', true);
    }

    public function getIsRecentlyLogin()
    {
        return $this->getFlash('RecentlyLogin', false);
    }
}
