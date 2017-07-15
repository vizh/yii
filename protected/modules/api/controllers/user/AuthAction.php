<?php

namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use nastradamus39\slate\annotations\ApiContent;
use oauth\models\AccessToken;
use user\models\User;

/**
 * @ApiContent(
 *     title="Авторизация",
 *     description="
<b>Шаг 1</b>
Добавить следующий код на страницу с вызовом диалога авторизации
window.rIDAsyncInit = function() {
rID.init({
apiKey: <key>
});
// Additional initialization code here
};

// Load the SDK Asynchronously
(function(d){
var js, id = 'runetid-jssdk', ref = d.getElementsByTagName('script')[0];
if (d.getElementById(id)) {return;}
js = d.createElement('script'); js.id = id; js.async = true;
js.src = '//runet-id.com/javascripts/api/runetid.js';
ref.parentNode.insertBefore(js, ref);
}(document));

<b>Шаг 2</b>
Вызвать метод rID.login(); для создания окна авторизации

<b>Шаг 3</b>
После авторизации, пользователь будет переадресован на исходную страницу с GET-параметром token (переадресация происходит в рамках окна авторизации)

<b>Шаг 4</b>
После получения token - необходимо сделать запрос к API методу user/auth передав параметр token, полученный выше.
API вернет данные авторизованного пользователя (RUNET-ID, ФИО, Место работы, Контакты).

<b>При использовании php-API:</b>
$user = \RunetID\Api\User::model($api)->getByToken(token);
"
 * )
 */
class AuthAction extends Action
{
    public function run()
    {
        /** @var $accessToken AccessToken */
        $accessToken = AccessToken::model()
            ->byToken($this->getRequestParam('token'))
            ->find();

        if ($accessToken === null) {
            throw new Exception(222);
        }

        if ($accessToken->AccountId !== $this->getAccount()->Id) {
            throw new Exception(223);
        }

        $user = User::model()
            ->findByPk($accessToken->UserId);

        if ($user === null) {
            throw new Exception(224);
        }

        $usedData = $this
            ->getDataBuilder()
            ->createUser($user);

        $this->setResult($usedData);
    }
}
