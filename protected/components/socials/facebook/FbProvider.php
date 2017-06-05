<?php
namespace application\components\socials\facebook;

\Yii::import('application.components.socials.facebook.vendor.facebook', true);

class FbProvider extends \Facebook
{
    /**
     * APP ID
     */
    const APP_ID = '201234113248910';
    /**
     * APP SECRET
     */
    const SECRET = '102257e6ef534fb163c7d1e7e31ffca7';
    /**
     * Id of the page "RUNET-ID"
     */
    const PAGE_ID = '260908277402290';

    /**
     * @var \Facebook
     */
    private static $_fb;

    /**
     * Возвращает объект Facebook
     * @return \Facebook
     */
    public static function getFb()
    {
        if (self::$_fb !== null) {
            return self::$_fb;
        }

        $fb = new \Facebook([
            'appId' => self::APP_ID,
            'secret' => self::SECRET,
            'cookie' => true
        ]);

        $userId = $fb->getUser();
        if (empty($userId)) {
            \Yii::app()->controller->redirect($fb->getLoginUrl([
                'scope' => 'create_event, manage_pages',
                'redirect_uri' => \Yii::app()->createAbsoluteUrl(\Yii::app()->controller->getRoute(), $_GET)
            ]));
        }

        return self::$_fb = $fb;
    }
}