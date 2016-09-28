<?php
/**
 * @var \widget\components\Controller $this
 */

$clientScript = \Yii::app()->getClientScript();
$clientScript->registerPackage('runetid.auth');
$clientScript->registerScript('auth', '
    window.rIDAsyncInit = function() {
        rID.init({
            apiKey: $("meta[name = \"ApiKey\"]").attr("content")
        });
    };
    // Load the SDK Asynchronously
    (function(d){
        var js, id = "runetid - jssdk", ref = d.getElementsByTagName("script")[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement("script"); js.id = id; js.async = true;
        js.src = "//runet-id.com/javascripts/api/runetid.js";
        ref.parentNode.insertBefore(js, ref);
    }(document));
', \CClientScript::POS_HEAD);
?>
<div class="text-center">
    <p>Для регистрации на мероприятие, пожалуйста, авторизуйтесь под своим профилем на RUNET-ID. Если у вас еще нет аккаунта, создайте его, заполнив простую регистрационную форму!</p>
    <a href="#" class="btn btn-primary" onclick="rID.login(); return false;"><?=\Yii::t('app', 'Авторизуйтесь или зарегистрируйтесь.')?></a>
</div>