<?php
namespace application\components\auth;

use user\models\User;

/**
 * Class WebUser extends a classic web user
 */
class WebUser extends \CWebUser
{
    private $_currentUser;

    /**
     * @return User
     */
    public function getCurrentUser()
    {
        if (!$this->isGuest && $this->_currentUser === null) {
            $this->_currentUser = User::model()->findByPk($this->getId());
            if ($this->_currentUser !== null) {
                $this->_currentUser->refreshLastVisit();
            }
        }

        return $this->_currentUser;
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
