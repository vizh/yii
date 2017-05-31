<?php

namespace mail\components;

use api\models\Account;
use event\models\Event;
use mail\models\Layout;
use Twig_Environment;
use Twig_Loader_Array;
use Twig_SimpleFilter;
use user\models\User;

abstract class MailLayout extends Mail
{
    /**
     * Имя шаблона письма
     *
     * @return string
     */
    public function getLayoutName()
    {
        return Layout::OneColumn;
    }

    /**
     * @return User
     */
    abstract function getUser();

    /**
     * @inheritdoc
     */
    public function isHtml()
    {
        return true;
    }

    /**
     * Отображать ссылку на отписку
     *
     * @return bool
     */
    public function showUnsubscribeLink()
    {
        return true;
    }

    /**
     * @return null|Event
     */
    public function getRelatedEvent()
    {
        return null;
    }

    /**
     * Отображать footer письма
     *
     * @return bool
     */
    public function showFooter()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    protected function renderBody($view, $params)
    {
        $controller = new MailController($this);
        $layout = $controller->getLayoutFile($controller->layout);

        // Сначала рендерим содерживое письма, используя стандартные средства
        $body = $controller->renderFile($layout, ['content' => $controller->renderPartial($view, $params, true)], true);

        // Потом пытаемся обработать результат как Twig шаблон, но что бы не сломать старую логику,
        // в случае неудачи, возвращаем необработанный результат.
        try {
            $twig = new Twig_Environment(new Twig_Loader_Array(['index' => $body]));
            $twig->addFilter(new Twig_SimpleFilter('registrationHash', function (User $user, $accountApiKey) {
                    $account = Account::model()
                        ->byKey($accountApiKey)
                        ->find();

                    return substr(md5($user->RunetId.$account->Secret), 0, 16);
                })
            );

            return $twig->render('index', $params);
        } catch (\Throwable $e) {
            return $body;
        }
    }

    /**
     * @inheritdoc
     */
    public function getTo()
    {
        return $this->getUser()->Email;
    }

    /**
     * @inheritdoc
     */
    public function getToName()
    {
        return $this->getUser()->getFullName();
    }
}
