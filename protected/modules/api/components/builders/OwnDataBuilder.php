<?php
namespace api\components\builders;

class OwnDataBuilder extends BaseDataBuilder
{

    /**
     * @param \user\models\User $user
     * @return \stdClass
     */
    public function BuildUserEmail($user)
    {
        $email = $user->getContactEmail();
        if (!empty($email)) {
            $this->user->Email = $email->Email;
        } else {
            $this->user->Email = $user->Email;
        }

        return $this->user;
    }
}
