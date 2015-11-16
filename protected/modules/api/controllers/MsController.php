<?php

use api\models\ExternalUser;

class MsController extends \api\components\Controller
{
    /**
     * @param string $id
     * @return ExternalUser
     * @throws Exception
     */
    public function getExternalUser($id)
    {
        $user = ExternalUser::model()->byAccountId($this->getAccount()->Id)->byExternalId($id)->find();
        if ($user === null) {
            throw new Exception(202, [$id]);
        }
        return $user;
    }

    /**
     * @param string $externalId
     * @return string
     */
    public function generatePayHash($externalId)
    {
        $user = $this->getExternalUser($externalId);
        return md5($user->User->Id . 'ez?ZsXS*S$wNDKC153}COEGmle' . $externalId);
    }

    /**
     * @param string $externalId
     * @return string
     */
    public function getPayUrl($externalId)
    {
        return 'http://msdevcon16.runet-id.com/?id=' . $externalId . '&hash=' . $this->generatePayHash($externalId);
    }
}