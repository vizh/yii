<?php
namespace application\components\controllers;

trait AjaxController
{
    /**
     * @param \CAction $action
     * @return bool
     * @throws \CHttPException
     */
    protected function beforeAction($action)
    {
        if (!isset($_SERVER['HTTP_REFERER'])) {
            throw new \CHttpException(400, 'Доступ из вне сайта к этому действию запрещен!');
        }

        $url = parse_url($_SERVER['HTTP_REFERER']);
        $pattern = '/^[A-Za-z0-9-_\.]*'.RUNETID_HOST.'$/i';
        if (!preg_match($pattern, $url['host'])) {
            throw new \CHttpException(400, 'Доступ из вне сайта к этому действию запрещен!');
        }

        $request = \Yii::app()->getRequest();
        $hosts = [
            $request->getSchema().'admin.'.RUNETID_HOST,
            $request->getSchema().'partner.'.RUNETID_HOST,
        ];
        \Yii::app()->disableOutputLoggers();
        header('Access-Control-Allow-Origin: '.implode(' ', $hosts)); // allow cross-domain requests
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Content-Range, Content-Disposition, Content-Description');
        header("Access-Control-Allow-Methods: POST, GET");
        header("Connection: close");
        return parent::beforeAction($action);
    }

    /**
     * @param $result
     */
    public function returnJSON($result)
    {
        header('Content-type: text/json; charset=utf-8');
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        \Yii::app()->end();
    }
}