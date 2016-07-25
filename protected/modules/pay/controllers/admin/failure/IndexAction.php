<?php
namespace pay\controllers\admin\failure;
use pay\models\Failure;

/**
 * Class IndexAction
 * @package pay\controllers\admin\failure
 */
class IndexAction extends \pay\components\Action
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->getController()->render('index', [
            'report' => Failure::getReport()
        ]);
    }
}
