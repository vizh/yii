<?php
namespace oauth\components\social;

use contact\models\ServiceAccount;
use oauth\models\Social;
use user\models\LinkServiceAccount;
use user\models\User;

class Proxy implements ISocial
{
    /**
     * @var ISocial
     */
    protected $social;

    public function __construct($socialName, $redirectUrl = null)
    {
        switch ($socialName) {
            case ISocial::Facebook:
                $this->social = new Facebook($redirectUrl);
                break;
            case ISocial::Twitter:
                $this->social = new Twitter();
                break;
            case ISocial::Vkontakte:
                $this->social = new Vkontakte($redirectUrl);
                break;
            case ISocial::Google:
                $this->social = new Google($redirectUrl);
                break;
            case ISocial::PayPal:
                $this->social = new PayPal($redirectUrl);
                break;
            case ISocial::Linkedin:
                $this->social = new Linkedin($redirectUrl);
                break;
            case ISocial::Ok:
                $this->social = new Ok($redirectUrl);
                break;
            default:
                throw new \CHttpException(400, 'Не обнаружена авторизация по OAuth с идентификатором "'.$socialName.'"');
                break;
        }
    }

    public function getOAuthUrl()
    {
        return $this->social->getOAuthUrl();
    }

    public function isHasAccess()
    {
        return ($this->data !== null) || $this->social->isHasAccess();
    }

    protected $data = null;

    /**
     * @return Data
     */
    public function getData()
    {
        if ($this->data == null) {
            $this->data = $this->social->getData();
        }
        return $this->data;
    }

    public function getSocialId()
    {
        return $this->social->getSocialId();
    }

    /**
     * @param User $user
     */
    public function saveSocialData($user)
    {
        $this->saveSocial($user);
        if ($this->getData()->UserName !== null) {
            $this->saveServiceAccount($user);
        }
        $this->clearAccess();
    }

    /**
     * @param User $user
     */
    protected function saveSocial(User $user)
    {
        $social = Social::model()
            ->byUserId($user->Id)
            ->bySocialId($this->getSocialId())->find();
        if ($social === null) {
            $social = new Social();
            $social->UserId = $user->Id;
            $social->SocialId = $this->getSocialId();
        }
        $social->Hash = (string)$this->getData()->Hash;
        $social->save();
    }

    /**
     * @param User $user
     */
    protected function saveServiceAccount(User $user)
    {
        foreach ($user->LinkServiceAccounts as $link) {
            if ($link->ServiceAccount->TypeId == $this->getSocialId()) {
                $link->ServiceAccount->Account = $this->getData()->UserName;
                $link->ServiceAccount->save();
                return;
            }
        }

        $account = new ServiceAccount();
        $account->TypeId = $this->getSocialId();
        $account->Account = $this->getData()->UserName;
        $account->save();

        $link = new LinkServiceAccount();
        $link->ServiceAccountId = $account->Id;
        $link->UserId = $user->Id;
        $link->save();
    }

    /**
     * @return void
     */
    public function renderScript()
    {
        $this->social->renderScript();
    }

    /**
     * @return string
     */
    public function getSocialTitle()
    {
        return $this->social->getSocialTitle();
    }

    public function clearAccess()
    {
        $this->social->clearAccess();
    }
}
