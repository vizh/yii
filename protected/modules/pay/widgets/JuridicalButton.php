<?php
namespace pay\widgets;

/**
 * Created by PhpStorm.
 * User: ������
 * Date: 05.08.2015
 * Time: 12:05
 */
class JuridicalButton extends \CWidget
{
    public $account;

    public $url = ['/pay/juridical/create/'];

    public $htmlOptions = [
        'class' => 'btn'
    ];

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->render('juridical-button', ['account' => $this->account]);
    }

}